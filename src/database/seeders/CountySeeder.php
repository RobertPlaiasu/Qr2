<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('counties')->insert([
            'id' => 1,
            'name' => 'Prahova',
        ],[
            'id' => 2,
            'name' => 'Bucuresti'
        ]);
    }
}
