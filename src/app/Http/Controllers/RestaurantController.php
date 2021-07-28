<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Restaurant;
use App\Models\City;
use App\Models\Role;
use App\Services\NavService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RestaurantRequest;
use Illuminate\Support\Facades\Redirect;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified'])->except('show');
        $this->authorizeResource(Restaurant::class);
    }

    public function index()
    {
        return Inertia::render('Restaurant/index', [
            'currentUser' => (new NavService())->generateNavbarUser(),
            'restaurants' => Restaurant::all(),
            'uris' => Restaurant::generateURIs(),
            'title' => "Restaurante",
        ]);
    }

    public function create()
    {
        return Inertia::render('Restaurant/Create', [
            'cities' => City::all(),
            'title' => "Creare restaurant",
        ]);
    }

    public function store(RestaurantRequest $request)
    {
        $restaurant = Restaurant::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'city_id' => $request->city_id,
        ]);

        $restaurant->storeImage($request,'restaurant_pictures','public');

        return Redirect::to($restaurant->path());
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->uri = $restaurant->path();
        $menu = $restaurant->menu;
        $user = Auth::user();

        $employeeRelation = null;
        if ( $user ) $employeeRelation = $user->userRestaurant
            ->where('restaurant_id', $restaurant->id)
            ->where('role_id', Role::where('name', 'angajat_restaurant')->first()->id)
            ->first();

        return Inertia::render('Restaurant/show', [
            'user' => (new NavService)->generateNavbarUser(),
            'restaurant' => $restaurant,
            'menu' => ( $menu ) ? $menu->path() : NULL,
            'currentUser' => (new NavService())->generateNavbarUser(),
            'download' => ( $menu ) ? $menu->path() . '/download' : NULL,
            'city' => $restaurant->city->name,
            'edit' => $restaurant->path() . '/edit',
            'isAdmin' => optional(Auth::user())->can('update', $restaurant),
            'employeeRelation' => $employeeRelation,
            'title' => "Restaurant " . $restaurant->name,
        ]);
    }

    public function edit(Restaurant $restaurant)
    {
        $restaurant->uri = $restaurant->path();

        return Inertia::render('Restaurant/Edit', [
            'restaurant' => $restaurant,
            'city' => $restaurant->city->id,
            'cities' => City::all(),
            'title' => "Editare restaurant | " . $restaurant->name,
        ]);
    }

    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        $restaurant->name = $request->name;
        $restaurant->description = $request->description;
        $restaurant->location = $request->location;
        $restaurant->city_id = $request->city_id;
        $restaurant->save();

        $restaurant->storeImage($request,'restaurant_pictures','public');

        return Redirect::to($restaurant->path());
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->deleteQrAndProductsPhotos();
        $restaurant->delete();

        return Redirect::to('/dashboard');
    }
}
