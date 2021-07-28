<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class RoleTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_make_a_role()
    {
        $user = $this->getTheAdminUser();
        $this->assertCount(0,Role::where('name','Nume')->get());
        $permissions = $this->makePermissions();
        
    
        $response  = $this->actingAs($user)->post('/roles',[
            'name' => 'Nume',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ]);

        $this->assertCount(1,Role::where('name','Nume')->get());
        $this->assertCount(3,Role::where('name','Nume')->first()->permissions);

        $response->assertRedirect('/roles');
    }
    
    /** @test */
    public function can_update_a_role()
    {
        $this->withoutExceptionHandling();
        $user = $this->getTheAdminUser();
        $this->assertCount(0,Role::where('name','Nume')->get());
        $permissions = $this->makePermissions();
        
    
        $this->actingAs($user)->post('/roles',[
            'name' => 'Nume',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ]);

        $this->assertCount(1,Role::where('name','Nume')->get());
        $role = Role::where('name','Nume')->first();
        $this->assertCount(3,$role->permissions);

        $permissions = $this->makePermissions();
        $response = $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'Nume New',
            'description' => 'Description New',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ]);
        
        $this->assertCount(1,Role::where('name','Nume New')->get());
        $role = Role::where('name','Nume New')->first(); 
        
        $rolePermissions = $role->permissions;
        $this->assertEquals('Nume New',$role->name);
        $this->assertEquals('Description New',$role->description);
        $this->assertEquals([$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],[$rolePermissions[0]->id,$rolePermissions[1]->id,$rolePermissions[2]->id],);
        $this->assertEquals(true,$role->for_admin);

        $response->assertRedirect('/roles');
    }

    /** @test */
    public function can_delete_a_role()
    {
        $user = $this->getTheAdminUser();
        $this->assertCount(0,Role::where('name','Nume')->get());
        $permissions = $this->makePermissions();

        
        $this->actingAs($user)->post('/roles',[
            'name' => 'Nume',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ]);

        $this->assertCount(1,Role::where('name','Nume')->get());
        $role = Role::where('name','Nume')->first();
        $this->assertCount(3,$role->permissions);

        $this->actingAs($user)->delete('/roles/' . $role->id)->assertRedirect('/roles');
        $this->assertCount(0,Role::where('name','Nume')->get());
    }

}
