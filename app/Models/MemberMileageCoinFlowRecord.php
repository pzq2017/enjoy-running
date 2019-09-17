<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberMileageCoinFlowRecord extends Model
{
    protected $table = 'member_mileage_coin_flow_records';

    const FLOW_TYPE_RUNNING = 1;          //约跑
    const FLOW_TYPE_BUYING_GOODS = 2;     //购买礼品消耗里程币
}
