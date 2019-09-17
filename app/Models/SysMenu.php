<?php

namespace App\Models;

use App\Models\SysMenuPrivileges;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysMenu extends Model
{
    use SoftDeletes;

    protected $table = 'sys_menus';

    protected $fillable = ['parentId', 'name', 'url', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSysMenusByPid($query, $parentId=0)
    {
        return $query->where('parentId', $parentId);
    }

    public function scopeSysMenusByUrl($query, $url)
    {
        return $query->where('url', $url);
    }
}
