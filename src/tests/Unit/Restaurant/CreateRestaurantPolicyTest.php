<?php

namespace Tests\Unit\Restaurant;

use Tests\TestCase;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\UserRestaurant;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateRestaurantPolicyTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function if_user_has_a_owner_restaurant_role_restaurants_acces_allowed_create() :void 
    {
        $user = $this->getTheRestaurantOwnerWithoutRestaurant();
        $this->assertCount(0,Restaurant::all());
        $this->assertCount(1,UserRestaurant::where('user_id',$user->id)
        ->where('role_id',Role::where('name','patron_restaurant')->first()->id)->get());
        $city = $this->makeCity();


        $this->actingAs($user)->post('/restaurants',[
            'name' => 'Restaurantul Meu',
            'description' => '',
            'location' => 'Str. Manole nr. 45',
            'city_id' => $city->id,
        ])->assertStatus(302);

        $this->assertCount(1, Restaurant::all());
    }

    /** @test */
    public function if_user_has_a_owner_restaurant_role_ocupied_restaurants_acces_denied_create() :void 
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[1];
        $this->assertCount(1,UserRestaurant::where('user_id',$user->id)
        ->where('role_id',Role::where('name','patron_restaurant')->first()->id)->get());
        $city = $this->makeCity();


        $this->actingAs($user)->post('/restaurants',[
            'name' => 'Restaurantul Meu',
            'description' => '',
            'location' => 'Str. Manole nr. 45',
            'city_id' => $city->id,
        ])->assertStatus(403);
        $this->assertCount(1,UserRestaurant::where('user_id',$user->id)->get());
        $this->assertNotEquals('Restaurantul Meu', UserRestaurant::where('user_id',$user->id)->first()->restaurant->name);
    }
}
