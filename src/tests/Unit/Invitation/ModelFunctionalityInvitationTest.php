<?php

namespace Tests\Unit\Invitation;

use Tests\TestCase;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelFunctionalityInvitationTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function get_the_user_that_has_the_same_email_as_in_the_invitation() :void
    {
        $this->seed();
        $restaurant = Restaurant::factory()->create();
        $userInvited = User::factory()->create();
        $invitation = Invitation::factory()->create([
            'email' => $userInvited->email,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ]);

        $this->assertEquals($userInvited->name, $invitation->user());
    }

    /** @test */
    public function get_null_instead_of_the_user_that_has_the_same_email_as_in_the_invitation() :void
    {
        // if the user doesn't exist you get null
        $this->withoutExceptionHandling();
        $this->seed();
        $restaurant = Restaurant::factory()->create();
        $invitation = Invitation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
            'email' => 'email@carenuexista.nem'
        ]);

        $this->assertEquals('email@carenuexista.nem', $invitation->user());
    }

    /** @test  */
    public function get_the_invitations_of_the_user() :void
    {
        $this->seed();
        $restaurant = Restaurant::factory()->create();
        $userInvited = User::factory()->create();
        $invitation = Invitation::factory()->create([
            'email' => $userInvited->email,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
        ]);
        
        $restaurant = Restaurant::factory()->create();
        $invitation = Invitation::factory()->create([
            'email' => $userInvited->email,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ]);
        
        $this->assertCount(2,$userInvited->getAllTheInvitationsForTheUser());
    }
}
