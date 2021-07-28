<?php

namespace Tests\Unit\Menu;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\Restaurant;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestMenuTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function validate_name_field()
    {

        $restaurant = Restaurant::factory()->create();
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->post($restaurant->path().'/menus',[
            'name' => 'Numeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post($restaurant->path().'/menus',[
            'name' => '',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post($restaurant->path().'/menus',[
            'name' => 1,
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post($restaurant->path().'/menus',[
            'name' => 'nume meniu 3',
        ])->assertSessionHasNoErrors('name');

    }
}
