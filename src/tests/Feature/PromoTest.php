<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Promo;
use App\Models\Product;
use Carbon\Carbon;

class PromoTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;
    
    /** @test */
    public function create_a_promo() :void
    {
        $this->withoutExceptionHandling();
        $user = $this->getTheAdminUser();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('promo.jpg');
        $product = Product::factory()->create();

        $this->assertCount(0,Promo::all());

        $response = $this->actingAs($user)->post($product->category->menu->path() . '/promos',[
            'name' => 'Nume',
            'price' => 6000,
            'picture' => $file,
            'expire' => Carbon::now()->addDays(5),
            'products' => [$product->id],
        ]);

        $this->assertEquals('promo_pictures/' . $file->hashName(), Promo::first()->picture);
        $this->assertCount(1,Promo::where('name','Nume')->get());
        Storage::disk('public')->assertExists('promo_pictures/' . $file->hashName());
        $response->assertRedirect($product->category->menu->path().'/promos');
    }

    /** @test */
    public function update_a_promo() :void
    {
        $this->withoutExceptionHandling();
        $user = $this->getTheAdminUser();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('promo.jpg');
        $product = Product::factory()->create();

        $this->assertCount(0,Promo::all());

        $response = $this->actingAs($user)->post($product->category->menu->path() . '/promos',[
            'name' => 'Nume',
            'price' => 6000,
            'picture' => $file,
            'expire' => Carbon::now()->addDays(5),
            'products' => [$product->id],
        ]);

        $this->assertEquals('promo_pictures/' . $file->hashName(), Promo::first()->picture);
        $this->assertCount(1,Promo::where('name','Nume')->get());
        Storage::disk('public')->assertExists('promo_pictures/' . $file->hashName());

        $file2 = UploadedFile::fake()->image('promo.jpg');

        $response = $this->actingAs($user)->put($product->category->menu->path() . '/promos/' . Promo::first()->id,[
            'name' => 'Nume nou',
            'price' => 60000,
            'picture' => $file2,
            'expire' => Carbon::now()->addDays(7),
            'products' => [$product->id],
        ]);

        $this->assertEquals('promo_pictures/' . $file2->hashName(), Promo::first()->picture);
        Storage::disk('public')->assertExists('promo_pictures/' . $file2->hashName());
        $this->assertEquals('Nume nou',Promo::first()->name);
        $this->assertEquals(60000,Promo::first()->price);
        $this->assertEquals(1,Promo::first()->products[0]->id);
        $this->assertCount(1,Promo::first()->products);

        $response->assertRedirect($product->category->menu->path() . '/promos');
    }

    /** @test */
    public function delete_a_promo() :void
    {
        $this->withoutExceptionHandling();
        $user = $this->getTheAdminUser();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('promo.jpg');
        $product = Product::factory()->create();

        $this->assertCount(0,Promo::all());

        $response = $this->actingAs($user)->post($product->category->menu->path() . '/promos',[
            'name' => 'Nume',
            'price' => 6000,
            'picture' => $file,
            'expire' => Carbon::now()->addDays(5),
            'products' => [$product->id],
        ]);

        $this->assertEquals('promo_pictures/' . $file->hashName(), Promo::first()->picture);
        $this->assertCount(1,Promo::where('name','Nume')->get());
        Storage::disk('public')->assertExists('promo_pictures/' . $file->hashName());

        $this->actingAs($user)->delete($product->category->menu->path() . '/promos/' . Promo::first()->id);

        $this->assertCount(0,Promo::where('name','Nume')->get());
        Storage::disk('public')->assertMissing('promo_pictures/' . $file->hashName());
    }
}
