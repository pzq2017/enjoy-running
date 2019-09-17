<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdPwdRequest;
use App\Models\Staffs;
use App\Models\SysMenu;
use App\Services\Storage\Oss\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IndexController extends AdminController
{
    public function index()
    {
        $sidebar_menus = SysMenu::sysMenusByPid(0)->orderBy('sort', 'asc')->get();
        $sidebar_menus->map(function ($menu) {
            $subChildMenu = SysMenu::sysMenusByPid($menu->id)->orderBy('sort')->get()->map(function ($subMenu) {
                $subMenu->subThirdMenu = SysMenu::SysMenusByPid($subMenu->id)->orderBy('sort')->get();
                return $subMenu;
            });
            $menu->subChildMenu = $subChildMenu;
            return $menu;
        });

        return view('admin.index', compact('sidebar_menus'));
    }

    public function changePassword(UpdPwdRequest $request)
    {
        $user = admin_auth();
        $res = \Hash::check($request->oldPwd, $user->password);
        if (!$res) {
            return $this->handleFail('原始密码输入错误');
        } else {
            $user->password = \Hash::make($request->newPwd);
            $user->setRememberToken(Str::random(60));
            $user->save();
            Auth::guard('admin')->login($user);
            return $this->handleSuccess();
        }
    }

    public function myInfo()
    {
        $user = admin_auth();
        return view('admin.myinfo', compact('user'));
    }

    public function changeMyInfo(Request $request, StorageService $storageService)
    {
        $user = admin_auth();
        if (!empty($user)) {
            $staff = Staffs::findOrFail($user->id);
            if (!empty($staff)) {

                $staffPhoto = $request->staffPhoto;
                if (starts_with($staffPhoto, 'temp/')) {
                    $staff->staffPhoto = $storageService->move($staffPhoto, ['target_dir' => 'staff/avatar']);
                }

                $staff->staffName = $request->staffName;
                $staff->staffPhone = $request->staffPhone;
                $staff->staffEmail = $request->staffEmail;
                $staff->save();

                return $this->handleSuccess();
            }
        }
        return $this->handleFail('更改个人资料信息失败');
    }

    public function clearCache()
    {
        \Artisan::call('qk:clear');
        return $this->handleSuccess();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return $this->handleSuccess();
    }
}
