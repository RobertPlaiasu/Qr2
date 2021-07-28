<?php

namespace Tests\Unit\Invitation;

use Tests\TestCase;
use App\Models\Invitation;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\DataForAuthorizationTrait;

class InvitationRoleIdNotEmployeeTest extends TestCase
{
    use RefreshDatabase, DataForAuthorizationTrait;

    /** @test */
    public function if_role_id_is_not_emplyee_id_throw_error()
    {
        $user = $this->getTheAdminUser();
        $restaurant = Restaurant::factory()->create();

        $this->actingAs($user)->post($restaurant->path() . '/invitations', [
            'email' => 'example@gmail.com',
            'role_id' => Role::where('name', 'administrator')->first()->id
        ])->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->all()[0], 'Rolul nu este permis!');
    }
}
