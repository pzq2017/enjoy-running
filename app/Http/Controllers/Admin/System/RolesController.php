<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Admin\RolesRequest;
use App\Models\Roles;
use App\Models\SysMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RolesController extends AdminController
{
    public function index(Request $request)
    {
        return view('admin.system.roles.index');
    }

    public function lists(Request $request)
    {
        $query = Roles::where('id', '>', 0);
        $roles = $this->pagination($query, $request);

        return $this->handleSuccess(['total' => $query->count(), 'lists' => $roles]);
    }

    public function create()
    {
        $menuPrivileges = json_encode($this->menuPrivileges(0));

        return view('admin.system.roles.create', compact('menuPrivileges'));
    }

    public function store(RolesRequest $request)
    {
        Roles::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'privileges' => $request->privileges
        ]);

        return $this->handleSuccess();
    }

    public function edit(Roles $role)
    {
        $privileges = array();
        if ($role->privileges) {
            $privileges = explode(',', $role->privileges);
        }
        $menuPrivileges = json_encode($this->menuPrivileges(0, $privileges));

        return view('admin.system.roles.edit', compact('menuPrivileges', 'role'));
    }

    public function update(RolesRequest $request, Roles $role)
    {
        $role->name = $request->name;
        $role->desc = $request->desc;
        $role->privileges = $request->privileges;
        $role->updated_at = Carbon::now();
        $role->save();

        return $this->handleSuccess();
    }

    public function destroy(Roles $role)
    {
        $role->delete();

        return $this->handleSuccess();
    }

    private function menuPrivileges($menuId, $selectedPrivileges=array())
    {
        $sysMenus = SysMenu::sysMenusByPId($menuId)->select('id', 'name')->orderBy('sort', 'asc')->get()
                    ->map(function ($sysMenu) use ($selectedPrivileges) {
                        $children = $this->menuPrivileges($sysMenu->id, $selectedPrivileges);
                        if ($children) {
                            $sysMenu->open = true;
                            $sysMenu->children = $children;
                        } else {
                            $sysMenu->children = null;
                        }
                        if (in_array($sysMenu->id, $selectedPrivileges)) {
                            $sysMenu->checked = true;
                        }
                        return $sysMenu;
                    });
        return $sysMenus;
    }
}
