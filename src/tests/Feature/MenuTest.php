<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class MenuTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_create_a_menu()
    {
        $this->withoutExceptionHandling();
        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();

        $response = $this->actingAs($user)->post($restaurant->path() . '/menus',[
            'name' => 'Nume',
        ]);

        $this->assertCount(1,Menu::where('restaurant_id',$restaurant->id)->get());

        $menu = Menu::where('restaurant_id',$restaurant->id)->first();
        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);
        $response->assertRedirect(Menu::where('restaurant_id',$restaurant->id)->first()->path());
    }

    /** @test */
    public function update_a_menu()
    {
        $user = $this->getTheAdminUser();
        $restaurant = Restaurant::factory()->create();

        $this->actingAs($user)->post($restaurant->path() . '/menus',[
            'name' => 'Nume',
        ]);

        $this->assertCount(1,Menu::where('restaurant_id',$restaurant->id)->get());

        $menu = Menu::where('restaurant_id',$restaurant->id)->first();


        $response = $this->actingAs($user)->put($restaurant->path() . $menu->path(),[
            'name' => 'Nume Menu',
        ]);

        $this->assertEquals('Nume Menu',Menu::where('restaurant_id',$restaurant->id)->first()->name);
        $this->assertEquals($restaurant->id,Menu::where('restaurant_id',$restaurant->id)->first()->restaurant->id);
        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);
        $response->assertRedirect(Menu::where('restaurant_id',$restaurant->id)->first()->path());
    }


    /** @test */
    public function can_delete_a_menu()
    {
        $user = $this->getTheAdminUser();
        $restaurant = Restaurant::factory()->create();

        $this->actingAs($user)->post($restaurant->path() . '/menus',[
            'name' => 'Nume',
        ]);

        $this->assertCount(1,Menu::where('restaurant_id',$restaurant->id)->get());

        $menu = Menu::where('restaurant_id',$restaurant->id)->first();

        $response = $this->actingAs($user)->delete($restaurant->path() . $menu->path());

        $this->assertCount(0,Menu::where('restaurant_id',$restaurant->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);
        $response->assertRedirect($restaurant->path());

    }


}
