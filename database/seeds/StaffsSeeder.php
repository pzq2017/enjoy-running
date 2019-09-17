<?php

use Illuminate\Database\Seeder;

class StaffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Staffs::create([
            'loginName' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'secretKey' => rand(1000, 9999),
            'staffRoleId' => -1,        //超级管理员
            'status' => \App\Models\Staffs::STATUS_ACTIVE,
        ]);
    }
}
