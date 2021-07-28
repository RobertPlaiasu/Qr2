<?php

namespace Tests\Unit\Product;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Tests\Feature\DataForAuthorizationTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductShowErrorInMenuIsNotTheSameTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function change_the_category_of_a_product_with_one_that_is_not_in_the_menu() :void 
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->put('products/'. $product->id,[
            'name' => 'Nume',
            'price' => 600.00,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
            'category_id' => $category->id,
        ])->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->all()[0],'Aceasta categorie nu este disponibila.');
    }
}
