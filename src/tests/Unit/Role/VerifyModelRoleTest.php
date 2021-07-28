<?php

namespace Tests\Unit\Role;

use Tests\TestCase;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyModelRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_the_roles_that_cant_be_change() :void
    {
        $rolesThatCantBeChange = ['administrator','patron_restaurant','angajat_restaurant'];
        $this->assertEquals($rolesThatCantBeChange,Role::rolesThatCanNotChange());
    }

    /** @test */
    public function get_the_roles_that_an_restaurant_employee_can_get() :void
    {
        $this->seed();
        $this->assertCount(1,Role::where('name','angajat_restaurant')->get());
        $rolesEmployee = Role::where('name','angajat_restaurant')->get();
        $this->assertEquals(Role::employeeRoles(),$rolesEmployee);
    }
}
