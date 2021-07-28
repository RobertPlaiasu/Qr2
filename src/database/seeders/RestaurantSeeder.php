<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurants')->insert([[
            'id' => 1,
            'name' => 'Andra',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vel metus nec sem maximus gravida. Donec porta turpis tellus, et cursus ipsum pharetra nec. In maximus justo massa, at finibus mi fermentum eu. Pellentesque quis blandit ante. Donec quis sollicitudin ante, et tristique nisl. Cras vel convallis leo. Vestibulum libero elit, varius vitae nisl vitae, molestie varius velit. Nunc cursus mollis ante non euismod. Phasellus dapibus aliquam sodales. Vivamus nulla sapien, rhoncus non diam ac, feugiat commodo nunc. Nam finibus leo eu libero hendrerit venenatis. Nullam pretium, orci non sodales tincidunt, nulla eros vehicula dui, nec feugiat elit risus quis diam. Mauris aliquam condimentum arcu, eget volutpat enim porttitor eget. Mauris sit amet enim tortor. Quisque a accumsan arcu, rhoncus tempor arcu. ',
            'location' => 'Str. Manic Nr. 1',   
            'city_id' => 1,
            'slug' => '1-andra', 
        ]]);
    }
}
