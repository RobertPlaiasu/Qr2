<?php

namespace Database\Factories;

use App\Models\UserRestaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;

class UserRestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserRestaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'restaurant_id' => Restaurant::factory(),
            'role_id' => Role::factory(),
        ];
    }
}
