<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Models\Menu;
use App\Services\NavService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function __construct()
    {
      $this->middleware(['auth','verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Menu $menu
     * @return \Inertia\Inertia
     */
    public function index(Menu $menu)
    {
        $this->authorize('viewAny',[Category::class,$menu]);
        $menu->uri = $menu->path();

        return Inertia::render('Category/Index', [
            'currentUser' => (new NavService())->generateNavbarUser(),
            'menu' => $menu,
            'categories' => $menu->categories,
            'title' => "Categorii | " . $menu->name . ' | ' . $menu->restaurant->name . " - DigitalMenu"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Menu $menu)
    {
        $this->authorize('create',[Category::class,$menu]);
        return Inertia::render('Category/Create', [
            'menu' => $menu->path(),
            'title' => "Creare categorie | " . $menu->name . ' | ' . $menu->restaurant->name . " - DigitalMenu"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request, Menu $menu)
    {
        $this->authorize('create',[Category::class,$menu]);

        $pathErrorRedirect = $menu->path() . '/categories/create';

        if($this->categoryNameIsUniqueInThatMenu($menu,$request,$pathErrorRedirect))
            return $this->categoryNameIsUniqueInThatMenu($menu,$request,$pathErrorRedirect);


        $category = Category::create([
            'name' => $request->name,
            'menu_id' => $menu->id,
        ]);

        return Redirect::to($menu->path().'/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu, Category $category)
    {
        $this->authorize('view', [$category, $menu]);
        $menu->uri = $menu->path();

        return Inertia::render('Category/Show', [
            'currentUser' => (new NavService())->generateNavbarUser(),
            'menu' => $menu,
            'category' => $category,
            'products' => $category->products,
            'title' => "Categorie " . $category->name . " | " . $menu->name . ' | ' . $menu->restaurant->name . " - DigitalMenu"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu, Category $category)
    {
        $this->authorize('update',[$category,$menu]);

        return Inertia::render('Category/Edit', [
            'category' => $category,
            'menu' => $menu->path(),
            'title' => "Editare categorie " . $category->name . " | " . $menu->name . ' | ' . $menu->restaurant->name . " - DigitalMenu"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Menu $menu, Category $category)
    {
        $this->authorize('update',[$category,$menu]);

        $category->name = $request->name;
        $category->save();

        return Redirect::to($menu->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu, Category $category)
    {
        $this->authorize('delete',[$category,$menu]);

        $category->deleteProductsPhotos();

        $category->delete();

        return Redirect::to($menu->path().'/categories');
    }

    private function categoryNameIsUniqueInThatMenu(Menu $menu,CategoryRequest $request,string $redirectPath)
    {
        foreach($menu->categories as $category)
            if($category->name === $request->name)
                return Redirect::to($redirectPath)->withErrors('Exista deja o categorie cu acelasi nume in acest meniu!');
    }
}
