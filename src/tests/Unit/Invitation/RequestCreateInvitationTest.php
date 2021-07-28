<?php

namespace Tests\Unit\Invitation;

use Tests\TestCase;
use App\Models\Invitation;
use Tests\Feature\DataForAuthorizationTrait;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestCreateInvitationTest extends TestCase
{
   use DataForAuthorizationTrait,RefreshDatabase;


    /** @test */
    public function validate_role_id_field_invitation() :void
    {

        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();

        $this->actingAs($user)->post($restaurant->path().'/invitations',[
            'email' => $userInvited->email,
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ])->assertSessionHasNoErrors('role_id');

        $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => $userInvited->email,
            'role_id' => '',
        ])->assertSessionHasErrors('role_id');

        $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => $userInvited->email,
            'role_id' => 'a',
        ])->assertSessionHasErrors('role_id');

        $this->actingAs($user)->post($restaurant->path() . '/invitations',[
            'email' => $userInvited->email,
            'role_id' => 20,
        ])->assertSessionHasErrors('role_id');

    }

    /** @test */
    public function validate_email_field_invitation() :void 
    {
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();

        $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => $userInvited->email,
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ])->assertSessionHasNoErrors('email');

        $this->actingAs($user)->post($restaurant->path()  .'/invitations',[
            'email' => '',
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ])->assertSessionHasErrors('email');

        $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => 'a',
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ])->assertSessionHasErrors('email');

        $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ])->assertSessionHasErrors('email');
    }
}
