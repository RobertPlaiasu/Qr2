<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => rand(5, 999),
            'picture' => null,
            'weight' => rand(60, 200),
            'available' => rand(0,1),
            'ingredients' => $this->faker->lastName,
            'category_id' => Category::factory(),
        ];
    }
}
