<?php

use App\Http\Controllers\AdminPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountyController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRestaurantController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\StuffPageController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia\Inertia::render("Welcome");
});

Route::get('pricing')->name('pricing');
Route::get('contact', ContactPageController::class)->name('contact');
Route::get('manual', ManualController::class)->name('manual');
Route::middleware(['auth:sanctum', 'verified'])->get('admin', AdminPageController::class)->name('admin');

Route::resource('restaurants', RestaurantController::class);
Route::resource('counties', CountyController::class);
Route::resource('cities', CityController::class);
Route::resource('restaurants.menus', MenuController::class)->except(['index','show']);
Route::resource('menus.categories', CategoryController::class);
Route::resource('categories.products', ProductController::class)->shallow();
Route::resource('permissions', PermissionController::class);
Route::resource('roles', RoleController::class);
Route::resource('menus.promos',PromoController::class)->except(['show']);

// Stuff restaurant route
Route::middleware(['auth:sanctum', 'verified'])->get('staff/restaurants/{restaurant}', StuffPageController::class)->name('restaurant.staff');

/* Routes for UserRestaurantCotroller */
Route::get('assign_roles/create',[UserRestaurantController::class,'create'])->name('userRestaurant.create');
Route::post('assign_roles',[UserRestaurantController::class,'store'])->name('userRestaurant.store');
Route::get('assign_roles/restaurants/{restaurant}/{userRestaurant}/edit',[UserRestaurantController::class,'edit'])->name('userRestaurant.edit');
Route::put('assign_roles/restaurants/{restaurant}/{userRestaurant}',[UserRestaurantController::class,'update'])->name('userRestaurant.update');
Route::delete('assign_roles/restaurants/{restaurant}/{userRestaurant}',[UserRestaurantController::class,'destroy'])->name('userRestaurant.destroy');
/* End */

/* Routes for InvitationController */
Route::get('invitations',[InvitationController::class,'index'])->name('invitation.index');
Route::get('restaurants/{restaurant}/invitations/create',[InvitationController::class,'create'])->name('invitation.create');
Route::post('restaurants/{restaurant}/invitations',[InvitationController::class,'store'])->name('invitation.store');
Route::post('invitations/{invitation}/accept',[InvitationController::class,'accept'])->name('invitation.accept');
Route::delete('invitations/{invitation}',[InvitationController::class,'destroy'])->name('invitation.destroy');
/* End */

/* Menu routes for index,show and download */
Route::get('/menus',[MenuController::class,'index'])->name('restaurants.menu.index');;
Route::get('/menus/{menu}',[MenuController::class,'show'])->name('restaurants.menu.show');;
Route::get('menus/{menu}/download', [QrController::class, 'download'])->name('qr.download');
/* Menu routes for index,show and download */

//change availabilty
Route::post('/products/{product}/change-availability',[ProductController::class,'availability']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login/google',[OAuthController::class,'redirectToProviderGoogle'])->middleware(['guest']);
Route::get('/login/google/callback',[OAuthController::class,'handleProviderCallbackGoogle'])->middleware(['guest']); 

Route::get('/abonamente',[PaymentController::class,'subscribe'])->middleware(['auth','verified','subscriber'])->name('subscribe');
Route::post('/plati/abonament',[PaymentController::class,'createSubscription'])->middleware(['auth','verified','subscriber'])->name('subscribe.post');
Route::get('/preturi',[PaymentController::class,'prices'])->name('prices');
