<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\PermissionRequest;
use App\Services\NavService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    /**
     * Attach the middlewares for the controller's routes
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->authorizeResource(Permission::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Permission/Index', [
            'permissions' => Permission::all(),
            'currentUser' => (new NavService())->generateNavbarUser(),
            'title' => "Permisiuni - DigitalMenu"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Permission/Create', [
            'title' => "Creare permisiune - DigitalMenu"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return Redirect::to('/permissions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return Inertia::render('Permission/Edit', [
            'permission' => $permission,
            'title' => "Editare " . $permission->name . " - DigitalMenu"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->save();

        return Redirect::to('/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return Redirect::to('/permissions');
    }
}
