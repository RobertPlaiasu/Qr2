<?php

namespace App\Http\Controllers;

use App\Services\NavService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'currentUser' => (new NavService())->generateNavbarUser(),
            'title' => "Acasă - DigitalMenu"
        ]);
    }
}
