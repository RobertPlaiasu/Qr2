<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Restaurant;
use App\Models\City;
use App\Models\County;
use App\Models\User;
use App\Models\UserRestaurant;
use App\Models\Role;

class RestaurantTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */

    public function can_make_a_restaurant()
    {
        $city = $this->makeCity();
        $user = $this->getTheAdminUser();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('restaurant.jpg');
        $this->assertCount(0,Restaurant::all());

        $response = $this->actingAs($user)->post('/restaurants',[
            'name' => 'Restaurantul Meu',
            'picture' => $file,
            'description' => 'Descriere',
            'location' => 'Str. Manole nr. 45',
            'city_id' => $city->id,
        ]);

        Storage::disk('public')->assertExists('restaurant_pictures/' . $file->hashName());
        $this->assertEquals('restaurant_pictures/' . $file->hashName(), Restaurant::first()->picture);
        $this->assertCount(1, Restaurant::all());

        $response->assertRedirect(Restaurant::first()->path());
    }


    /** @test */
    public function can_update_a_restaurant()
    {
        $this->withoutExceptionHandling();
        $city = $this->makeCity();
        $user = $this->getTheAdminUser();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('restaurant.jpg');
        $this->assertCount(0,Restaurant::all());

        $this->actingAs($user)->post('/restaurants',[
            'name' => 'Restaurant',
            'description' => 'Descriere',
            'picture' => $file,
            'location' => 'Str. Manole nr. 45',
            'city_id' => $city->id,
        ]);

        Storage::disk('public')->assertExists('restaurant_pictures/' . $file->hashName());
        $this->assertEquals('restaurant_pictures/' . $file->hashName(), Restaurant::first()->picture);
        $this->assertCount(1,Restaurant::all());

        $restaurant = Restaurant::first();

        $city = $this->makeCity();

        $file2 = UploadedFile::fake()->image('restaurant.jpg');
        $response = $this->actingAs($user)->put($restaurant->path(),[
            'name' => 'Restaurant Albert',
            'description' => 'Descriere Nice',
            'location' => 'Str. Manole nr. 25',
            'city_id' => $city->id,
            'picture' => $file2,
        ]);


        $restaurant = Restaurant::first();
        $this->assertEquals('Restaurant Albert', $restaurant->name);
        $this->assertEquals('Descriere Nice', $restaurant->description);
        $this->assertEquals('Str. Manole nr. 25', $restaurant->location);
        $this->assertEquals($city->id,$restaurant->city_id);
        Storage::disk('public')->assertExists('restaurant_pictures/' . $file2->hashName());
        $this->assertEquals('restaurant_pictures/' . $file2->hashName(), Restaurant::first()->picture);

        $response->assertRedirect($restaurant->path());

    }

    /** @test */
    public function can_delete_a_restaurant()
    {
        $user = $this->getTheAdminUser();
        $this->assertCount(0,Restaurant::all());
        $city = $this->makeCity();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('restaurant.jpg');

        $this->actingAs($user)->post('/restaurants',[
            'name' => 'Restaurant',
            'description' => 'Descriere',
            'location' => 'Str. Manole nr. 45',
            'city_id' => $city->id,
            'picture' => $file,
        ]);

        $this->assertCount(1, Restaurant::all());
        Storage::disk('public')->assertExists('restaurant_pictures/' . $file->hashName());
        $this->assertEquals('restaurant_pictures/' . $file->hashName(), Restaurant::first()->picture);

        $restaurant = Restaurant::first();

        $response = $this->actingAs($user)->delete($restaurant->path());

        $this->assertCount(0, Restaurant::all());
        Storage::disk('public')->assertMissing('restaurant_pictures/' . $file->hashName());

        $response->assertRedirect(route('dashboard'));

    }

    /** @test */
    public function verify_if_the_user_gets_the_role_of_patron_restaurant()
    {
        $this->withoutExceptionHandling();
        $city = $this->makeCity();
        $user = $this->getTheRestaurantOwnerWithoutRestaurant();
        $this->assertCount(0,Restaurant::all());

        $response = $this->actingAs($user)->post('/restaurants',[
            'name' => 'Restaurantul Meu',
            'description' => 'Descriere',
            'location' => 'Str. Manole nr. 45',
            'city_id' => $city->id,
        ]);

        $this->assertCount(1, Restaurant::all());
        $restaurant = Restaurant::first();

        $this->assertCount(1,UserRestaurant::where('user_id',$user->id)
                                            ->where('restaurant_id',$restaurant->id)
                                            ->where('role_id',Role::where('name','patron_restaurant')->first()->id)
                                            ->get()
                          );
    }

    /** @test */
    public function verify_if_the_user_deletes_a_restaurant_remove_the_restaurant_userRestaurant()
    {
        $user = $this->getTheRestaurantOwnerWithoutRestaurant();
        $this->assertCount(0,Restaurant::all());
        $city = $this->makeCity();

        $this->actingAs($user)->post('/restaurants',[
            'name' => 'Restaurant',
            'description' => 'Descriere',
            'location' => 'Str. Manole nr. 45',
            'city_id' => $city->id,
        ]);

        $this->assertCount(1, Restaurant::all());

        $restaurant = Restaurant::first();

        $this->actingAs($user)->delete($restaurant->path());
        $this->assertCount(0, Restaurant::all());

        $this->assertCount(1,UserRestaurant::where('user_id',$user->id)
                                            ->where('restaurant_id',null)
                                            ->where('role_id',Role::where('name','patron_restaurant')->first()->id)
                                            ->get()
                          );
    }

}
