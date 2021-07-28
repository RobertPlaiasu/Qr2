<?php

namespace Tests\Unit\Category;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\Menu;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function delete_a_category_and_delete_all_product_photos() :void 
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

        $this->actingAs($user)->delete($category->menu->path() . '/categories/' . $category->id );

        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        Storage::disk('public')->assertMissing($product->picture);

        $this->assertCount(0,Category::where('id',$category->id)->get());
        $this->assertCount(1,Menu::where('id',$category->menu->id)->get());
    }

    /** @test */
    public function delete_a_category_and_product_doesnt_have_picture() :void
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

        $this->actingAs($user)->json('POST','/categories/'.$category->id.'/products',[
            'name' => 'Nume 2',
            'price' => 600.00,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ]);
        

        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $this->assertEquals('product_pictures/' . $file->hashName(), Product::where('category_id',$category->id)->first()->picture);
        $this->assertCount(2,Product::where('category_id',$category->id)->get());

        $product = Product::where('category_id',$category->id)->first();
        $this->actingAs($user)->delete($category->menu->path() . '/categories/' . $category->id );
        
        $this->assertCount(0,Product::where('category_id',$category->id)->get());
        Storage::disk('public')->assertMissing($product->picture);

        $this->assertCount(0,Category::where('id',$category->id)->get());
        $this->assertCount(1,Menu::where('id',$category->menu->id)->get());
    }
}
