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

class EmployeeTest extends TestCase
{
    use RefreshDatabase,DataForAuthorizationTrait;


    /** @test */
    public function employee_permissions_restaurant()
    {
        // $this->withoutExceptionHandling();
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $restaurant = Restaurant::first();
        // dd($restaurant->path());
        $this->actingAs($users[2])->get('/restaurants')->assertStatus(403);
        $this->actingAs($users[2])->post('/restaurants')->assertStatus(403);
        $this->actingAs($users[2])->get($restaurant->path().'/edit')->assertStatus(403);
        $this->actingAs($users[2])->get($restaurant->path())->assertStatus(200);
        $this->actingAs($users[2])->delete($restaurant->path())->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_counties()
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $county  = County::first();
        //county
        $this->actingAs($users[2])->get('/counties')->assertStatus(403);
        $this->actingAs($users[2])->post('/counties')->assertStatus(403);
        $this->actingAs($users[2])->get('/counties/'.$county->id.'/edit')->assertStatus(403);
        $this->actingAs($users[2])->delete('/counties/'.$county->id)->assertStatus(403);
        $this->get('/counties')->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_permission()
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $permission  = Permission::first();
        //permission
        $this->actingAs($users[2])->get('/permissions')->assertStatus(403);
        $this->actingAs($users[2])->post('/permissions')->assertStatus(403);
        $this->actingAs($users[2])->get('/permissions/'. $permission->id .'/edit')->assertStatus(403);
        $this->actingAs($users[2])->delete('/permissions/'. $permission->id)->assertStatus(403);
        $this->get('/permissions')->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_cities() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $city  = City::first();
        //city
        $this->actingAs($users[2])->get('/cities')->assertStatus(403);
        $this->actingAs($users[2])->post('/cities')->assertStatus(403);
        $this->actingAs($users[2])->get('/cities/'.$city->id.'/edit')->assertStatus(403);
        $this->actingAs($users[2])->delete('/cities/'.$city->id)->assertStatus(403);
        $this->get('/cities')->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_assign_roles()
    {
        //$this->withoutExceptionHandling();
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $factories = $this->makeFactories();
        $user = $users[2];
        $restaurant = Restaurant::first();
        $userRestaurant = UserRestaurant::where('restaurant_id',$restaurant->id)
                                        ->where('user_id',$user->id)->first();

        // UserRestaurant
        $this->actingAs($user)->get('assign_roles/create')->assertStatus(403);
        $this->actingAs($user)->post('/assign_roles',[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
        ])->assertStatus(403);

        $this->actingAs($user)->get('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id .'/edit')->assertStatus(403);

        $this->actingAs($user)->put('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id,[
            'user_id' => $factories['user']->id,
            'role_id' => $factories['role']->id,
        ])->assertStatus(403);
        $this->actingAs($user)->delete('assign_roles' . $restaurant->path() . '/' . $userRestaurant->id)->assertStatus(302);
    }

    /** @test */
    public function employee_permissions_menu() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[2];
        $restaurant = Restaurant::first();
        $menu = Menu::where('restaurant_id',$restaurant->id)->first();
        $this->get($menu->path())->assertStatus(200);

        //Menu
        $this->actingAs($user)->get('/menus')->assertStatus(403);
        $this->actingAs($user)->get($restaurant->path() . '/menus/create')->assertStatus(403);
        $this->actingAs($user)->post( $restaurant->path().'/menus',[
            'name' => 'Nume'
        ])->assertStatus(403);
        $this->actingAs($user)->get($restaurant->path() . $menu->path() . '/edit')->assertStatus(403);
        $this->actingAs($user)->put($restaurant->path() . $menu->path(),[
            'name' => 'Nume'
        ])->assertStatus(403);
        $this->actingAs($user)->get($menu->path())->assertStatus(200);
        $this->actingAs($user)->delete($restaurant->path() . $menu->path())->assertStatus(403);
        $this->actingAs($user)->get($restaurant->path() . '/menus/create')->assertStatus(403);
        $this->actingAs($user)->post( $restaurant->path().'/menus',[
            'name' => 'Nume'
        ])->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_category() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[2];
        $menu = Menu::first();
        $category = Category::where('menu_id',$menu->id)->first();

        //Category
        $this->actingAs($user)->get($menu->path() . '/categories')->assertStatus(403);
        $this->actingAs($user)->get($menu->path() . '/categories/create')->assertStatus(403);
        $this->actingAs($user)->post( $menu->path() . '/categories/',[
            'name' => 'Nume'
        ])->assertStatus(403);
        $this->actingAs($user)->get($menu->path() . '/categories/' . $category->id)->assertStatus(403);
        $this->actingAs($user)->get($menu->path() . '/categories/' . $category->id. '/edit')->assertStatus(403);
        $this->actingAs($user)->put($menu->path() . '/categories/' . $category->id,[
            'name' => 'Nume'
        ])->assertStatus(403);
        $this->actingAs($user)->delete($menu->path() . '/categories/' . $category->id)->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_download_qr() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $userOwnerRestaurant = User::factory()->create();
        $user = $users[2];
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
        $this->actingAs($user)->get($menu->path() . '/download')->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_role() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[2];
        $permissions = $this->makePermissions();
        $role = Role::factory()->create();

        //Roles
        $this->actingAs($user)->get('/roles')->assertStatus(403);
        $this->actingAs($user)->get('/roles/create')->assertStatus(403);
        $this->actingAs($user)->post('/roles',[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
        ])->assertStatus(403);
        $this->actingAs($user)->get('/roles/' .  $role->id)->assertStatus(403);
        $this->actingAs($user)->get('/roles/' .  $role->id . '/edit')->assertStatus(403);
        $this->actingAs($user)->put('/roles/' .  $role->id,[
            'name' => 'name',
            'description' => 'Description',
            'permissions' => [$permissions[0]->id,$permissions[1]->id,$permissions[2]->id],
        ])->assertStatus(403);
        $this->actingAs($user)->delete('/roles/' .  $role->id)->assertStatus(403);
    }

