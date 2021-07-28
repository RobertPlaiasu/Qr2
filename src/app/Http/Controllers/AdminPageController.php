<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\NavService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if(Auth::user()->cannot('viewAny', City::class)) abort(403);

        return Inertia::render('Admin', [
            'user' => (new NavService())->generateNavbarUser(),
            'title' => "Admin - DigitalMenu"
        ]);
    }
}
