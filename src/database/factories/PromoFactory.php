<?php

namespace Database\Factories;

use App\Models\Promo;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PromoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title,
            'price' => rand(5, 999),
            'picture' => null,
            'menu_id' => Menu::factory(),
            'expire' => Carbon::now()->addDays(5),
        ];
    }
}