    /** @test */
    public function employee_permissions_invitations() :void
    {
        //$this->withoutExceptionHandling();
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[2];
        $restaurant = Restaurant::first();
        $role = Role::factory()->create();
        $userInvited = User::factory()->create();

        $this->actingAs($user)->get('staff'. $restaurant->path())->assertStatus(200);
        $this->actingAs($user)->get('invitations')->assertStatus(200);
        $this->actingAs($user)->get($restaurant->path().'/invitations/create')->assertStatus(403);
        $this->actingAs($user)->post($restaurant->path().'/invitations',[
            'email' => $userInvited->email,
            'role_id' => $role->id,
            'restaurant_id' => $restaurant->id,
        ])->assertStatus(403);

        $restaurant = Restaurant::factory()->create();

        Invitation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'email' => $userInvited->email,
            'role_id' => $role->id
        ]);

        $invitation = Invitation::where('email',$userInvited->email)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->first();

        $this->actingAs($user)->post('invitations/' . $invitation->id . '/accept')->assertStatus(403);
        $this->actingAs($user)->delete('invitations/' . $invitation->id)->assertStatus(403);


        $invitation = Invitation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'email' => $user->email,
            'role_id' => $role->id
        ]);

        $this->actingAs($user)->post('invitations/' . $invitation->id . '/accept')->assertStatus(302);

        $this->assertCount(0,Invitation::where('email',$user->email)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());

        $this->assertCount(1,UserRestaurant::where('user_id',$user->id)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());

        $userRestaurant = UserRestaurant::where('user_id',$user->id)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->first();

        $userRestaurant->delete();

        $invitation = Invitation::factory()->create([
            'restaurant_id' => $restaurant->id,
            'email' => $user->email,
            'role_id' => $role->id
        ]);

        $this->actingAs($user)->delete('invitations/' . $invitation->id)->assertStatus(302);

        $this->assertCount(0,Invitation::where('email',$user->email)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());

        $this->assertCount(0,UserRestaurant::where('user_id',$user->id)
        ->where('role_id',$role->id)
        ->where('restaurant_id',$restaurant->id)->get());
    }

    /** @test */
    public function employee_permissions_product() :void
    {
        $users = $this->insertAllTheSeedersAndReturnUsers();
        $user = $users[2];
        $category = Category::first();

        $this->actingAs($user)->get('/categories/' . $category->id . '/products/create')->assertStatus(403);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');
        $this->actingAs($user)->json('POST','/categories/' . $category->id . '/products',[
            'name' => 'Nume',
            'price' => 600.00,
            'picture' => $file,
            'weight' => 200,
            'available' => true,
            'ingredients' => 'rosii,salam,mozzarela,peperoni',
        ])->assertStatus(403);

        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->actingAs($user)->json('PUT','/products/' . $product->id,[
            'name' => 'Nume Nou',
            'price' => 600.20,
            'picture' => $file,
            'weight' => 300,
            'available' => false,
            'ingredients' => 'rosii,salam,mozzarela,lapte',
            'category_id' => $category->id,
        ])->assertStatus(403);

        $this->actingAs($user)->delete('/products/' . $product->id)->assertStatus(403);

        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->actingAs($user)->post('/products/' . $product->id . '/change-availability')->assertStatus(302);
    }
}
