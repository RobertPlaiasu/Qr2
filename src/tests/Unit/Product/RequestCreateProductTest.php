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

class RequestCreateProductTest extends TestCase
{

    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function validate_name_field_create()
    {
        $category = Category::factory()->create();
        $user = $this->getTheAdminUser();;

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => '',
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'a',
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 1234,
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('name');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasNoErrors('name');
    }

    /** @test */
    public function validate_price_field_create()
    {
        $user = $this->getTheAdminUser();;
        $category = Category::factory()->create();
        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 600,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasNoErrors('price');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Mel',
            'price' => null,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Mel',
            'price' => 'merge',
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Lim',
            'price' => 100.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasNoErrors('price');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Lim',
            'price' => 2000.153,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Lim',
            'price' => -200.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Lim',
            'price' => 100000000000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('price');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Lim',
            'price' => 0,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('price');
    }

    /** @test */
    public function validate_weight_field_create()
    {
        $category = Category::factory()->create();
        $user  = $this->getTheAdminUser();;

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasNoErrors('weight');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => null,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('weight');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 10000000,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('weight');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 'nume',
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('weight');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => -345,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('weight');
       
        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 0,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('weight');
    }

    /** @test */
    public function validate_ingredients_field_create()
    {
        $category = Category::factory()->create();
        $user = $this->getTheAdminUser();;

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => '',
        ])->assertSessionHasNoErrors('ingredients');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume 2',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
        ])->assertSessionHasErrors('ingredients');

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume 3',
            'price' => 10000.15,
            'weight' => 500,
            'available' => true,
            'ingredients' => 'salam,bere,tigari',
        ])->assertSessionHasNoErrors('ingredients');
    }

    /** @test */
    public function validate_picture_field()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf',2000,'application/pdf');
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();

        $this->actingAs($user)->json('POST','/categories/'. $category->id .'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertJsonValidationErrors('picture');

        $this->actingAs($user)->json('POST','/categories/'. $category->id .'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => '',
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertJsonValidationErrors('picture');

        $this->actingAs($user)->json('POST','/categories/'. $category->id .'/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => 'poza',
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertJsonValidationErrors('picture');
    }

    /** @test */
    public function error_message_for_notIn_create_product_request()
    {   
        $user = $this->getTheAdminUser();
        $category = Category::factory()->create();
        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume Lim',
            'price' => 0,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors('price');
        
        $errors = session('errors');
        $this->assertEquals($errors->get('price')[0],"Pretul trebuie sa fie diferit de 0.");
    }

}
