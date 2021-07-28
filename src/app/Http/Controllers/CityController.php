<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;
use App\Services\NavService;
use App\Http\Requests\CityRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->authorizeResource(City::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counties = City::all()->map(function ($city){
            return $city->county->name;
        });

        return Inertia::render('City/Index', [
            'items' => City::all(),
            'counties' => $counties,
            'currentUser' => (new NavService())->generateNavbarUser(),
            'title' => "Orașe - DigitalMenu"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('City/Create', [
            'counties' => County::all(),
            'title' => "Creare oraș - DigitalMenu"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CityRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        City::create([
            'name' => $request->name,
            'county_id' => $request->county_id,
        ]);

        return Redirect::to('/cities');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return Inertia::render('City/Edit', [
            'counties' => County::all(),
            'city' => $city,
            'title' => "Editare " . $city->name . " - DigitalMenu"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CityRequest $request
     * @param  \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request,City $city)
    {
        $city->name = $request->name;
        $city->county_id = $request->county_id;
        $city->save();

        return Redirect::to('/cities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return Redirect::to('/cities');
    }
}
