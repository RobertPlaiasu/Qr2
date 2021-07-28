<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Permission;
use App\Models\User;

class PermissionsTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_make_a_permission()
    {
        $this->assertCount(0,Permission::all());
        $user = $this->getTheAdminUser();

        $response = $this->actingAs($user)->post('/permissions',[
            'name' => 'Nume',
            'description' => 'Descriere',
        ]);
        
        $this->assertCount(1,Permission::where('name','Nume')->get());
        $response->assertRedirect('/permissions');
    }


    /** @test */
    public function can_update_a_permission()
    {
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->post('/permissions',[
            'name' => 'Nume',
            'description' => 'Descriere',
        ]);

        $this->assertCount(1,Permission::where('name','Nume')->get());
        $permission =  Permission::where('name','Nume')->first();

        $response = $this->actingAs($user)->put('/permissions/'. $permission->id,[
            'name' => 'Nume 2',
            'description' => 'Descriere detaliata',
        ]);

        $this->assertEquals('Nume 2',Permission::where('id',$permission->id)->first()->name);
        $this->assertEquals('Descriere detaliata',Permission::where('id',$permission->id)->first()->description);

        $response->assertRedirect('/permissions');
    }

    /** @test */
    public function can_delete_a_permission()
    {
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->post('/permissions',[
            'name' => 'Nume',
            'description' => 'Descriere',
        ]);

        $this->assertCount(1,Permission::where('name','Nume')->get());
        $permission =  Permission::where('name','Nume')->first();

        $response = $this->actingAs($user)->delete('/permissions/' . $permission->id);

        $response->assertRedirect('/permissions');
    }
}
