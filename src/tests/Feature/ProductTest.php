<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class ProductTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function can_make_a_product()
    {
        $this->withoutExceptionHandling();
        $user = $this->getTheAdminUser();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');

        $category = $this->makeCategory();

        $response = $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);

        $this->assertEquals('product_pictures/' . $file->hashName(), Product::first()->picture);
        $this->assertCount(1,Product::where('name','Nume')->get());
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $response->assertRedirect(Product::first()->category->menu->path(true) .'/categories/'.Product::first()->category_id);
    }

    /** @test */
    public function update_a_product()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product1.jpg');

        $category = Category::factory()->create();
        $user =  $this->getTheAdminUser();

        $this->actingAs($user)->json('POST','/categories/'. $category->id .'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);

        $product = Product::where('category_id',$category->id)->first();
        $this->assertEquals('product_pictures/' . $file->hashName(), $product->picture);
        $this->assertCount(1,Product::all());
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $category = Category::factory()->create([
            'menu_id' => $category->menu->id,
        ]);

        $file = UploadedFile::fake()->image('product2.jpg');
        $response = $this->actingAs($user)->json('PUT','/products/' . $product->id,[
            'name' => 'Nume Nou',
            'price' => 600.20,
            'picture' => $file,
            'weight' => 300,
            'ingredients' => 'rosii,salam,mozzarela,lapte',
            'category_id' => $category->id,
        ]);


        $product = Product::where('category_id',$category->id)->first();

        $this->assertEquals('product_pictures/' . $file->hashName(), $product->picture);
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());
        $this->assertEquals('Nume Nou',$product->name);
        $this->assertEquals(600.20,$product->price);
        $this->assertEquals(300,$product->weight);
        $this->assertEquals(1,$product->available);
        $this->assertEquals('rosii,salam,mozzarela,lapte',$product->ingredients);
        $this->assertEquals($category->id,$product->category->id);

        $product = Product::where('category_id',$category->id)->first();
        //dd($product);

        $response->assertRedirect($product->category->menu->path(true) . '/categories/' . $product->category_id);
    }

    /** @test */
    public function can_destroy_a_product()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product1.jpg');

        $category = $this->makeCategory();
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->json('POST','/categories/'. $category->id .'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $category->id,
        ]);

        $product = Product::first();
        $this->assertEquals('product_pictures/' . $file->hashName(), $product->picture);
        $this->assertCount(1,Product::all());
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $response = $this->actingAs($user)->delete('products/' . $product->id);
        $this->assertCount(0,Product::all());

        $response->assertRedirect($product->category->menu->path(true) . '/categories/' . $product->category_id);
    }

    /** @test */
    public function can_change_availability()
    {
        $this->withoutExceptionHandling();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product1.jpg');

        $category = $this->makeCategory();
        $user = $this->getTheAdminUser();;

        $this->actingAs($user)->json('POST','/categories/'. $category->id .'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $category->id,
        ]);

        $product = Product::first();
        $this->assertEquals('product_pictures/' . $file->hashName(), $product->picture);
        $this->assertCount(1,Product::all());
        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $response = $this->actingAs($user)->json('POST','/products/' . $product->id . '/change-availability');
        $this->assertEquals(0,Product::first()->available);
    }

    private function makeCategory() :Category
    {

        return Category::factory()->create();

    }

    private function makeProduct() :Product
    {
        return Product::factory()->create();
    }
}
