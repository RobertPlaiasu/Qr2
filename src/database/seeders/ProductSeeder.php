<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(15)->state(
            new Sequence(
                ['category_id' => 1],
                ['category_id' => 2],
                ['category_id' => 3],
            )
        )->create();
    }
}
