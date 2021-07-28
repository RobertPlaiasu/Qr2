<?php

namespace Tests\Unit\Role;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateRoleRequestTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function validate_name_field_role_update() :void
    {
        $user = $this->getTheAdminUser();
        $permissions  = $this->makePermissions();
        $role = Role::factory()->create();

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => '',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'a',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 1,
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasNoErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'administrator',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'patron_restaurant',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'angajat_restaurant',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => $role->name,
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasNoErrors('name');
    }

    /** @test */
    public function validate_description_field_role_update()
    {
        $user = $this->getTheAdminUser();
        $permissions  = $this->makePermissions();
        $role = Role::factory()->create();

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasNoErrors('description');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => '',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 1,
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'lllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'a',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasErrors('description');
    }
    
    /** @test */
    public function validate_permissions_field_role_update()
    {
        $user = $this->getTheAdminUser();
        $role = Role::factory()->create();

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => 1000,
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => 1000,
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => '',
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => 'merge',
            'for_admin' => true,
        ])->assertSessionHasErrors('permissions');

        $permissions = $this->makePermissions();
        
        $this->actingAs($user)->put('/roles/' . $role->id,[
            'name' => 'name',
            'description' => 'descriere',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
            'for_admin' => true,
        ])->assertSessionHasNoErrors('permissions');
    }
}
