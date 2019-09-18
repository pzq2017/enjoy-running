<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\Good;
use App\Models\GoodsCategory;
use App\Services\Storage\Oss\StorageService;
use App\Services\Storage\Oss\UrlService;
use Illuminate\Http\Request;

class GoodsController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.goods.index');
    }

    public function lists(Request $request)
    {
        $query = Good::with('category')
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->name.'%');
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            });

        $count = $query->count();
        $lists = $this->pagination($query, $request)->map(function ($list) {
            $list->categoryName = optional($list->category)->name;
            $list->imageUrl = UrlService::getUrl($list->image, ['width' => 100]);
            if ($list->type == 1) {
                $list->typeName = '实体';
            } elseif ($list->type == 2) {
                $list->typeName = '虚拟装扮';
            } elseif ($list->type == 3) {
                $list->typeName = '虚拟礼物';
            }
            $list->statusName = $list->status > 0 ? '已上架' : '未上架';
            return $list;
        });

        return $this->handleSuccess(['total' => $count, 'lists' => $lists]);
    }

    public function create()
    {
        $categories = GoodsCategory::where('status', 1)->get();

        return view('admin.goods.create', compact('categories'));
    }

    public function store(GoodsRequest $request, StorageService $storageService)
    {
        $goods = new Good();
        $goods->category_id = $request->category_id;
        $goods->name = $request->name;
        $goods->type = $request->type;
        if ($request->type == 1) {
            $goods->original_price = $request->original_price;
            $goods->price = $request->price;
        } else {
            if ($request->pay_method == 1) {
                $goods->mileage_coin = $request->mileage_coin;
            } elseif ($request->pay_method == 2) {
                $goods->gold_coin = $request->gold_coin;
            }
        }
        $goods->stock = $request->stock;
        $goods->applause_rate = $request->applause_rate ?? 0;
        $goods->intro = $request->intro;
        $goods->status = $request->status;
        $result = $goods->save();

        if ($result && $goods->id > 0) {
            $imagePath = $request->image_path;
            if ($imagePath) {
                $result = $storageService->move($imagePath, ['target_dir' => 'goods/'.$goods->id.'/lists']);
                if (!$result) {
                    return $this->handleFail('商品图片保存失败');
                } else {
                    $goods->image = $result;
                    $goods->save();
                }
            }
            return $this->handleSuccess();
        }

        return $this->handleFail('商品信息保存失败');
    }

    public function edit(Good $good)
    {
        $categories = GoodsCategory::where('status', 1)->get();

        return view('admin.goods.edit', compact('good', 'categories'));
    }

    public function update(GoodsRequest $request, Good $good, StorageService $storageService)
    {
        $image_path = $request->image_path;
        if (starts_with($image_path, 'temp/')) {
            $image_path = $storageService->move($image_path, ['target_dir' => 'goods/'.$good->id.'/lists']);
            if (!$image_path) {
                return $this->handleFail('商品图片保存失败');
            } else {
                $good->image = $image_path;
            }
        }

        $good->category_id = $request->category_id;
        $good->name = $request->name;
        $good->type = $request->type;
        if ($request->type == 1) {
            $good->original_price = $request->original_price;
            $good->price = $request->price;
            $good->mileage_coin = 0;
            $good->gold_coin = 0;
        } else {
            $good->original_price = 0;
            $good->price = 0;
            if ($request->pay_method == 1) {
                $good->mileage_coin = $request->mileage_coin;
                $good->gold_coin = 0;
            } elseif ($request->pay_method == 2) {
                $good->mileage_coin = 0;
                $good->gold_coin = $request->gold_coin;
            }
        }
        $good->stock = $request->stock;
        $good->applause_rate = $request->applause_rate ?? 0;
        $good->intro = $request->intro;
        $good->status = $request->status;
        $good->save();

        return $this->handleSuccess();
    }

    public function destroy()
    {

    }
}
