<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserRestaurant;
use App\Models\User;
use App\Models\Role;
use App\Models\Restaurant;

class UserRestaurantTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_assign_a_role()
    {
        $this->withoutExceptionHandling();
        $user = $this->getTheAdminUser();
        $factories = $this->makeFactories();
        $this->assertCount(0,UserRestaurant::where('user_id',$factories['user']->id)
        ->where('role_id',$factories['role']->id)
        ->where('restaurant_id',$factories['restaurant']->id)->get());

        $response = $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ])->assertSessionHasNoErrors();

        $this->assertCount(1,UserRestaurant::where('user_id',$factories['user']->id)
                                ->where('role_id',$factories['role']->id)
                                ->where('restaurant_id',$factories['restaurant']->id)->get());
        $response->assertRedirect('/admin');

    }

    /** @test */
    public function update_role_assigned()
    {
        $user = $this->getTheAdminUser();
        $factories = $this->makeFactories();
        $this->assertCount(0,UserRestaurant::where('user_id',$factories['user']->id)
        ->where('role_id',$factories['role']->id)
        ->where('restaurant_id',$factories['restaurant']->id)->get());

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ]);

        $this->assertCount(1,UserRestaurant::where('user_id',$factories['user']->id)
                                ->where('role_id',$factories['role']->id)
                                ->where('restaurant_id',$factories['restaurant']->id)->get());

        $userRestaurant = UserRestaurant::where('user_id',$factories['user']->id)
        ->where('role_id',$factories['role']->id)
        ->where('restaurant_id',$factories['restaurant']->id)->first();
        $newRole = Role::factory()->create();

        $response = $this->actingAs($user)->put('/assign_roles' . $factories['restaurant']->path() . '/' . $userRestaurant->id,[
            'role_id' => $newRole->id,
        ]);

        $this->assertEquals($newRole->id,UserRestaurant::where('user_id',$factories['user']->id)
                                        ->where('role_id',$newRole->id)
                                        ->where('restaurant_id',$factories['restaurant']->id)->first()->role_id);

        $response->assertRedirect('/assign_roles'. $factories['restaurant']->path());
    }


    /** @test */
    public function can_delete_a_assigned_role()
    {
        $user = $this->getTheAdminUser();
        $factories = $this->makeFactories();
        $this->assertCount(0,UserRestaurant::where('user_id',$factories['user']->id)
        ->where('role_id',$factories['role']->id)
        ->where('restaurant_id',$factories['restaurant']->id)->get());

        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
            'restaurant_id' => $factories['restaurant']->id,
        ]);

        $this->assertCount(1,UserRestaurant::where('user_id',$factories['user']->id)
                                ->where('role_id',$factories['role']->id)
                                ->where('restaurant_id',$factories['restaurant']->id)->get());

        $userRestaurant = UserRestaurant::where('user_id',$factories['user']->id)
        ->where('role_id',$factories['role']->id)
        ->where('restaurant_id',$factories['restaurant']->id)->first();

        $response = $this->actingAs($user)->delete('/assign_roles' .$factories['restaurant']->path().'/'.$userRestaurant->id);
        $this->assertCount(0,UserRestaurant::where('user_id',$factories['user']->id)
                            ->where('role_id',$factories['role']->id)->get());
        $response->assertRedirect($userRestaurant->restaurant->path());
    }


}
