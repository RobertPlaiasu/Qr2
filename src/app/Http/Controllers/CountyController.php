<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Http\Requests\StoreCountyRequest;
use App\Http\Requests\UpdateCountyRequest;
use App\Services\NavService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CountyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->authorizeResource(County::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('County/Index', [
            'currentUser' => (new NavService())->generateNavbarUser(),
            'counties' => County::all(),
            'title' => "Județe - DigitalMenu"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('County/Create', [
            'title' => "Adăugare județ - DigitalMenu"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCountyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountyRequest $request)
    {
        County::create([
            'name' => $request->name,
        ]);

        return Redirect::to('/counties');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\County $county
     * @return \Illuminate\Http\Response
     */
    public function edit(County $county)
    {
        return Inertia::render('County/Edit', [
            'county' => $county,
            'title' => "Editare " . $county->name . " - DigitalMenu"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCountyRequest $request
     * @param  \App\Models\County $county
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountyRequest $request, County $county)
    {
        $county->name = $request->name;
        $county->save();

        return Redirect::to('/counties');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\County $counties
     * @return \Illuminate\Http\Response
     */
    public function destroy(County $county)
    {
        $county->delete();

        return Redirect::to('/counties');
    }
}
