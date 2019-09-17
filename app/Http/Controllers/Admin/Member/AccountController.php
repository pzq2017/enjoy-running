<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\AccountRequest;
use App\Models\Member;
use App\Services\Storage\Oss\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.member.account.index');
    }

    public function lists(Request $request)
    {
         $query = Member::when($request->loginAccount, function ($query) use ($request) {
                    return $query->where('loginAccount', 'like', '%'.$request->loginAccount.'%');
                });

         $count = $query->count();
         $lists = $this->pagination($query, $request);

         return $this->handleSuccess(['total' => $count, 'lists' => $lists]);
    }

    public function create(Request $request)
    {
        return view('admin.member.account.create');
    }

    public function store(AccountRequest $request, StorageService $storageService)
    {
        $member = new Member();
        $member->loginAccount = $request->loginAccount;
        $member->loginPwd = Hash::make($request->loginPwd);
        $member->nickname = $request->nickname;
        $member->sex = $request->sex;
        $member->birthday = $request->birthday;
        $member->mobile = $request->loginAccount;
        $member->status = $request->status;
        $result = $member->save();

        if ($result && $member->id > 0) {
            $imagePath = $request->image_path;
            if ($imagePath) {
                $result = $storageService->move($imagePath, ['target_dir' => 'member'.$member->id.'/avatar']);
                if (!$result) {
                    return $this->handleFail('头像图片保存失败');
                } else {
                    $member->avatar = $result;
                    $member->save();
                }
            }
            return $this->handleSuccess();
        }

        return $this->handleFail('会员账户信息保存失败');
    }

    public function edit(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        return view('admin.member.account.edit', compact('member'));
    }

    public function update(AccountRequest $request, $id, StorageService $storageService)
    {
        $member = Member::findOrFail($id);

        $image_path = $request->image_path;
        if (starts_with($image_path, 'temp/')) {
            $image_path = $storageService->move($image_path, ['target_dir' => 'member'.$member->id.'/avatar']);
            if (!$image_path) {
                return $this->handleFail('图片保存失败');
            } else {
                $member->avatar = $image_path;
            }
        }

        $member->nickname = $request->nickname;
        $member->sex = $request->sex ?? 0;
        $member->birthday = $request->birthday;
        $member->save();

        return $this->handleSuccess();
    }

    public function show(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        return view('admin.member.account.show', compact('member'));
    }

    public function destroy(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $member->delete();

        return $this->handleSuccess();
    }

    public function activate(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $member->status = intval($request->activate) > 0 ? 1 : 0;
        $member->save();

        return $this->handleSuccess();
    }
}
