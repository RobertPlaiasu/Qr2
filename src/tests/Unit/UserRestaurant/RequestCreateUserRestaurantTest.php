<?php

namespace Tests\Unit\UserRestaurant;

use Tests\TestCase;
use App\Models\UserRestaurant;
use App\Models\Restaurant;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestCreateUserRestaurantTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function validate_user_id_field_create_user_restaurant() :void
    {
        $user = $this->getTheAdminUser();
        $factories = $this->makeFactories();

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasNoErrors('user_id');

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => '',
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasErrors('user_id');

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => 'merge',
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasErrors('user_id');

    }

    /** @test */
    public function validate_role_id_field_create_user_restaurant() :void
    {
        $user = $this->getTheAdminUser();
        $restaurant = Restaurant::factory()->create();

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => 1,
            'role_id' => 5000,
            'restaurant_id' => $restaurant->id
        ])->assertSessionHasErrors('role_id');

        $factories = $this->makeFactories(); 

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasNoErrors('role_id');

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => '',
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasErrors('role_id');

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => 'merge',
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasErrors('role_id');
    }

    /** @test */
    public function validate_restaurant_id_create_user_restaurant() :void
    {
        $user = $this->getTheAdminUser();
        $factories = $this->makeFactories();

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
        ])->assertSessionHasNoErrors('restaurant_id');

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasNoErrors('restaurant_id');

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => 'merge',
        ])->assertSessionHasErrors('restaurant_id');

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => 5000,
        ])->assertSessionHasErrors('restaurant_id');
    }

}
