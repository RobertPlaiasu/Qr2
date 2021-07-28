<?php

namespace Tests\Unit\County;

use Tests\TestCase;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestCreateCountyTest extends TestCase
{
    use DataForAuthorizationTrait,RefreshDatabase;
    /** @test */
    public function validate_name_create_field_county()
    {
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->post('/counties',[
            'name' => ''
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/counties',[
            'name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll'
        ])->assertSessionHasErrors('name');
        
        $this->actingAs($user)->post('/counties',[
            'name' => 'Prahova'
        ])->assertSessionHasNoErrors('name');

        $this->actingAs($user)->post('/counties',[
            'name' => 'Prahova'
        ])->assertSessionHasErrors('name');

    }
}
