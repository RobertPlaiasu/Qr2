<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;

class QrTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function test_a_qr_is_downloadable()
    {
        $this->withoutExceptionHandling();
        $user = $this->getTheAdminUser();

        $menu = Menu::factory()
            ->for( Restaurant::factory() )
            ->create();

        $this->actingAs($user)->get($menu->path() .'/download')->assertStatus(200);
    }
}
