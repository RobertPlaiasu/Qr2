<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([[
            'id' => 1,
            'name' => 'all',
            'description' => 'Este doar pentru superadmin!',
        ],[
            'id' => 2,
            'name' => 'categorie',
            'description' => 'Poate modifica categoria unui produs/sa creeze un noua',
        ],[
            'id' => 3,
            'name' => 'restaurant',
            'description' => 'Poate modifica restaurantul/sa creeze unul nou',
        ],[
            'id' => 4,
            'name' => 'produs',
            'description' => 'Poate modifica un produs/sa creeze unul nou',
        ],[
            'id' => 5,
            'name' => 'meniu',
            'description' => 'Poate modifica meniul unui restaurant/sa creeze unul daca nu este deja creat',
        ],[
            'id' => 6,
            'name' => 'produs_status',
            'description' => 'Poate schimba faptul ca un produs este de vanzare sau nu',
        ],[
            'id' => 7,
            'name' => 'atribuire_rol',
            'description' => 'Poate atribuii roluri userului',
        ],[
            'id' => 8,
            'name' => 'invitatie',
            'description' =>'Patronul de restaurant poate trimite invitatie user-ului pentru a deveni angajat'
        ],[
            'id' => 9,
            'name' => 'promotie',
            'description' => 'Patronul de restaurant poate modifica promotiile'
        ]]);
    }
}
