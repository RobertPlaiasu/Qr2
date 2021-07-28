<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\UserRestaurant;
use App\Http\Requests\MenuRequest;
use App\Services\NavService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Attach the middlewares for the controller's routes
     */
    public function __construct()
    {
        $this->middleware(['auth','verified'])->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Menu::class);

        $restaurants = Menu::all()->map(function ($menu){
            $restaurant = $menu->restaurant;
            $restaurant->uri = $restaurant->path();
            return $restaurant;
        });

        return Inertia::render('Menu/Index', [
            'restaurants' => $restaurants,
            'menus' => Menu::all()->map(function ($menu) {
                $menu->uri = $menu->path();
                return $menu;
            }),
            'currentUser' => (new NavService())->generateNavbarUser(),
            'title' => "Meniuri",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Model\Restaurant $restaurant
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $restaurant)
    {
        $this->authorize('create', [Menu::class, $restaurant]);

        return Inertia::render('Menu/Create', [
            'restaurant' => $restaurant->path(),
            'title' => "Creare meniu | " . $restaurant->name . " - DigitalMenu",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MenuRequest  $request
     * @param  \App\Model\Restaurant $restaurant
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request, Restaurant $restaurant)
    {
        $this->authorize('create', [Menu::class, $restaurant]);

        if($restaurant->menu != null) return Redirect::back();

        $menu = Menu::create([
            'name' => $request->name,
            'restaurant_id' => $restaurant->id
        ]);

        return Redirect::to($menu->path());
    }

    public function show(Request $request, Menu $menu)
    {
        $this->authorize('view', $menu);

        if ($request->input('menu') === null) {
            return Inertia::render('Menu/Show', [
                'menuPath' => $menu->path(),
                'restaurantName' => $menu->restaurant->name,
                'restaurantPath' => $menu->restaurant->path(),
                'title' => "Meniu " . $menu->name . " | " . $menu->restaurant->name . " - DigitalMenu"
            ]);
        }

        if ($request->input('menu') === "promo") {
            return Inertia::render('Menu/Products', [
                'restaurantName' => $menu->restaurant->name,
                'menuPath' => $menu->path(),
                'products' => $menu->promos,
                'canChangeAvailability' => true,
                'subtitle' => "Promoții",
                'title' => "Meniu " . $menu->name . " | " . $menu->restaurant->name . " | Promoții - DigitalMenu"
            ]);
        }

        if ($request->menu === "category" && $request->input('category') === null) {
            return Inertia::render('Menu/CategorySelect', [
                'menuPath' => $menu->path(),
                'categories' => $menu->categories,
                'restaurantName' => $menu->restaurant->name,
                'title' => "Meniu " . $menu->name . " | " . $menu->restaurant->name . " | Categorii - DigitalMenu"
            ]);
        }

        if ($request->input('menu') === "category" && $request->input('category') !== null) {
            try {
                $category = Category::where('id', $request->category)->firstOrFail();
            } catch (\Exception $exception) {
                return Redirect::to($menu->path() . "?menu=category");
            }
            if ($category->menu_id !== $menu->id) return Redirect::to($menu->path() . "?menu=category");

            return Inertia::render('Menu/Products', [
                'restaurantName' => $menu->restaurant->name,
                'menuPath' => $menu->path(),
                'products' => $category->products,
                'canChangeAvailability' => true,
                'subtitle' => $category->name,
                'title' => "Meniu " . $menu->name . " | " . $menu->restaurant->name . " | " . $category->name . " - DigitalMenu"
            ]);
        }
        
        return Redirect::to($menu->path());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('update', [$menu, $restaurant]);

        $menu->uri = $menu->path();

        return Inertia::render('Menu/Edit', [
            'restaurant' => $restaurant->path(),
            'menu' => $menu,
            'title' => "Editare meniu " . $menu->name . " | " . $menu->restaurant->name . " - DigitalMenu",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MenuRequest  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('update',[$menu,$restaurant]);

        $menu->name = $request->name;
        $menu->restaurant_id = $restaurant->id;
        $menu->save();

        return Redirect::to($menu->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @param  \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant, Menu $menu)
    {
        $this->authorize('delete',[$menu,$restaurant]);

        $menu->deleteProductsPhotos();
        $menu->delete();

        return Redirect::to($restaurant->path());
    }
}
