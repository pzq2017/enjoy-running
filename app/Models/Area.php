<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $table = 'areas';

    protected $fillable = ['pid', 'type', 'name', 'first_letter', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = ['isShow' => 'integer'];

    const TYPE_PROVINCE = 0;
    const TYPE_CITY = 1;
    const TYPE_DISTRICT = 2;
    const AREA_GRADE_NAME = [
        '省',
        '市',
        '区/县'
    ];

    public function scopePublishAreas($query, $type, $pid = 0, $order = 'asc')
    {
        return $query->where('type', $type)->where('isShow', 1)->where('pid', $pid)->orderBy('sort', $order);
    }

    public static function getType($pid)
    {
        if ($pid > 0) {
            $type = self::where('id', $pid)->value('type') + 1;
        } else {
            $type = self::TYPE_PROVINCE;
        }
        return $type;
    }

    public static function getPrevPid($pid)
    {
        if ($pid > 0) {
            $prev_pid = self::where('id', $pid)->value('pid');
        } else {
            $prev_pid = $pid;
        }
        return $prev_pid;
    }
}
