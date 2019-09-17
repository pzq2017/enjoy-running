<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\AdvertPositionsRequest;
use App\Models\AdvertPositions;
use Illuminate\Http\Request;

class AdvertPositionsController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.config.advert_position.index');
    }

    public function lists(Request $request)
    {
        $query = AdvertPositions::when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                });
        return $this->handleSuccess(['total' => $query->count(), 'lists' => $this->pagination($query, $request)]);
    }

    public function create(Request $request)
    {
        return view('admin.config.advert_position.create');
    }

    public function store(AdvertPositionsRequest $request)
    {
        AdvertPositions::create([
            'type' => AdvertPositions::TYPE_MOBILE_PLATFORM,
            'name' => $request->name,
            'width' => $request->width,
            'height' => $request->height,
        ]);
        return $this->handleSuccess();
    }

    public function edit(AdvertPositions $advertPosition)
    {
        return view('admin.config.advert_position.edit', compact('advertPosition'));
    }

    public function update(AdvertPositionsRequest $request, AdvertPositions $advertPosition)
    {
        $advertPosition->name = $request->name;
        $advertPosition->width = $request->width;
        $advertPosition->height = $request->height;
        $advertPosition->save();
        return $this->handleSuccess();
    }

    public function destroy(AdvertPositions $advertPosition)
    {
        if ($advertPosition->advert->count() > 0) {
            return $this->handleFail('当前广告位置已添加广告信息，请删除广告信息后再删除广告位置！');
        } else {
            $advertPosition->delete();
            return $this->handleSuccess();
        }
    }
}
