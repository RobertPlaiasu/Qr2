<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invitations')->insert([[
            'id' => 1,
            'role_id' => '3',
            'restaurant_id' => '1',
            'email' => 'grigo@gmail.com'
        ]]);
    }
}
