<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/7
 * Time: 10:28
 */

namespace App\Http\Controllers\Api;

use App\Models\Member;
use App\Services\Storage\Oss\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends BaseController
{
    public function logout(Request $request)
    {
        auth()->logout();
        return $this->responseSuccess();
    }

    public function updateInfo(Request $request, StorageService $storageService)
    {
        $allowSetField = ['avatar', 'nickname', 'sex', 'birthday', 'signature'];
        $field = $request->field;
        if (!in_array($field, $allowSetField)) {
            return $this->responseErrorWithMessage('信息保存失败');
        }

        $value = $request->value;
        if ($field == 'avatar' && empty($value)) {
            return $this->responseErrorWithMessage('请上传头像');
        }

        $user = auth()->user();

        if ($field == 'avatar') {
            $avatar = $storageService->move($value, ['target_dir' => 'member/'.$user->id.'/avatar']);
            if (!$avatar) {
                return $this->responseErrorWithMessage('头像保存失败');
            }
            $value = $avatar;
        }

        if ($field == 'nickname' && empty($value)) {
            return $this->responseErrorWithMessage('请设置昵称');
        }

        Member::where('id', auth()->user()->id)->update([
            $field => $value
        ]);

        return $this->responseSuccess();
    }

    public function changePassword(Request $request)
    {
        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;
        $confirmPassword = $request->confirm_password;

        if (empty($oldPassword)) {
            return $this->responseErrorWithMessage('请输入旧密码！');
        }

        if (empty($newPassword)) {
            return $this->responseErrorWithMessage('请输入新密码！');
        }

        if ($newPassword != $confirmPassword) {
            return $this->responseErrorWithMessage('确认密码和新密码输入不一致！');
        }

        $user = auth()->user();

        if (!Hash::check($oldPassword, $user->loginPwd)) {
            return $this->responseErrorWithMessage('旧密码输入不正确！');
        }

        Member::where('id', $user->id)->update([
            'loginPwd' => Hash::make($newPassword),
        ]);

        return $this->responseSuccess();
    }

    public function teacherSettled(Request $request)
    {

    }

    public function institutionSettled(Request $request)
    {

    }
}
