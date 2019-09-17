<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/13
 * Time: 11:10
 */

namespace App\Http\Controllers\Api;


use App\Models\Tag;
use App\Services\Storage\Oss\UrlService;
use Illuminate\Http\Request;

class TagsController extends BaseController
{
    public function index(Request $request)
    {
        $tags = Tag::publish()->orderBy('sort', 'desc')->get()->map(function ($tag) {
            $tag->icon_url = UrlService::getUrl($tag->icon_path);
            return $tag;
        });

        return $this->responseSuccessWithData($tags);
    }
}