<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\County;
use App\Models\User;
use Tests\TestCase;

class CountyTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;
    
    /** @test */
    public function can_make_a_county()
    {   
        $user = $this->getTheAdminUser();
        $this->assertCount(0,County::all());
        
        $response = $this->actingAs($user)->post('/counties',[
            'name' => 'Prahova'
        ]);
        
        $this->assertCount(1,County::all());

        $response->assertRedirect('/counties');
    }

    /** @test */
    public function can_update_a_county()
    {
        $user = $this->getTheAdminUser();
        $this->assertCount(0,County::all());

        $this->actingAs($user)->post('/counties',[
            'name' => 'Prahova'
        ]);
        
        $this->assertCount(1,County::all());

        $county = County::first();

        $response = $this->actingAs($user)->put($county->path(),[
            'name' => 'Galati'
        ]);

        $this->assertEquals('Galati',County::first()->name);

        $response->assertRedirect('/counties');

    }

    /** @test */
    public function a_county_can_be_deleted()
    {
        $user = $this->getTheAdminUser();
        $this->assertCount(0,County::all());

        $this->actingAs($user)->post('/counties',[
            'name' => 'Prahova'
        ]);
        
        $this->assertCount(1,County::all());

        $county = County::first();

        $response = $this->actingAs($user)->delete($county->path());

        $this->assertCount(0,County::all());

        $response->assertRedirect('/counties');

    }

}
