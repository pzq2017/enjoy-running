<?php

Route::get('/login', 'Admin\LoginController@index')->name('login');
Route::post('/login', 'Admin\LoginController@login')->name('checkLogin');

Route::group(['middleware' => ['admin.auth'], 'namespace' => 'Admin'], function () {
    Route::post('/sigupload/upload', 'SiguploadController@upload')->name('sigupload.upload');
    Route::get('/my_info', 'IndexController@myInfo')->name('my_info');
    Route::post('/change_my_info', 'IndexController@changeMyInfo')->name('change_my_info');
    Route::post('/change_password', 'IndexController@changePassword')->name('change_password');
    Route::get('/logout', 'IndexController@logout')->name('logout');

    /**
     * 首页
     */
    Route::get('/index', 'IndexController@index')->name('index');

    /**
     * 系统管理
     */
    Route::group(['namespace' => 'System', 'prefix' => '/system/', 'as' => 'system.'], function () {
        Route::resource('staff', 'StaffsController')->except('show');
        Route::get('staff/lists', 'StaffsController@lists')->name('staff.lists');
        Route::put('staff/{staff}/enabled', 'StaffsController@setEnabled')->name('staff.enabled');

        Route::resource('role', 'RolesController')->except('show');
        Route::get('role/lists', 'RolesController@lists')->name('role.lists');

        Route::get('/log/index', 'LogsController@index')->name('log.index');
        Route::get('/log/lists', 'LogsController@lists')->name('log.lists');
    });

    /**
     * 基础设置
     */
    Route::group(['namespace' => 'Config', 'prefix' => '/config/', 'as' => 'config.'], function () {
        /**
         * 广告信息管理
         */
        Route::resource('advert', 'AdvertController')->except('show');
        Route::get('advert/lists', 'AdvertController@lists')->name('advert.lists');
        Route::put('advert/{advert}/update_publish_date', 'AdvertController@updatePublishDate')->name('advert.update_publish_date');

        /**
         * 广告位置管理
         */
        Route::resource('advert_position', 'AdvertPositionsController')->except('show');
        Route::get('advert_position/lists', 'AdvertPositionsController@lists')->name('advert_position.lists');

        /**
         * 标签管理
         */
        Route::resource('tag', 'TagsController')->except('show');
        Route::get('tag/lists', 'TagsController@lists')->name('tag.lists');
        Route::put('tag/{tag}/publish', 'TagsController@updateStatus')->name('tag.publish');

        /**
         * 区域设置管理
         */
        Route::resource('area', 'AreaController')->except('show');
        Route::get('area/lists', 'AreaController@lists')->name('area.lists');
        Route::put('area/{area}/set_show', 'AreaController@setShow')->name('area.set_show');
    });

    /**
     * 会员管理
     */
    Route::group(['namespace' => 'Member', 'prefix' => '/member', 'as' => 'member.'], function () {
        /**
         * 账户管理
         */
        Route::get('account/lists', 'AccountController@lists')->name('account.lists');
        Route::put('account/{account}/activate', 'AccountController@activate')->name('account.activate');
        Route::resource('/account', 'AccountController');

        /**
         * 入驻管理
         */
        Route::group(['prefix' => '/settled', 'as' => 'settled.'], function () {
            /**
             * 教师
             */
            Route::get('teacher/lists', 'TeacherSettledController@lists')->name('teacher.lists');
            Route::resource('teacher', 'TeacherSettledController')->only(['index', 'show']);

            /**
             * 机构
             */
            Route::get('shop/lists', 'ShopSettledController@lists')->name('shop.lists');
            Route::resource('shop', 'ShopSettledController')->only(['index', 'show']);
        });
    });

    /**
     * 商品管理
     */
    Route::group(['namespace' => 'Goods'], function () {
        //商品信息
        Route::get('goods/lists', 'GoodsController@lists')->name('goods.lists');
        Route::get('goods/{good}/setting', 'GoodsController@setting')->name('goods.setting');
        Route::get('goods/{good}/setting/edit', 'GoodsController@settingEdit')->name('goods.setting.edit');
        Route::put('goods/{good}/setting/store', 'GoodsController@settingStore')->name('goods.setting.store');
        Route::delete('goods/{good}/setting/delete', 'GoodsController@settingDelete')->name('goods.setting.delete');
        Route::resource('goods', 'GoodsController')->except('show');

        //商品类别
        Route::group(['prefix' => '/goods', 'as' => 'goods.'], function () {
            Route::get('category/lists', 'GoodsCategoryController@lists')->name('category.lists');
            Route::resource('category', 'GoodsCategoryController')->except('show');
        });
    });

    /**
     * 订单管理
     */
    Route::group(['namespace' => 'Order', 'prefix' => '/order/', 'as' => 'order.'], function () {
        Route::get('index', 'OrderController@index')->name('index');
    });
});
