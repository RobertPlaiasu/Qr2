<?php

namespace Tests\Unit\Role;

use Tests\TestCase;
use App\Models\User;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestRoleCreateTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function validate_name_field_role_create() :void
    {
        $user = $this->getTheAdminUser();
        $permissions  = $this->makePermissions();

        $this->actingAs($user)->post('/roles',[
            'name' => '',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/roles',[
            'name' => 'a',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/roles',[
            'name' => 1,
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/roles',[
            'name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasNoErrors('name');

        $this->actingAs($user)->post('/roles',[
            'name' => 'administrator',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/roles',[
            'name' => 'patron_restaurant',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/roles',[
            'name' => 'angajat_restaurant',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_description_field_role_create()
    {
        $user = $this->getTheAdminUser();
        $permissions  = $this->makePermissions();

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasNoErrors('description');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => '',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 1,
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'a',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');
    }
    
    /** @test */
    public function validate_permissions_field_role_create()
    {
        $user = $this->getTheAdminUser();
        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => 1000,
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => 1000,
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => '',
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => 'merge',
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $permissions = $this->makePermissions();
        
        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasNoErrors('permissions');
    }
    
}
