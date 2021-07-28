<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            CountySeeder::class,
            CitySeeder::class,
            RestaurantSeeder::class,
            UserSeeder::class,
            UserRestaurantSeeder::class,
            MenuSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
