<?php

namespace Tests\Unit\UserRestaurant;

use Tests\TestCase;
use App\Models\UserRestaurant;
use App\Models\Restaurant;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestUpdateUserRestaurantTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;
    


    /** @test */
    public function validate_role_id_field_update_user_restaurant() :void
    {
        $user = $this->getTheAdminUser();
        $factories = $this->makeFactories();
        $userRestaurant = UserRestaurant::factory()->create([
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ]);

        $this->actingAs($user)->put('/assign_roles' . $factories['restaurant']->path(). '/' . $userRestaurant->id,[
            'user_id' => 1,
            'role_id' => 5000,
        ])->assertSessionHasErrors('role_id');


        $this->actingAs($user)->put('/assign_roles' . $factories['restaurant']->path(). '/' . $userRestaurant->id,[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
        ])->assertSessionHasNoErrors('role_id');

        $this->actingAs($user)->put('/assign_roles' . $factories['restaurant']->path(). '/' . $userRestaurant->id,[
            'user_id' => $factories['user']->id,
            'role_id' => '',
        ])->assertSessionHasErrors('role_id');

        $this->actingAs($user)->put('/assign_roles' . $factories['restaurant']->path(). '/' . $userRestaurant->id,[
            'user_id' => $factories['user']->id,
            'role_id' => 'merge',
        ])->assertSessionHasErrors('role_id');
    }

}
