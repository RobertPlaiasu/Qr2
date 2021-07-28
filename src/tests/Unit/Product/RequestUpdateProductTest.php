<?php

namespace Tests\Unit\Product;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\DataForAuthorizationTrait;

class RequestUpdateProductTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function validate_category_id_field() :void
    {
        $product = Product::factory()->create();
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'salam,bere,tigari',
            'category_id' => 8,
        ])->assertSessionHasErrors('category_id');

        $errors = session('errors');
        $this->assertEquals($errors->get('category_id')[0],"Categoria nu exista in baza de date.");

        $category = Category::factory()->create([
            'menu_id' => $product->category->menu->id,
        ]);

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'salam,bere,tigari',
            'category_id' => $category->id,
        ])->assertSessionHasNoErrors('category_id');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'salam,bere,tigari',
            'category_id' => $category->id,
        ])->assertSessionHasNoErrors('category_id');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'salam,bere,tigari',
            'category_id' => 'name',
        ])->assertSessionHasErrors('category_id');

    }

    /** @test */
    public function validate_picture_field_update()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf',2000,'application/pdf');
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)->json('PUT','/products/' . $product->id,[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $category->id,
        ])->assertJsonValidationErrors('picture');

        $this->actingAs($user)->json('PUT','/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => '',
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $category->id,
        ])->assertJsonValidationErrors('picture');

        $this->actingAs($user)->json('PUT','/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => 'poza',
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $category->id,
        ])->assertJsonValidationErrors('picture');
    }

    /** @test */
    public function validate_name_field_update()
    {
       $product = Product::factory()->create(); 
       $user = $this->getTheAdminUser();

       $this->actingAs($user)->put('/products/'.$product->id,[
        'name' => '',
        'price' => 10000.15,
        'weight' => 200,
        'available' => true,
        'ingredients' => 'rosii,salam,mozzarela,peperoni',
        'category_id' => $product->category->id,
    ])->assertSessionHasErrors('name');

    $this->actingAs($user)->put('/products/'.$product->id,[
        'name' => 'a',
        'price' => 10000.15,
        'weight' => 200,
        'available' => true,
        'ingredients' => 'rosii,salam,mozzarela,peperoni',
        'category_id' => $product->category->id,
    ])->assertSessionHasErrors('name');

    $this->actingAs($user)->put('/products/'.$product->id,[
        'name' => 1234,
        'price' => 10000.15,
        'weight' => 200,
        'available' => true,
        'ingredients' => 'rosii,salam,mozzarela,peperoni',
        'category_id' => $product->category->id,
    ])->assertSessionHasErrors('name');

    $this->actingAs($user)->put('/products/'.$product->id,[
        'name' => 'Nume',
        'price' => 10000.15,
        'weight' => 200,
        'available' => true,
        'ingredients' => 'rosii,salam,mozzarela,peperoni',
        'category_id' => $product->category->id,
    ])->assertSessionHasNoErrors('name');
    }

    /** @test */
    public function validate_price_field_update() :void
    {
        $user = $this->getTheAdminUser();
        $product = Product::factory()->create();
        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 600,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasNoErrors('price');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => null,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 'merge',
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 100.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasNoErrors('price');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 2000.153,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => -20000000000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->put('/products/'. $product->id,[
            'name' => 'Nume',
            'price' => 100000000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('price');  
    }

    /** @test */
    public function validate_weight_field_update() :void
    {
        $user = $this->getTheAdminUser();
        $product = Product::factory()->create();

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasNoErrors('weight');

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => null,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('weight');

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 10000000,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('weight');

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 'nume',
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('weight');
    }
    
    /** @test */
    public function validate_ingredients_field_update() :void
    {
        $user = $this->getTheAdminUser();
        $product = Product::factory()->create();

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => '',
            'category_id' => $product->category->id,
        ])->assertSessionHasNoErrors('ingredients');

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'category_id' => $product->category->id,
        ])->assertSessionHasNoErrors('ingredients');

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume1',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 1,
            'category_id' => $product->category->id,
        ])->assertSessionHasNoErrors('ingredients');

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume2',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'category_id' => $product->category->id,
        ])->assertSessionHasErrors('ingredients');

        $this->actingAs($user)->put('/products/'.$product->id,[
            'name' => 'Nume3',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'salam,bere,tigari',
            'category_id' => $product->category->id,
        ])->assertSessionHasNoErrors('ingredients');
    }
}
