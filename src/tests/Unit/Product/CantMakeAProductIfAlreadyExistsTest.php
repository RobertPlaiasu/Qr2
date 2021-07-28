<?php

namespace Tests\Unit\Product;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\DataForAuthorizationTrait;

class CantMakeAProductIfAlreadyExistsTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function throw_error_if_product_name_already_exists_in_that_category() :void 
    {
        $category = Category::factory()->create();
        $user = $this->getTheAdminUser();

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasNoErrors('name');

        $this->assertCount(1,Product::where('category_id',$category->id)->get());

        $this->actingAs($user)->post('/categories/'.$category->id.'/products',[
            'name' => 'Nume',
            'price' => 300.15,
            'weight' => 5,
            'available' => false,
            'ingredients' => 'mere,salam,mozzarela,peperoni',
        ])->assertSessionHasErrors();

        $errors = session('errors');
        $this->assertEquals($errors->all()[0],"Exista deja un produs cu acest nume !");

        $this->assertCount(1,Product::where('category_id',$category->id)->get());
    }


    /** @test */
    public function if_product_exists_in_another_category_do_not_throw_error() :void 
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create([
            'menu_id' => $category1->menu->id,
        ]);
        $user = $this->getTheAdminUser();
    
        $this->actingAs($user)->post('/categories/'.$category1->id.'/products',[
            'name' => 'Nume',
            'price' => 10000.15,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasNoErrors();
    
        $this->assertCount(1,Product::where('category_id',$category1->id)->get());

        $this->actingAs($user)->post('/categories/'.$category2->id.'/products',[
            'name' => 'Nume',
            'price' => 500.15,
            'weight' => 100,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertSessionHasNoErrors();
    
        $this->assertCount(1,Product::where('category_id',$category2->id)->get());
    }


}
