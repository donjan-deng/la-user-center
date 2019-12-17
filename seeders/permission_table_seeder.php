<?php

declare(strict_types = 1);

use Hyperf\Database\Seeders\Seeder;
use App\Model;
use Hyperf\DbConnection\Db;

class PermissionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table((new Model\Permission())->getTable())->insert([
            [
                'id' => 1,
                'parent_id' => 0,
                'url' => 'auth',
                'name' => '系统管理',
                'display_name' => '系统管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'url' => '/users',
                'name' => '/user-center/users/get',
                'display_name' => '用户管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 3,
                'parent_id' => 1,
                'url' => '/roles',
                'name' => '/user-center/roles/get',
                'display_name' => '角色管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 4,
                'parent_id' => 1,
                'url' => '/permissions',
                'name' => '/user-center/permissions/get',
                'display_name' => '节点管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 5,
                'parent_id' => 2,
                'url' => '',
                'name' => '/user-center/users/post',
                'display_name' => '新建用户',
                'guard_name' => 'web'
            ], [
                'id' => 6,
                'parent_id' => 2,
                'url' => '',
                'name' => '/user-center/users/put',
                'display_name' => '编辑用户',
                'guard_name' => 'web'
            ],
            [
                'id' => 7,
                'parent_id' => 3,
                'url' => '',
                'name' => '/user-center/roles/post',
                'display_name' => '新建角色',
                'guard_name' => 'web'
            ], [
                'id' => 8,
                'parent_id' => 3,
                'url' => '',
                'name' => '/user-center/roles/put',
                'display_name' => '编辑角色',
                'guard_name' => 'web'
            ],
            [
                'id' => 9,
                'parent_id' => 4,
                'url' => '',
                'name' => '/user-center/permissions/post',
                'display_name' => '新建节点',
                'guard_name' => 'web'
            ],
            [
                'id' => 10,
                'parent_id' => 4,
                'url' => '',
                'name' => '/user-center/permissions/put',
                'display_name' => '编辑节点',
                'guard_name' => 'web'
            ],
            [
                'id' => 11,
                'parent_id' => 4,
                'url' => '',
                'name' => '/user-center/users/roles/put',
                'display_name' => '分配角色',
                'guard_name' => 'web'
            ]
        ]);
        $role = Model\Role::create([
                    'name' => '管理员',
                    'guard_name' => 'web'
        ]);
        $role->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);
        $user = Model\User::where('user_id',1)->first();
        $user->assignRole($role);
    }

}
