<?php

namespace App\Http\Controllers\Admin\Goods;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\GoodsCategoryRequest;
use App\Models\GoodsCategory;
use Illuminate\Http\Request;

class GoodsCategoryController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.goods.category.index');
    }

    public function lists(Request $request)
    {
        $query = GoodsCategory::when($request->name, function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->name.'%');
        });

        $count = $query->count();
        $lists = $this->pagination($query, $request);

        return $this->handleSuccess(['total' => $count, 'lists' => $lists]);
    }

    public function create()
    {
        return view('admin.goods.category.create');
    }

    public function store(GoodsCategoryRequest $request)
    {
        GoodsCategory::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return $this->handleSuccess();
    }

    public function edit(GoodsCategory $category)
    {
        return view('admin.goods.category.edit', compact('category'));
    }

    public function update(GoodsCategoryRequest $request, GoodsCategory $category)
    {
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return $this->handleSuccess();
    }

    public function destroy(GoodsCategory $category)
    {
        if ($category->goods()->count() > 0) {
            return $this->handleFail('当前分类已被指定为商品的类别，不能被删除');
        }

        $category->delete();

        return $this->handleSuccess();
    }
}
