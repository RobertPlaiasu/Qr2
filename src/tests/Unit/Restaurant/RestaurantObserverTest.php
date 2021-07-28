<?php

namespace Tests\Unit\Restaurant;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class RestaurantObserverTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function create_a_restaurant_and_delete_it() :void 
    {
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();
        
        $file = UploadedFile::fake()->image('product.jpg');

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);

        $menu = $category->menu;
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());
        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);

        $this->assertEquals('product_pictures/' . $file->hashName(), Product::first()->picture);
        $this->assertCount(1,Product::where('category_id',$category->id)->get());

        $this->actingAs($user)->delete($menu->restaurant->path());
        $this->assertCount(0,Restaurant::where('id',$menu->restaurant->id)->get());
        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        $this->assertCount(0,Category::where('id',$category->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);
        
        Storage::disk('public')->assertMissing('product_pictures/' . $file->hashName());
    }
    
    /** @test */
    public function delete_a_restaurant_and_doesnt_have_menu() :void 
    {
        $user = $this->getTheAdminUser();
        $restaurant = Restaurant::factory()->create();

        $this->actingAs($user)->delete($restaurant->path())->assertStatus(302);
        $this->assertCount(0,Restaurant::where('id',$restaurant->id)->get());
    }

    /** @test */
    public function delete_a_restaurant_and_doesnt_have_a_category() :void 
    {
        $user = $this->getTheAdminUser();
        $menu = Menu::factory()->create();

        $this->assertCount(1,Restaurant::where('id',$menu->restaurant->id)->get());
        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);

        $this->actingAs($user)->delete($menu->restaurant->path())->assertStatus(302);
        $this->assertCount(0,Restaurant::where('id',$menu->restaurant->id)->get());
        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);
    }

    /** @test */
    public function delete_a_restaurant_that_doesnt_have_a_product() :void 
    {
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();

        $menu = $category->menu;
        $this->assertCount(1,Restaurant::where('id',$menu->restaurant->id)->get());
        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);

        $this->actingAs($user)->delete($menu->restaurant->path())->assertStatus(302);
        $this->assertCount(0,Restaurant::where('id',$menu->restaurant->id)->get());
        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        $this->assertCount(0,Category::where('id',$category->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);
    }


    /** @test */
    public function delete_a_restaurant_with_a_product_without_picture() :void 
    {
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();
        
        $file = UploadedFile::fake()->image('product.jpg');

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);
        
        $menu = $category->menu;
        Storage::disk('public')->assertMissing('product_pictures/' . $file->hashName());
        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);

        $this->assertEquals(null, Product::first()->picture);
        $this->assertCount(1,Product::where('category_id',$category->id)->get());

        $this->actingAs($user)->delete($menu->restaurant->path());
        $this->assertCount(0,Restaurant::where('id',$menu->restaurant->id)->get());
        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        $this->assertCount(0,Category::where('id',$category->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);
        
        Storage::disk('public')->assertMissing('product_pictures/' . $file->hashName());
    }

    /** @test */
    public function create_a_restaurant_with_2_products() :void 
    {
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();
        
        $file = UploadedFile::fake()->image('product.jpg');

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume 1',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume 2',
            'price' => 600.00,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);

        $menu = $category->menu;
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());
        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);

        $this->assertEquals('product_pictures/' . $file->hashName(), Product::where('name','Nume 1')->first()->picture);
        $this->assertCount(2,Product::where('category_id',$category->id)->get());

        $this->actingAs($user)->delete($menu->restaurant->path());
        $this->assertCount(0,Restaurant::where('id',$menu->restaurant->id)->get());
        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        $this->assertCount(0,Category::where('id',$category->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);
        
        Storage::disk('public')->assertMissing('product_pictures/' . $file->hashName());
    } 
}
