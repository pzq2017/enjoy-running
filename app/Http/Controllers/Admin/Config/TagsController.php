<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\TagRequest;
use App\Models\Tag;
use App\Services\Storage\Oss\StorageService;
use App\Services\Storage\Oss\UrlService;
use Illuminate\Http\Request;

class TagsController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.config.tag.index');
    }

    public function lists(Request $request)
    {
        $query = Tag::when($request->name, function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->name.'%');
                });

        $count = $query->count();
        $lists = $this->pagination($query, $request)->map(function ($list) {
            $list->icon_url = UrlService::getUrl($list->icon_path, ['width' => 64]);
            return $list;
        });

        return $this->handleSuccess(['total' => $count, 'lists' => $lists]);
    }

    public function create(Request $request)
    {
        return view('admin.config.tag.create');
    }

    public function store(TagRequest $request, StorageService $storageService)
    {
        $image_path = $storageService->move($request->image_path, ['target_dir' => 'label']);
        if (!$image_path) {
            return $this->handleFail('图片保存失败');
        } else {
            $icon_path = $image_path;
        }

        Tag::create([
            'name' => $request->name,
            'icon_path' => $icon_path,
            'sort' => $request->sort ?? 0,
        ]);

        return $this->handleSuccess();
    }

    public function edit(Tag $tag)
    {
        return view('admin.config.tag.edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag, StorageService $storageService)
    {
        $image_path = $request->image_path;
        if (starts_with($image_path, 'temp/')) {
            $tag->icon_path = $storageService->move($image_path, ['target_dir' => 'label']);
            if (!$tag->icon_path) {
                return $this->handleFail('图片保存失败');
            }
        }
        $tag->name = $request->name;
        $tag->sort = $request->sort ?? 0;
        $tag->save();

        return $this->handleSuccess();
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->handleSuccess();
    }

    public function updateStatus(Request $request, Tag $tag)
    {
        $tag->status = intval($request->publish);
        $tag->save();

        return $this->handleSuccess();
    }
}
