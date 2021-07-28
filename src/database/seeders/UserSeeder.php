<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'id' => 1,
            'name' => 'Robert Plaiasu',
            'email' => 'robertplaiasu03@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$hOARm.d.j1.Nv0LKQlpPLOSxjvPOBHTvMGLdLOdQ3rbi6WikU3Kua', // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ],[
            'id' => 2,
            'name' => 'Grigorescu Alexandru',
            'email' => 'grigo@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$hOARm.d.j1.Nv0LKQlpPLOSxjvPOBHTvMGLdLOdQ3rbi6WikU3Kua', // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ],[
            'id' => 3,
            'name' => 'Angajatul X',
            'email' => 'angajat@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$hOARm.d.j1.Nv0LKQlpPLOSxjvPOBHTvMGLdLOdQ3rbi6WikU3Kua', // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ],[
            'id' => 4,
            'name' => 'Patron',
            'email' => 'patron@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$hOARm.d.j1.Nv0LKQlpPLOSxjvPOBHTvMGLdLOdQ3rbi6WikU3Kua', // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]]);
    }
}
