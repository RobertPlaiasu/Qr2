<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Menu;
use App\Models\Category;
use App\Models\User;


class CategoryTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_make_a_category() :void
    {
        $user = $this->getTheAdminUser();
        $menu = Menu::factory()->create();

        $response = $this->actingAs($user)->post($menu->path(true) .'/categories',[
            'name' => 'Nume',
        ]);

        $this->assertCount(1,Category::all());

        $response->assertRedirect($menu->path().'/categories');

    }


    /** @test */
    public function can_update_a_category() :void
    {
        $user = $this->getTheAdminUser(); 
        $menu = Menu::factory()->create();

        $this->actingAs($user)->post($menu->path(true) . '/categories',[
            'name' => 'Nume',
        ]);

        $this->assertCount(1,Category::all()); 

        $category = Category::first();


        $response = $this->actingAs($user)->put($menu->path(true) .'/categories/'.$category->id, [
            'name' => 'Nume Nou',
        ]);

        $this->assertEquals('Nume Nou',Category::first()->name);

        $response->assertRedirect(Category::first()->menu->path());

    }

    /** @test */
    public function can_delete_a_category() :void
    {
        $user = $this->getTheAdminUser();
        $menu = Menu::factory()->create();

        $this->actingAs($user)->post($menu->path(true) .'/categories',[
            'name' => 'Nume',
        ]);

        $this->assertCount(1,Category::all()); 

        $category = Category::first(); 


        $this->actingAs($user)->delete($menu->path(true) .'/categories/' . $category->id);

        $this->assertCount(0,Category::all());
    }

}
