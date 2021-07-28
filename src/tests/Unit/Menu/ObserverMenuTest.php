<?php

namespace Tests\Unit\Menu;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ObserverMenuTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */

    public function after_it_deletes_a_menu_delete_category_and_product_for_the_menu() :void
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
        
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $this->assertEquals('product_pictures/' . $file->hashName(), Product::first()->picture);
        $this->assertCount(1,Product::where('name','Nume')->get());

        $menu = $category->menu;
        $this->actingAs($user)->delete($menu->restaurant->path() . $menu->path());
        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        $this->assertCount(0,Category::where('id',$category->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);
        
        Storage::disk('public')->assertMissing('product_pictures/' . $file->hashName());
    }

    /** @test */
    public function created_observer_works() :void
    {
        $menu = Menu::factory()->create();

        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);
        $menu->delete();
    }

    /** @test */
    public function updated_observer_works() :void
    {
        $menu = Menu::factory()->create();
        $user = $this->getTheAdminUser();

        $response = $this->actingAs($user)->put($menu->restaurant->path() . $menu->path(),[
            'name' => 'Nume Menu',
        ]);

        Storage::disk('public')->assertExists('qr/' . $menu->id . $menu->qrExtension);

        $menu->delete();
    }

    /** @test */
    public function delete_a_menu_and_category_has_more_than_1_product() :void 
    {
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();
        
        $file1 = UploadedFile::fake()->image('product1.jpg');
        $file2 = UploadedFile::fake()->image('product2.jpg');

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume 1',
            'price' => 600.00,
            'picture' => $file1,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume  2',
            'price' => 600.00,
            'picture' => $file2,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);
        
        Storage::disk('public')->assertExists('product_pictures/' . $file1->hashName());
        Storage::disk('public')->assertExists('product_pictures/' . $file2->hashName());

        $menu = $category->menu;
        $this->actingAs($user)->delete($menu->restaurant->path() . $menu->path());

        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        $this->assertCount(0,Category::where('id',$category->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);

        Storage::disk('public')->assertMissing('product_pictures/' . $file1->hashName());
        Storage::disk('public')->assertMissing('product_pictures/' . $file2->hashName());
    }

    /** @test */
    public function delete_menu_and_a_product_doesnt_have_picture() :void 
    {
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();
        
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product1.jpg');

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume 1',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume  2',
            'price' => 600.00,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);
        
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $menu = $category->menu;
        $this->actingAs($user)->delete($menu->restaurant->path() . $menu->path());

        $this->assertCount(0,Menu::where('id',$menu->id)->get());
        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        $this->assertCount(0,Category::where('id',$category->id)->get());
        Storage::disk('public')->assertMissing('qr/' . $menu->id . $menu->qrExtension);

        Storage::disk('public')->assertMissing('product_pictures/' . $file->hashName());
    }

}
