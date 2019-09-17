<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/12
 * Time: 14:56
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    protected function pagination($query, $request)
    {
        $curPage = $request->page ?? 1;
        $request->limit = $request->limit ?? 25;
        $request->offset = ($curPage - 1) * $request->limit;
        $request->order = $request->order ?? 'desc';
        $request->field = $request->field ?? 'updated_at';

        return $query->skip($request->offset)
            ->take($request->limit)
            ->orderBy($request->field, $request->order)
            ->get();
    }

    protected function handleFail($error='', $status=200)
    {
        return response()->json([
            'status' => 'error',
            'info' => $error,
        ], $status);
    }

    protected function handleSuccess($message='')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }

    protected function handleResult($resCode, $message=null, $resStatus=200)
    {
        $res = ['code' => $resCode];
        if (!is_null($message)) $res['message'] = $message;
        return response()->json($res, $resStatus);
    }
}