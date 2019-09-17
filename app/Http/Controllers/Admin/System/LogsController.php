<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\AdminController;
use App\Models\LogStaffLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogsController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.system.logs.index');
    }

    public function lists(Request $request)
    {
        $startDate = null;
        $endDate = null;
        if (!empty($request->dateRange)) {
            $dateArr = explode('~', $request->dateRange);
            $startDate = $dateArr[0];
            $endDate = $dateArr[1];
        }
        $query = LogStaffLogin::with('staff')
            ->whereHas('staff', function ($q) use ($request) {
                if ($request->loginName) {
                    $q->where('loginName', $request->loginName);
                }
            })
            ->when($startDate, function ($q) use ($startDate) {
                $startDate_time = Carbon::parse($startDate)->timestamp;
                $q->whereRaw("UNIX_TIMESTAMP(created_at) >= $startDate_time");
            })
            ->when($endDate, function ($q) use ($endDate) {
                $endDate_time = Carbon::parse($endDate)->timestamp;
                $q->whereRaw("UNIX_TIMESTAMP(created_at) < $endDate_time");
            });
        $count = $query->count();
        $logs = $this->pagination($query, $request);

        return $this->handleSuccess(['total' => $count, 'lists' => $logs]);
    }
}
