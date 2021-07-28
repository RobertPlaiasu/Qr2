<?php

namespace Tests\Unit\Category;

use Tests\TestCase;
use Tests\Feature\DataForAuthorizationTrait;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Menu;

class RequestCategoryTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function validate_name_field()
    {
        $user = $this->getTheAdminUser();
        $menu = Menu::factory()->create();

        $this->actingAs($user)->post($menu->path(true) . '/categories',[
            'name' => '',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post($menu->path(true).'/categories',[
            'name' => 'a',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post($menu->path(true).'/categories',[
            'name' => 'Nume',
        ])->assertSessionHasNoErrors('name');

        $this->actingAs($user)->post($menu->path(true).'/categories',[
            'name' => 'llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post($menu->path(true).'/categories',[
            'name' => 12,
        ])->assertSessionHasErrors('name');

    }
}
