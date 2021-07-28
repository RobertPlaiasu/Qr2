<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Category;
use App\Services\NavService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function create(Category $category)
    {
        $this->authorize('create',[Product::class,$category]);

        return Inertia::render("Product/Create", [
            'category' => $category->id,
            'title' => "Creare produs"
        ]);
    }

    public function store(ProductStoreRequest $request, Category $category)
    {
        $this->authorize('create',[Product::class,$category]);

        if($this->verifyIfProductAlreadyExists($request,$category,'categories/' . $category->id . '/products/create'))
            return $this->verifyIfProductAlreadyExists($request,$category,'categories/' . $category->id . '/products/create');


        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'weight' => $request->weight,
            'available' => true,
            'category_id' => $category->id,
        ]);
        $product->storeImage($request,'product_pictures','public');
        $this->storeIngredients($product,$request);

        return redirect()->route('menus.categories.show', [$category->menu, $category]);
    }

    /*
    public function edit(Category $category, Product $product)
    {
        $this->authorize('update',$product);

        return view('product.edit', [
            'categories' => Category::all(),
            'product' => $product
        ]);
    }
    */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('update',$product);

        //dd($request->product->category->menu->id);
        if($product->category->menu->id != Category::where('id',$request->category_id)->first()->menu->id)
            Redirect::to('products/' . $product->id . '/edit')->withErrors('Aceasta categorie nu este disponibila.');

        $product->name = $request->name;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->available = true;
        $product->category_id = $request->category_id;
        $product->save();
        $product->storeImage($request,'product_pictures','public');
        $this->storeIngredients($product,$request);

        $product = Product::where('id',$product->id)->first();

        return Redirect::to(route('menus.categories.show', [$product->category->menu, $product->category]));
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete',$product);

        $product->delete();

        return Redirect::to(route('menus.categories.show', [$product->category->menu, $product->category]));
    }

    public function availability(Product $product)
    {
        $this->authorize('changeAvailabilty',$product);

        if ($product->available) $product->available = false;
        else $product->available = true;
        $product->save();

        return Redirect::to($product->category->menu->path() . "?menu=category&category=" . $product->category_id);
    }

    private function storeIngredients($product, $request) :void
    {
        if ($request->has('ingredients'))
        {
            $product->ingredients = $request->ingredients;
            $product->save();
        }
    }


    private function verifyIfProductAlreadyExists(ProductStoreRequest $request,Category $category,string $pathRedirect)
    {
        foreach($category->products as $product)
            if($product->name === $request->name)
                return Redirect::to($pathRedirect)->withErrors(['Exista deja un produs cu acest nume !']);
    }
}
