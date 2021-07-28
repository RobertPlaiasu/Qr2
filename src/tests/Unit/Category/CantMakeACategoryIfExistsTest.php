<?php

namespace Tests\Unit\Category;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Menu;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CantMakeACategoryIfExistsTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function if_a_category_already_exists_with_the_same_name() :void 
    {
        $user = $this->getTheAdminUser();
        $menu = Menu::factory()->create();

        $this->actingAs($user)->post($menu->path(true) . '/categories',[
            'name' => 'Nume',
        ])->assertSessionHasNoErrors();

        $this->assertCount(1,Category::where('menu_id',$menu->id)->get());

        $this->actingAs($user)->post($menu->path(true) .'/categories',[
            'name' => 'Nume',
        ])->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->all()[0],"Exista deja o categorie cu acelasi nume in acest meniu!");

        $this->assertCount(1,Category::where('menu_id',$menu->id)->get());
    }


    /** @test */
    public function if_category_exists_in_another_menu_do_not_throw_error() :void 
    {
        $menu1 = Menu::factory()->create();
        $menu2 = Menu::factory()->create();

        $user = $this->getTheAdminUser();

        $this->actingAs($user)->post($menu1->path(true).'/categories',[
            'name' => 'Nume',
        ])->assertSessionHasNoErrors();

        $this->assertCount(1,Category::where('menu_id',$menu1->id)->get());

        $this->actingAs($user)->post($menu2->path(true).'/categories',[
            'name' => 'Nume',
        ])->assertSessionHasNoErrors();

        $this->assertCount(1,Category::where('menu_id',$menu2->id)->get());
        $this->assertCount(1,Category::where('menu_id',$menu1->id)->get());
    }
}
