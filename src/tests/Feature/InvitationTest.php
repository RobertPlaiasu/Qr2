<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Invitation;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRestaurant;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;

class InvitationTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_make_a_invitation()
    {
        Mail::fake();

        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();


        Mail::assertNothingSent();
        $response = $this->actingAs($user)->post($restaurant->path().'/invitations',[
            'email' => $userInvited->email,
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
        ]);

        $this->assertCount(1, Invitation::all());

        $response->assertRedirect('staff' . $restaurant->path());

        Mail::assertSent(InvitationMail::class, 1);
    }


    /** @test */
    public function if_an_invitation_already_exists_redirect() :void
    {
        Mail::fake();
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();

        Invitation::factory()->create([
            'email' => $userInvited->email,
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $response = $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => $userInvited->email,
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
        ])->assertStatus(302);
        Mail::assertNothingSent();
        $this->assertCount(1,Invitation::where('email',$userInvited->email)
        ->where('restaurant_id',$restaurant->id)
        ->where('role_id',Role::where('name', 'angajat_restaurant')->first()->id)->get());
    }


    /** @test */
    public function if_an_userRestaurant_is_the_same_as_invitation_redirect() :void
    {
        Mail::fake();
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();

        UserRestaurant::factory()->create([
            'user_id' => $userInvited->id,
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $response = $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => $userInvited->email,
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
        ])->assertStatus(302);

        Mail::assertNothingSent();

        $this->assertCount(0,Invitation::where('email',$userInvited->email)
        ->where('restaurant_id',$restaurant->id)
        ->where('role_id',Role::where('name', 'angajat_restaurant')->first()->id)->get());
    }


    /** @test */
    public function if_for_an_invitation_user_doesnt_exist() :void
    {
        Mail::fake();
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();

        $response = $this->actingAs($user)->post($restaurant->path() .'/invitations',[
            'email' => 'micro@mail.com',
            'role_id' => Role::where('name', 'angajat_restaurant')->first()->id,
        ])->assertStatus(302);

        $this->assertCount(1,Invitation::where('email','micro@mail.com')
        ->where('restaurant_id',$restaurant->id)
        ->where('role_id',Role::where('name', 'angajat_restaurant')->first()->id)->get());
    }

    /** @test */
    public function accept_an_invitation()
    {
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();
        $invitation = Invitation::factory()->create([
            'email' => $userInvited->email,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ]);

        $response = $this->actingAs($userInvited)->post('invitations/'.$invitation->id.'/accept');
        $this->assertCount(1,UserRestaurant::where('user_id',$userInvited->id)
                                            ->where('role_id',Role::where('name','angajat_restaurant')->first()->id)
                                            ->where('restaurant_id',$restaurant->id)->get());
        $this->assertCount(0,Invitation::where('email',$userInvited->email)
        ->where('role_id',Role::where('name','angajat_restaurant')->first()->id)
        ->where('restaurant_id',$restaurant->id)->get());
        $response->assertRedirect($restaurant->path());
    }

    /** @test */
    public function cancel_an_invitation()
    {
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();
        $invitation = Invitation::factory()->create([
            'email' => $userInvited->email,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ]);
        $this->assertCount(1,Invitation::all());

        $this->actingAs($user)->delete('/invitations/'. $invitation->id);
        $this->assertCount(0,Invitation::all());
    }

    /** @test */
    public function decline_an_invitation() :void
    {
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();
        $userInvited = User::factory()->create();
        $invitation = Invitation::factory()->create([
            'email' => $userInvited->email,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name','angajat_restaurant')->first()->id,
        ]);
        $this->assertCount(1,Invitation::all());

        $this->actingAs($userInvited)->delete('/invitations/'. $invitation->id);
        $this->assertCount(0,Invitation::all());
    }

}
