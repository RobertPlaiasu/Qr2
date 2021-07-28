<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\County;
use App\Models\Permission;
use App\Models\City;
use App\Models\UserRestaurant;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Role;
use App\Models\Invitation;
use App\Models\Product;

class GuestUserTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function guest_permissions_restaurant()
    {
        //$this->withoutExceptionHandling();
        $this->insertAllTheSeedersAndReturnUsers();
        $restaurant = Restaurant::first();
        //dd($restaurant->path());
        $this->get('/restaurants')->assertRedirect('login');
        $this->post('/restaurants')->assertRedirect('login');
        $this->get($restaurant->path().'/edit')->assertRedirect('login');
        $this->get($restaurant->path())->assertStatus(200);
        $this->delete($restaurant->path())->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_counties()
    {
        $this->insertAllTheSeedersAndReturnUsers();
        $county  = County::first();
        //county
        $this->get('/counties')->assertRedirect('login');
        $this->post('/counties')->assertRedirect('login');
        $this->get('/counties/'.$county->id.'/edit')->assertRedirect('login');
        $this->delete('/counties/'.$county->id)->assertRedirect('login');
        $this->get('/counties')->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_permission()
    {
        $this->insertAllTheSeedersAndReturnUsers();
        $permission  = Permission::first();
        //permission
        $this->get('/permissions')->assertRedirect('login');
        $this->post('/permissions')->assertRedirect('login');
        $this->get('/permissions/'. $permission->id .'/edit')->assertRedirect('login');
        $this->delete('/permissions/'. $permission->id)->assertRedirect('login');
        $this->get('/permissions')->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_cities() :void
    {
        $this->insertAllTheSeedersAndReturnUsers();
        $city  = City::first();
        //city
        $this->get('/cities')->assertRedirect('login');
        $this->post('/cities')->assertRedirect('login');
        $this->get('/cities/'.$city->id.'/edit')->assertRedirect('login');
        $this->delete('/cities/'.$city->id)->assertRedirect('login');
        $this->get('/cities')->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_assign_roles()
    {
        //$this->withoutExceptionHandling();
        $this->insertAllTheSeedersAndReturnUsers();
        $factories = $this->makeFactories();
        $restaurant = Restaurant::first();
        $userRestaurant = UserRestaurant::where('restaurant_id',$restaurant->id)->first();

        // UserRestaurant
        $this->get('assign_roles/create')->assertRedirect('login');
        $this->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
        ])->assertRedirect('login');

        $this->get('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id .'/edit')->assertRedirect('login');

        $this->put('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id,[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
        ])->assertRedirect('login');
        $this->delete('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id)->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_menu() :void
    {
        $this->insertAllTheSeedersAndReturnUsers();
        $restaurant = Restaurant::first();
        $menu = Menu::where('restaurant_id',$restaurant->id)->first();
        $this->get($menu->path())->assertStatus(200);

        //Menu
        $this->get('/menus')->assertRedirect('login');
        $this->get($restaurant->path() . '/menus/create')->assertRedirect('login');
        $this->post( $restaurant->path().'/menus',[
            'name' => 'Nume'
        ])->assertRedirect('login');
        $this->get($restaurant->path() . $menu->path() . '/edit')->assertRedirect('login');
        $this->put($restaurant->path() . $menu->path(),[
            'name' => 'Nume'
        ])->assertRedirect('login');
        $this->get($menu->path())->assertStatus(200);
        $this->delete($restaurant->path() . $menu->path())->assertRedirect('login');
        $this->get($restaurant->path() . '/menus/create')->assertRedirect('login');
        $this->post( $restaurant->path().'/menus',[
            'name' => 'Nume'
        ])->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_category() :void
    {
        $this->insertAllTheSeedersAndReturnUsers();

        $menu = Menu::first();
        $category = Category::where('menu_id',$menu->id)->first();

        //Category
        $this->get($menu->path() . '/categories')->assertRedirect('login');
        $this->get($menu->path() . '/categories/create')->assertRedirect('login');
        $this->post( $menu->path() . '/categories/',[
            'name' => 'Nume'
        ])->assertRedirect('login');
        $this->get($menu->path() . '/categories/' . $category->id)->assertRedirect('login');
        $this->get($menu->path() . '/categories/' . $category->id. '/edit')->assertRedirect('login');
        $this->put($menu->path() . '/categories/' . $category->id,[
            'name' => 'Nume'
        ])->assertRedirect('login');
        $this->delete($menu->path() . '/categories/' . $category->id)->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_download_qr() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $userOwnerRestaurant = User::factory()->create();

        $restaurant = Restaurant::factory()->create();
        UserRestaurant::factory()->create([
            'user_id' => $userOwnerRestaurant->id,
            'restaurant_id' => $restaurant->id,
            'role_id' => Role::where('name','patron_restaurant')->first()->id,
        ]);
        $menu = Menu::factory()->create([
            'restaurant_id' => $restaurant->id,
        ]);

        //Download Qr
        $this->get($menu->path() . '/download')->assertRedirect('login');
    }


    /** @test */
    public function guest_permissions_role() :void
    {
        $this->insertAllTheSeedersAndReturnUsers();
        $permissions = $this->makePermissions();
        $role = Role::factory()->create();

        //Roles
        $this->get('/roles')->assertRedirect('login');
        $this->get('/roles/create')->assertRedirect('login');
        $this->post('/roles',[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
        ])->assertRedirect('login');
        $this->get('/roles/' .  $role->id)->assertRedirect('login');
        $this->get('/roles/' .  $role->id . '/edit')->assertRedirect('login');
        $this->put('/roles/' .  $role->id,[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
        ])->assertRedirect('login');
        $this->delete('/roles/' .  $role->id)->assertRedirect('login');
    }

    /** @test */
    public function guest_permissions_invitations() :void
    {
        //$this->withoutExceptionHandling();
        $this->insertAllTheSeedersAndReturnUsers();

        $restaurant = Restaurant::first();
        $role = Role::factory()->create();
        $userInvited = User::factory()->create();

        $this->get('invitations')->assertRedirect('login');
        $this->get('staff' . $restaurant->path())->assertRedirect('login');
        $this->get($restaurant->path().'/invitations/create')->assertRedirect('login');
        $this->post($restaurant->path().'/invitations',[
            'email' => $userInvited->email,
            'role_id' => $role->id,
            'restaurant_id' => $restaurant->id,
        ])->assertRedirect('login');

        $restaurant = Restaurant::factory()->create();

        Invitation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'email' => $userInvited->email,
            'role_id' => $role->id
        ]);

        $invitation = Invitation::where('email',$userInvited->email)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->first();

        $this->post('invitations/' . $invitation->id . '/accept')->assertRedirect('login');
        $this->delete('invitations/' . $invitation->id)->assertRedirect('login');

        $invitation = Invitation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'email' => $userInvited->email,
            'role_id' => $role->id
        ]);

        $this->post('invitations/' . $invitation->id . '/accept')->assertRedirect('login');

        $this->assertCount(2,Invitation::where('email',$userInvited->email)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());

        $this->assertCount(0,UserRestaurant::where('user_id',$userInvited->id)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());

        $this->delete('invitations/' . $invitation->id)->assertRedirect('login');

        $this->assertCount(0,UserRestaurant::where('user_id',$userInvited->id)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());
    }

    /** @test */
    public function guest_permissions_product() :void
    {
        //$this->withoutExceptionHandling();
        $this->insertAllTheSeedersAndReturnUsers();
        $category = Category::first();

        $this->get('/categories/' . $category->id . '/products')->assertRedirect('login');
        $this->get('/categories/' . $category->id . '/products/create')->assertRedirect('login');

        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');
        $this->json('POST','/categories/' . $category->id . '/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertStatus(401);

        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->get('/products/' . $product->id . '/edit')->assertRedirect('login');

        $this->json('PUT','/products/' . $product->id,[
            'name' => 'Nume Nou',
            'price' => 600.20,
            'picture' => $file,
            'weight' => 300,
            'available' => false,
            'ingredients' => 'rosii,salam,mozzarela,lapte',
            'category_id' => $category->id,
        ])->assertStatus(401);;

        $this->delete('/products/' . $product->id)->assertRedirect('login');

        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->post('/products/' . $product->id . '/change-availability')->assertRedirect('login');
    }


}
