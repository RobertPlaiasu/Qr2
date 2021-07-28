<?php

namespace App\Observers;

use App\Models\Menu;
use Illuminate\Support\Str;

class MenuObserver
{
    /**
     * Handle the menu "created" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function created(Menu $menu)
    {
        $menu->slug  = $menu->combineNameWithId();
        $menu->save();
        $menu->createQr();
    }

    /**
     * Handle the menu "updated" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function updated(Menu $menu)
    {
        $menu->deleteQr();
        $menu->createQr();
    }

    /**
     * Handle the menu "deleted" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function deleted(Menu $menu)
    {
        $menu->deleteQr();
    }

    /**
     * Handle the menu "restored" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function restored(Menu $menu)
    {
        //
    }

    /**
     * Handle the menu "force deleted" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function forceDeleted(Menu $menu)
    {
        //
    }
}
