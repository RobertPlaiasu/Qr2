<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\County;
use App\Models\Permission;
use App\Models\City;
use App\Models\UserRestaurant;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Role;
use App\Models\Invitation;
use App\Models\Product;

class SuperAdminTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;

    /** @test */
    public function acces_super_admin_restaurants()
    {
        //$this->withoutExceptionHandling();
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $restaurant = Restaurant::first();


        // restaurant
        $this->get($restaurant->path())->assertStatus(200);
        $this->actingAs($user)->get('/restaurants')->assertStatus(200);
        $this->actingAs($user)->post('/restaurants')->assertStatus(302);
        $this->actingAs($user)->get($restaurant->path().'/edit')->assertStatus(200);
        $this->actingAs($user)->get($restaurant->path())->assertStatus(200);
        $this->actingAs($user)->delete($restaurant->path())->assertStatus(302);

    }

    /** @test */
    public function acces_super_admin_counties()
    {

        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $county  = County::first();

        $this->get('/counties')->assertStatus(302);
        $this->actingAs($user)->get('/counties')->assertStatus(200);
        $this->actingAs($user)->post('/counties')->assertStatus(302);
        $this->actingAs($user)->get('/counties/'.$county->id.'/edit')->assertStatus(200);
        $this->actingAs($user)->delete('/counties/'.$county->id)->assertStatus(302);
    }

    /** @test */
    public function super_admin_permissions_permission()
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $permission  = Permission::first();
        //permission
        $this->actingAs($user)->get('/permissions')->assertStatus(200);
        $this->actingAs($user)->post('/permissions')->assertStatus(302);
        $this->actingAs($user)->get('/permissions/'. $permission->id .'/edit')->assertStatus(200);
        $this->actingAs($user)->delete('/permissions/'. $permission->id)->assertStatus(302);
    }

    /** @test */
    public function super_admin_permissions_cities() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $city  = City::first();
        //city
        $this->actingAs($user)->get('/cities')->assertStatus(200);
        $this->actingAs($user)->get('/cities/create')->assertStatus(200);
        $this->actingAs($user)->post('/cities')->assertStatus(302);
        $this->actingAs($user)->get('/cities/'.$city->id.'/edit')->assertStatus(200);
        $this->actingAs($user)->put('/cities/'.$city->id)->assertStatus(302);
        $this->actingAs($user)->delete('/cities/'.$city->id)->assertStatus(302);
    }

    /** @test */
    public function super_admin_permissions_assign_roles()
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $restaurant = Restaurant::first();
        $userRestaurant = UserRestaurant::first();

        // UserRestaurant
        $this->actingAs($user)->get('assign_roles/create')->assertStatus(200);
        $this->actingAs($user)->post('assign_roles')->assertStatus(302);
        $this->actingAs($user)->get('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id .'/edit')->assertStatus(200);
        $this->actingAs($user)->put('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id)->assertStatus(302);
        $this->actingAs($user)->delete('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id)->assertStatus(302);
    }

    /** @test */
    public function super_admin_permissions_menu()
    {
        $this->withoutExceptionHandling();
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $restaurant = Restaurant::first();
        $menu = Menu::where('restaurant_id',$restaurant->id)->first();
        //Menu
        $this->actingAs($user)->get('/menus')->assertStatus(200);
        $this->actingAs($user)->get($restaurant->path() . '/menus/create')->assertStatus(200);
        $this->actingAs($user)->post( $restaurant->path().'/menus',[
            'name' => 'Nume'
        ])->assertStatus(302);
        $this->actingAs($user)->get($menu->path())->assertStatus(200);
        $this->actingAs($user)->get($restaurant->path() . $menu->path() . '/edit')->assertStatus(200);
        $this->actingAs($user)->put($restaurant->path() . $menu->path(),[
            'name' => 'Nume'
        ])->assertStatus(302);
        $this->actingAs($user)->delete($restaurant->path() . $menu->path())->assertStatus(302);
    }

    /** @test */
    public function super_admin_permissions_category() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $menu = Menu::first();
        $category = Category::where('menu_id',$menu->id)->first();

        //Category
        $this->actingAs($user)->get($menu->path() . '/categories')->assertStatus(200);
        $this->actingAs($user)->get($menu->path() . '/categories/create')->assertStatus(200);
        $this->actingAs($user)->post( $menu->path() . '/categories/',[
            'name' => 'Nume'
        ])->assertStatus(302);
        $this->actingAs($user)->get($menu->path() . '/categories/' . $category->id)->assertStatus(200);
        $this->actingAs($user)->get($menu->path() . '/categories/' . $category->id. '/edit')->assertStatus(200);
        $this->actingAs($user)->put($menu->path() . '/categories/' . $category->id,[
            'name' => 'Nume'
        ])->assertStatus(302);
        $this->actingAs($user)->delete($menu->path() . '/categories/' . $category->id)->assertStatus(302);
    }

    /** @test */
    public function super_admin_permissions_download_qr() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $restaurant = Restaurant::factory()->create();
        UserRestaurant::factory()->create([
            'user_id' => $user->id,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name','patron_restaurant')->first()->id,
        ]);
        $menu = Menu::factory()->create([
            'restaurant_id' => $restaurant->id,
        ]);

        //Download Qr
        $this->actingAs($user)->get($menu->path() . '/download')->assertStatus(200);
    }


    /** @test */
    public function super_admin_permissions_role() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $permissions = $this->makePermissions();
        $role = Role::factory()->create();

        //Roles
        $this->actingAs($user)->get('/roles')->assertStatus(200);
        $this->actingAs($user)->get('/roles/create')->assertStatus(200);
        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
        ])->assertStatus(302);
        $this->actingAs($user)->get('/roles/' .  $role->id)->assertStatus(200);
        $this->actingAs($user)->get('/roles/' .  $role->id . '/edit')->assertStatus(200);
        $this->actingAs($user)->put('/roles/' .  $role->id,[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
        ])->assertStatus(302);
        $this->actingAs($user)->delete('/roles/' .  $role->id)->assertStatus(302);
    }


    /** @test */
    public function super_admin_permissions_invitations() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $restaurant = Restaurant::factory()->create();
        $role = Role::where('name', 'angajat_restaurant')->first();
        $userInvited = User::factory()->create();

        $this->actingAs($user)->get('invitations')->assertStatus(200);
        $this->actingAs($user)->get('staff' . $restaurant->path())->assertStatus(200);
        $this->actingAs($user)->get($restaurant->path().'/invitations/create')->assertStatus(200);
        $this->actingAs($user)->post($restaurant->path().'/invitations',[
            'email' => $userInvited->email,
            'role_id' => $role->id,
            'restaurant_id' => $restaurant->id,
        ])->assertStatus(302);
        $this->assertCount(1,Invitation::where('email',$userInvited->email)
                                        ->where('role_id',$role->id)
                                        ->where('restaurant_id',$restaurant->id)->get());
        $invitation = Invitation::where('email',$userInvited->email)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->first();

        $this->actingAs($user)->post('invitations/' . $invitation->id . '/accept')->assertStatus(302);

        $invitation = Invitation::factory()->create([
            'email' => $userInvited->email,
            'role_id' => $role->id,
            'restaurant_id' =>$restaurant->id,
        ]);

        $this->actingAs($user)->delete('invitations/' . $invitation->id)->assertStatus(302);

        $this->assertCount(0,Invitation::where('email',$userInvited->email)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());

    }

    /** @test */
    public function super_admin_permissions_product() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[0];
        $category = Category::first();

        $this->actingAs($user)->get('/categories/' . $category->id . '/products/create')->assertStatus(200);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');
        $this->actingAs($user)->json('POST','/categories/' . $category->id . '/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertStatus(302);

        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $file = UploadedFile::fake()->image('product.jpg');

        $this->actingAs($user)->json('PUT','/products/' . $product->id,[
            'name' => 'Nume Nou',
            'price' => 600.20,
            'picture' => $file,
            'weight' => 300,
            'available' => false,
            'ingredients' => 'rosii,salam,mozzarela,lapte',
            'category_id' => $category->id,
        ])->assertStatus(302);

        Storage::disk('public')->assertExists('product_pictures/' . $file->hashName());

        $this->actingAs($user)->delete('/products/' . $product->id)->assertStatus(302);

        $product = Product::factory()->create();

        $this->actingAs($user)->post('/products/' . $product->id . '/change-availability')->assertStatus(302);
    }

}
