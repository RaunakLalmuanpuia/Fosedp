<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Permission::query()->upsert([
//            ['id'=>1,'name' => 'create:application'],
//            ['id'=>2,'name' => 'edit:application'],
//            ['id'=>3,'name' => 'view:application'],
//            ['id'=>4,'name' => 'view-any:application'],
//            ['id'=>5,'name' => 'delete:application'],
//            ['id'=>6,'name' => 'verify:application'],
//            ['id'=>7,'name' => 'approve:application'],
//            ['id'=>8,'name' => 'reject:application'],
//            ['id'=>9, 'name' => 'forward:application'],
//            ['id'=>10,'name' => 'backward:application']
//        ], ['name']);
//
//        Role::query()->upsert([
//            ['id'=>1,'name' => 'Planning'],
//            ['id'=>2,'name' => 'DC'],
//            ['id'=>3,'name' => 'Department'],
//            ['id'=>4,'name' => 'Office'],
//            ['id'=>5,'name' => 'Executive'],
//        ], ['name']);
//
//        RolePermission::query()->upsert([
//            ['role_id'=>1, 'permission_id' => 1],
//            ['role_id'=>1, 'permission_id' => 2],
//            ['role_id'=>1, 'permission_id' => 3],
//            ['role_id'=>1, 'permission_id' => 4],
//            ['role_id'=>1, 'permission_id' => 5],
//            ['role_id'=>1, 'permission_id' => 6],
//            ['role_id'=>1, 'permission_id' => 7],
//            ['role_id'=>1, 'permission_id' => 8],
//            ['role_id'=>1, 'permission_id' => 9],
//            ['role_id'=>1, 'permission_id' => 10],
//
//            ['role_id'=>2, 'permission_id' => 1],
//            ['role_id'=>2, 'permission_id' => 2],
//            ['role_id'=>2, 'permission_id' => 3],
//            ['role_id'=>2, 'permission_id' => 4],
//            ['role_id'=>2, 'permission_id' => 5],
//            ['role_id'=>2, 'permission_id' => 6],
//            ['role_id'=>2, 'permission_id' => 7],
//            ['role_id'=>2, 'permission_id' => 8],
//            ['role_id'=>2, 'permission_id' => 9],
//
//            ['role_id'=>3, 'permission_id' => 9],
//            ['role_id'=>3, 'permission_id' => 10],
//
//            ['role_id'=>4, 'permission_id' => 10],
//
//            ['role_id'=>5, 'permission_id' => 6],
//            ['role_id'=>5, 'permission_id' => 7],
//            ['role_id'=>5, 'permission_id' => 8],
//            ['role_id'=>5, 'permission_id' => 9],
//            ['role_id'=>5, 'permission_id' => 10],
//
//        ],['role_id','permission_id']);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        \Spatie\Permission\Models\Role::query()->upsert([
            ['id'=>1,'name'=>'admin','guard_name'=>'web'],
            ['id'=>2,'name'=>'dc','guard_name'=>'web'],
            ['id'=>3,'name'=>'planning','guard_name'=>'web'],
            ['id'=>4,'name'=>'department','guard_name'=>'web'],
            ['id'=>5,'name'=>'office','guard_name'=>'web'],
            ['id'=>6,'name'=>'executive','guard_name'=>'web'],
            ['id'=>7,'name'=>'governing','guard_name'=>'web'],
            ['id'=>8,'name'=>'dc-verifier','guard_name'=>'web'],
            ['id'=>9,'name'=>'dc-approval','guard_name'=>'web'],
        ], ['name']);
//        \Spatie\Permission\Models\Permission::query()->upsert([
//            ['id'=>1,'name'=>'dc.application.verify','guard_name'=>'web'],
//            ['id'=>2,'name'=>'dc.application.approve','guard_name'=>'web'],
//        ], ['name']);

    }
}
