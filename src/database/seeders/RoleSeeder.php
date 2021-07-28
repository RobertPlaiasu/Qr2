<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([[
            'id' => 1,
            'name' => 'administrator',
            'description' => 'Poate sa faca orice',
            'for_admin' => true,
        ],[
            'id' => 2,
            'name' => 'patron_restaurant',
            'description' => 'Detine un restaurant sau mai multe',
            'for_admin' => true,
        ],[
            'id' => 3,
            'name' => 'angajat_restaurant',
            'description' => 'Lucreaza la un restaurant sau mai multe',
            'for_admin' => false,
        ]]);

        DB::table('permission_role')->insert([[
            'permission_id'  => 1,
            'role_id' => 1,
        ],[
            'permission_id' => 2,
            'role_id' => 2,
        ],[
            'permission_id' => 3,
            'role_id' => 2,
        ],[
            'permission_id' => 4,
            'role_id' => 2,
        ],[
            'permission_id' => 5,
            'role_id' => 2,
        ],[
            'permission_id' => 6,
            'role_id' => 2,
        ],[
            'permission_id' => 8,
            'role_id' => 2,
        ],[
            'permission_id' => 7,
            'role_id' => 2,
        ],[
            'permission_id' => 6,
            'role_id' => 3,
        ]]);

    }
}
