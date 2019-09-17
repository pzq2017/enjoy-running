<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherApplyInfo extends Model
{
    protected $table = 'teacher_apply_info';

    //审核状态
    const AUDIT_STATUS_PENDING = 1;      //待审核
    const AUDIT_STATUS_PASSED = 2;        //审核通过
    const AUDIT_STATUS_REFUSED = 3;       //审核未通过

    //入驻金支付状态
    const PAY_STATUS_PENDING = 0;       //等待支付
    const PAY_STATUS_SUCCESS = 1;       //支付成功
    const PAY_STATUS_FAILED = 2;        //支付失败

    public function getSexAttribute($value)
    {
        if ($value == 1) {
            return '男';
        } elseif ($value == 2) {
            return '女';
        }
        return '';
    }

    public function getAuditStatusNameAttribute()
    {
        if ($this->audit_status == self::AUDIT_STATUS_PENDING) {
            return '待审核';
        } elseif ($this->audit_status == self::AUDIT_STATUS_PASSED) {
            return '审核通过';
        } elseif ($this->audit_status == self::AUDIT_STATUS_REFUSED) {
            return '审核拒绝';
        }
        return '';
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'uid');
    }
}
