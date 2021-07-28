<?php

namespace Tests\Unit\Product;

use Tests\TestCase;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Product;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductObserverTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function after_delete_a_product_delete_his_photo() :void 
    {
        Storage::fake('public');
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

        $this->assertEquals('product_pictures/' . $file->hashName(), Product::where('category_id',$category->id)->first()->picture);
        $this->assertCount(1,Product::where('category_id',$category->id)->get());

        $product = Product::where('category_id',$category->id)->first();

        $this->actingAs($user)->delete('/products/' . $product->id );

        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        Storage::disk('public')->assertMissing($product->picture);

        $this->assertCount(1,Category::where('id',$category->id)->get());
    }


    /** @test */
    public function delete_a_product_and_doesnt_have_a_picture() :void 
    {
        Storage::fake('public');
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
        

        Storage::disk('public')->assertMissing('product_pictures/' . $file->hashName());

        $this->assertEquals(null, Product::where('category_id',$category->id)->first()->picture);
        $this->assertCount(1,Product::where('category_id',$category->id)->get());

        $product = Product::where('category_id',$category->id)->first();

        $this->actingAs($user)->delete('/products/' . $product->id );

        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        Storage::disk('public')->assertMissing($product->picture);

        $this->assertCount(1,Category::where('id',$category->id)->get());
    }
}
