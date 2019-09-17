<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/7
 * Time: 11:26
 */

/**
 * 发送短信验证码
 */
Route::post('sms', 'AuthController@smsCode');

/**
 * 登录、注册、忘记密码
 */
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('find_password', 'AuthController@findPassword');

/**
 * 请求需要带上token
 */
Route::group(['middleware' => [ 'refresh_token']], function () {
    /**
     * 上传文件
     */
    Route::post('upload_media', 'FileController@UploadMedia');

    /**
     * 标签
     */
    Route::get('tags', 'TagsController@index');

    /**
     * 区域
     */
    Route::get('areas', 'AreasController@index');

    /**
     * 会员操作
     */
    Route::group(['prefix' => 'member'], function () {
        Route::get('logout', 'MemberController@logout');
        Route::put('update_info', 'MemberController@updateInfo');
        Route::put('change_password', 'MemberController@changePassword');

        Route::post('settled/teacher', 'MemberController@teacherSettled');
        Route::post('settled/institution', 'MemberController@institutionSettled');
    });
});
