<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Str;

class QrController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    /**
     * Download the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function download(Menu $menu)
    {
        $this->authorize('downloadQr',$menu);


        return response()->download(
            storage_path($menu->pathQr. $menu->id . $menu->qrExtension),
            Str::slug( $menu->restaurant->name ) . $menu->qrExtension
        );
    }
}
