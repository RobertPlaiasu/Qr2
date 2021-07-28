<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\City;
use App\Models\County;
use PermissionSeeder;
use UserSeeder;
use RoleSeeder;
use UserRestaurantSeeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

trait DataForAuthorizationTrait
{

    private function getTheAdminUser() :User
    {
        $this->seed([PermissionSeeder::class,UserSeeder::class,RoleSeeder::class,UserRestaurantSeeder::class]);
        return User::first();
    }

    private function insertAllTheSeedersAndReturnUsers() :Collection
    {
        $this->seed();
        return User::all();
    }

    private function getTheRestaurantOwnerWithoutRestaurant() :User
    {
        $this->seed([PermissionSeeder::class,UserSeeder::class,RoleSeeder::class,UserRestaurantSeeder::class]);
        return User::where('name','Patron')->first();
    }

    private function makePermissions() :Collection
    {
        return Permission::factory()->count(3)->create();
    }

    private function makeFactories() :array
    {
        return [
                'user' => User::factory()->create(),
                'role' => Role::factory()->create(),
                'restaurant' => Restaurant::factory()->create(),
               ];
    }

    private function makeCity() :City
    {
        return City::factory()->for(County::factory())->create();
    }
}