<?php

use App\Models\SysMenu;
use Illuminate\Database\Seeder;

class SysMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!$this->command->confirm('是否要重置平台系统菜单？')) {
            exit;
        }
        \DB::table('sys_menus')->truncate();

        $sys_first_menus = [
            [
                'name' => '系统管理',
                'url' => '',
            ],
            [
                'name' => '基础设置',
                'url' => '',
            ],
            [
                'name' => '会员管理',
                'url' => '',
            ],
            [
                'name' => '商品管理',
                'url' => '',
            ],
            [
                'name' => '订单管理',
                'url' => '',
            ],
        ];
        $sys_second_menus = [
            '系统管理' => [
                [
                    'name' => '管理员管理',
                    'url' => route('admin.system.staff.index'),
                ],
                [
                    'name' => '角色管理',
                    'url' => route('admin.system.role.index'),
                ],
                [
                    'name' => '登录日志',
                    'url' => route('admin.system.log.index'),
                ],
            ],
            '基础设置' => [
                [
                    'name' => '广告管理',
                    'url' => route('admin.config.advert.index'),
                ],
                [
                    'name' => '广告位置',
                    'url' => route('admin.config.advert_position.index'),
                ],
                [
                    'name' => '标签管理',
                    'url' => route('admin.config.tag.index'),
                ],
                [
                    'name' => '地区管理',
                    'url' => route('admin.config.area.index'),
                ],
            ],
            '会员管理' => [
                [
                    'name' => '账户管理',
                    'url' => route('admin.member.account.index'),
                ],
                [
                    'name' => '入驻管理',
                    'url' => '',
                ],
            ],
            '商品管理' => [
                [
                    'name' => '商品管理',
                    'url' => route('admin.goods.index'),
                ],
                [
                    'name' => '商品分类',
                    'url' => route('admin.goods.category.index'),
                ],
            ],
            '订单管理' => [
                [
                    'name' => '订单管理',
                    'url' => '',
                ],
            ],
        ];

        $sys_third_menus = [
            '入驻管理' => [
                [
                    'name' => '教师入驻',
                    'url' => route('admin.member.settled.teacher.index'),
                ],
                [
                    'name' => '机构管理',
                    'url' => route('admin.member.settled.shop.index'),
                ],
            ],
        ];

        //创建一级菜单
        foreach ($sys_first_menus as $menu) {
            SysMenu::create([
                'parentId' => 0,
                'name' => $menu['name'],
                'url' => $menu['url'],
            ]);
        }

        //创建二级菜单
        foreach ($sys_second_menus as $key => $menus) {
            $parentId = SysMenu::where('name', $key)->where('parentId', 0)->value('id');
            if ($parentId > 0) {
                foreach ($menus as $menu) {
                    SysMenu::create([
                        'parentId' => $parentId,
                        'name' => $menu['name'],
                        'url' => $menu['url'],
                    ]);
                }
            }
        }

        //创建三级菜单
        foreach ($sys_third_menus as $key => $menus) {
            $parentId = SysMenu::where('name', $key)->where('parentId', '>', 0)->value('id');
            if ($parentId > 0) {
                foreach ($menus as $menu) {
                    SysMenu::create([
                        'parentId' => $parentId,
                        'name' => $menu['name'],
                        'url' => $menu['url'],
                    ]);
                }
            }
        }
    }
}
