<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\City;
use App\Models\County;
use Tests\TestCase;
use App\Models\User;

class CityTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_create_a_city()
    {
        $user = $this->getTheAdminUser();
        $county = County::factory()->create();

        $response = $this->actingAs($user)->post('/cities',[
            'name' => 'Ploiesti',
            'county_id' => $county->id,
        ]);

        $this->assertCount(1,City::all());

        $response->assertRedirect('/cities');
    }

    /** @test */
    public function validate_name_field()
    {
        $user = $this->getTheAdminUser();;
        $county = County::factory()->create();

        $this->actingAs($user)->post('/cities',[
            'name' => '',
            'county_id' => $county->id,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/cities',[
            'name' => 'lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
            'county_id' => $county->id,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/cities',[
            'name' => 'Ploiești',
            'county_id' => $county->id,
        ])->assertSessionHasNoErrors('name');

    }

    /** @test */
    public function validate_county_id_field()
    {
        $user = $this->getTheAdminUser();
        $county = County::factory()->create();

        $this->actingAs($user)->post('/cities',[
            'name' => 'Ploiesti',
            'county_id' => '',
        ])->assertSessionHasErrors('county_id');

        $this->actingAs($user)->post('/cities',[
            'name' => 'Ploiesti',
            'county_id' => 12,
        ])->assertSessionHasErrors('county_id');

        $this->actingAs($user)->post('/cities',[
            'name' => 'Ploiești',
            'county_id' => $county->id,
        ])->assertSessionHasNoErrors('county_id');

    }

    /** @test */
    public function can_update_a_city()
    {
        $user = $this->getTheAdminUser();
        $counties = County::factory()->count(2)->create();

        $this->actingAs($user)->post('/cities',[
            'name' => 'Ploiesti',
            'county_id' => $counties[0]->id,
        ]);

        $this->assertCount(1,City::all());
        $city = City::first();

        $response = $this->actingAs($user)->put('/cities/'. $city->id,[
            'name' => 'Bucuresti',
            'county_id' => $counties[1]->id,
        ]);

        $this->assertEquals('Bucuresti',City::first()->name);
        $this->assertEquals($counties[1]->id,City::first()->county_id);

        $response->assertRedirect('/cities');

    }

    /** @test */
    public function a_city_can_be_deleted()
    {
        $user = $this->getTheAdminUser();
        $county = County::factory()->create();

        $this->actingAs($user)->post('/cities',[
            'name' => 'Ploiesti',
            'county_id' => $county->id,
        ]);

        $this->assertCount(1,City::all());

        $response = $this->actingAs($user)->delete('/cities/' . City::first()->id);

        $this->assertCount(0,City::all());

        $response->assertRedirect('/cities');
    }

}
