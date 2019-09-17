<?php

namespace App\Models;

use App\Models\Staffs;
use Illuminate\Database\Eloquent\Model;

class LogStaffLogin extends Model
{
    protected $table = 'log_staff_login';

    protected $fillable = ['staffId', 'loginIp'];

    public function staff()
    {
    	return $this->belongsTo(Staffs::class, 'staffId');
    }
}
