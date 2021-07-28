<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_restaurants')->insert([[
            'id' => 1,
            'user_id' => 1,
            'restaurant_id' => null,
            'role_id' => 1,
        ],[
            'id' => 2,
            'user_id' => 2,
            'restaurant_id' => 1,
            'role_id' => 2,
        ],[
            'id' => 3,
            'user_id' => 3,
            'restaurant_id' => 1,
            'role_id' => 3,
        ],[
            'id' => 4,
            'user_id' => 4,
            'restaurant_id' => null,
            'role_id' => 2,
        ]]);
    }
}
