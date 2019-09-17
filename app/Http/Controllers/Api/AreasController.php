<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/13
 * Time: 12:54
 */

namespace App\Http\Controllers\Api;


use App\Models\Area;
use Illuminate\Http\Request;

class AreasController extends BaseController
{
    public function index(Request $request)
    {
        $areas = collect([]);

        if ($request->type == Area::TYPE_PROVINCE) {
            $areas = Area::publishAreas($request->type)->get();
        } elseif ($request->type == Area::TYPE_CITY) {
            $areas = Area::publishAreas($request->type, $request->pid)->get();
        } elseif ($request->type == Area::TYPE_DISTRICT) {
            $areas = Area::publishAreas($request->type, $request->pid)->get();
        }

        return $this->responseSuccessWithData($areas);
    }
}