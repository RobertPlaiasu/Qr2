<?php

namespace Tests\Unit\County;

use Tests\TestCase;
use App\Models\County;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestUpdateCountyTest extends TestCase
{
    use DataForAuthorizationTrait,RefreshDatabase;

    /** @test */
    public function validate_name_field_update_county()
    {
        // $this->withoutExceptionHandling();
        $county = County::factory()->create([
            'name' => 'Prahova'
        ]);
        $user = $this->getTheAdminUser();
/*
        $this->actingAs($user)->put('/counties/'.$county->id,[
            'name' => '',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/counties/'.$county->id,[
            'name' => 1,
        ])->assertSessionHasErrors('name');
        */
        $this->actingAs($user)->put('/counties/'.$county->id,[
            'name' => 'Prahova',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/counties/'.$county->id,[
            'name' => 'lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/counties/'.$county->id,[
            'name' => 'Galati',
        ])->assertSessionHasNoErrors('name');
    }
}
