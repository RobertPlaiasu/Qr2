<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Permission;
use App\Services\NavService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->authorizeResource(Role::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Role/Index', [
            'roles' => Role::all(),
            'user' => (new NavService)->generateNavbarUser(),
            'title' => 'Roluri - DigitalMenu'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Role/Create', [
            'permissions' => Permission::all(),
            'user' => (new NavService)->generateNavbarUser(),
            'title' => 'Creare rol - DigitalMenu'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'for_admin' => $request->for_admin,
        ]);

        $role->permissions()->sync($request->permissions,false);

        return Redirect::to('/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return Inertia::render('Role/Show', [
            'role' => $role,
            'permissions' => $role->permissions,
            'user' => (new NavService)->generateNavbarUser(),
            'title' => "Rol " . $role->name . " - DigitalMenu"
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        return Inertia::render('Role/Edit', [
            'role' => $role,
            'currentPermissions' => $role->permissions,
            'permissions' => Permission::all(),
            'user' => (new NavService)->generateNavbarUser(),
            'title' => "Editare rol " . $role->name . " - DigitalMenu"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->description = $request->description;
        $role->for_admin = $request->for_admin;
        $role->save();
        $role->permissions()->sync($request->permissions,true);

        return Redirect::to('/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return Redirect::to('/roles');
    }
}
