<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Admin\AdminController;
use App\Models\TeacherApplyInfo;
use Illuminate\Http\Request;

class TeacherSettledController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.member.settled.teacher.index');
    }

    public function lists(Request $request)
    {
         $query = TeacherApplyInfo::when($request->loginAccount, function ($query) use ($request) {
                    return $query->where('loginAccount', 'like', '%'.$request->loginAccount.'%');
                });

        $total = $query->count();
        $lists = $this->pagination($query, $request)->map(function ($list) {
            $list->audit_status = $list->audit_status_name;
            return $list;
        });

         return $this->handleSuccess(['total' => $total, 'lists' => $lists]);
    }

    public function show(Request $request, $id)
    {
        $apply = TeacherApplyInfo::with('member')->where('uid', $id)->first();

        return view('admin.member.settled.teacher.show', compact('apply'));
    }
}
