<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstitutionApplyInfo extends Model
{
    protected $table = 'institution_apply_info';

    //审核状态
    const AUDIT_STATUS_PENDING = 1;      //待审核
    const AUDIT_STATUS_PASSED = 2;        //审核通过
    const AUDIT_STATUS_REFUSED = 3;       //审核未通过

    //入驻金支付状态
    const PAY_STATUS_PENDING = 0;       //等待支付
    const PAY_STATUS_SUCCESS = 1;       //支付成功
    const PAY_STATUS_FAILED = 2;        //支付失败

    public function member()
    {
        $this->belongsTo(Member::class, 'uid');
    }
}
