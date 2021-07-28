<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Menu;
use App\Http\Requests\PromoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Services\NavService;

class PromoController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Menu $menu)
    {
        $this->authorize('viewAny',[Promo::class,$menu]);

        $menu->uri = $menu->path();

        return Inertia::render('Promo/Index',[
            'currentUser' => (new NavService())->generateNavbarUser(),
            'menu' => $menu,
            'promos' => $menu->promos,
            'title' => "Promotii | " . $menu->name . ' | ' . $menu->restaurant->name . " - DigitalMenu",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Menu $menu)
    {
        $this->authorize('create',[Promo::class,$menu]);

        return Inertia::render('Promo/Create', [
            'menu' => $menu->path(),
            'products' => $this->getAllProducts($menu),
            'title' => "Creare promotie | " . $menu->name . ' | ' . $menu->restaurant->name . " - DigitalMenu"
        ]);
    }

   
    public function store(PromoRequest $request,Menu $menu)
    {
        $this->authorize('create',[Promo::class,$menu]);

        $promo = Promo::create([
            'name' => $request->name,
            'price' => $request->price,
            'expire' => $request->expire,
            'menu_id' => $menu->id, 
        ]);

        $promo->products()->sync($request->products);

        $promo->storeImage($request,'promo_pictures','public');
        
        return Redirect::to($menu->path() . '/promos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu,Promo $promo)
    {
        $this->authorize('update',[$promo,$menu]);

        return Inertia::render('Promo/Edit', [
            'menu' => $menu->path(),
            'promo' => $promo,
            'products' => $this->getAllProducts($menu),
            'currentProducts' => $promo->products,
            'title' => "Editare promotie | " . $menu->name . ' | ' . $menu->restaurant->name . " - DigitalMenu"
        ]);
    }

    
    public function update(PromoRequest $request,Menu $menu,Promo $promo)
    {
        $this->authorize('update',[$promo,$menu]);

        $promo->name = $request->name;
        $promo->price = $request->price;
        $promo->expire = $request->expire;
        $promo->save();

        $promo->products()->sync($request->products);

        $promo->storeImage($request,'promo_pictures','public');

        return Redirect::to($menu->path() . '/promos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu,Promo $promo)
    {
        $this->authorize('delete',[$promo,$menu]);

        $promo->deletePhoto();

        $promo->delete();

        return Redirect::to($menu->path());
    }

    private function getAllProducts(Menu $menu)
    {
        $products = null;

        $menu->load('categories.products');

        foreach($menu->categories as $category)
        {
            if($products == null)
                $products = $category->products;
            else
                foreach($category->products as $product) 
                {
                    $products->push($product); 
                }
        }

        return $products;
    }
}
