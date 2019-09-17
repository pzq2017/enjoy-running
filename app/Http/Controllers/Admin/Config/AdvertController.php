<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\AdvertRequest;
use App\Models\AdvertPositions;
use App\Models\Advert;
use App\Services\Storage\Oss\StorageService;
use App\Services\Storage\Oss\UrlService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdvertController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.config.advert.index', [
            'advert_positions' => AdvertPositions::all()
        ]);
    }

    public function lists(Request $request)
    {
        $query = Advert::with('advert_positions')
                ->when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                })
                ->when($request->position_id > 0, function ($query) use ($request) {
                    return $query->whereHas('advert_positions', function ($q) use ($request) {
                        $q->where('id', $request->position_id);
                    });
                });

        $count = $query->count();
        $lists = $this->pagination($query, $request)->map(function ($list) {
            $list->advert_url = UrlService::getUrl($list->image_path, ['width' => 100]);
            return $list;
        });

        return $this->handleSuccess(['total' => $count, 'lists' => $lists]);
    }

    public function create(Request $request)
    {
        return view('admin.config.advert.create', [
            'advert_positions' => AdvertPositions::all()
        ]);
    }

    public function store(AdvertRequest $request, StorageService $storageService)
    {
        $image_path = $storageService->move($request->image_path, ['target_dir' => 'advert']);
        if (!$image_path) {
            return $this->handleFail('图片保存失败');
        }

        Advert::create([
            'position_id' => $request->position_id,
            'name' => $request->name,
            'image_path' => $image_path,
            'url' => $request->url ?? '',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'sort' => $request->sort ?? 0,
        ]);

        return $this->handleSuccess();
    }

    public function edit(Advert $advert)
    {
        $advert_position_size = '';
        $advert_positions = AdvertPositions::all();
        $advert_positions->each(function ($advert_position) use ($advert, &$advert_position_size) {
            if ($advert_position->id ==  $advert->position_id) {
                $advert_position_size = $advert_position->width . '*' . $advert_position->height;
            }
        });

        return view('admin.config.advert.edit', compact('advert_positions', 'advert', 'advert_position_size'));
    }

    public function update(AdvertRequest $request, Advert $advert, StorageService $storageService)
    {
        $image_path = $request->image_path;
        if (starts_with($image_path, 'temp/')) {
            $advert->image_path = $storageService->move($image_path, ['target_dir' => 'advert']);
            if (!$advert->image_path) {
                return $this->handleFail('图片保存失败');
            }
        }
        $advert->position_id = $request->position_id;
        $advert->name = $request->name;
        $advert->url = $request->url ?? '';
        $advert->start_date = $request->start_date;
        $advert->end_date = $request->end_date;
        $advert->sort = $request->sort ?? 0;
        $advert->save();

        return $this->handleSuccess();
    }

    public function destroy(Advert $advert)
    {
        $advert->delete();

        return $this->handleSuccess();
    }

    public function updatePublishDate(Request $request, Advert $advert)
    {
        $advert->publish_date = intval($request->publish) > 0 ? Carbon::now() : null;
        $advert->save();

        return $this->handleSuccess();
    }
}
