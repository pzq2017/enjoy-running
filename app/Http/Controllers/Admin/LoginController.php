<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\LogStaffLogin;
use App\Models\Staffs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends AdminController
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(LoginRequest $request)
    {
        $fields = $request->only(['loginName']);
        $fields['password'] = $request->get('loginPwd');
        if ($this->guard()->attempt($fields, true)) {
            $staff = $this->guard()->user();
            if ($staff->status != Staffs::STATUS_ACTIVE) {
                $this->guard()->logout();
                return $this->handleFail('账号已被禁止登录');
            } else {
                $staff->lastTime = Carbon::now();
                $staff->lastIp = $request->getClientIp();
                $staff->save();

                //记录登录日志
                LogStaffLogin::create([
                    'staffId' => $staff->id,
                    'loginIp' => $staff->lastIp,
                ]);

                //获取角色权限


                return $this->handleSuccess();
            }
        } else {
            return $this->handleFail('账号或密码错误');
        }
    }

    private function guard($name='admin')
    {
        return Auth::guard($name);
    }
}
