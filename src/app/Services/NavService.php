<?php

namespace App\Services;

// use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class NavService
{
    public function generateNavbarUser()
    {
        if (!Auth::check()) return [
            'username' => "Guest",
            'restaurants' => [],
            'isAdmin' => false,
            'profile_photo_url' => "https://ui-avatars.com/api/?name=Guest&color=7F9CF5&background=EBF4FF",
        ];

        $user = auth()->user()->load('userRestaurant.restaurant');
        $restaurants = [];
        $isAdmin = $user->can('create', App\Models\Permission::class);

        foreach($user->userRestaurant as $userRestaurant)
        {
            if($userRestaurant->role_id == 1) {
                continue;
            }

            array_push($restaurants, [
                "uri" => optional($userRestaurant->restaurant)->path(),
                "model" => $userRestaurant->restaurant,
                "role" => $userRestaurant->role
            ]);
        }

        return [
            'username' => $user->name,
            'restaurants' => $restaurants,
            'isAdmin' => $isAdmin,
            'profile_photo_url' => $user->profile_photo_url
        ];
    }
}

