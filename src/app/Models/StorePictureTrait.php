<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;

trait StorePictureTrait
{

    public function deletePhoto() :void
    {
        if($this->picture)
            Storage::disk('public')->delete($this->picture);
    }

    public function storeImage($request,string $folder,string $storageDisk) :void
    {
        $this->deletePhoto();
        if ($request->has('picture'))
        {
            $this->picture = $request->file('picture')->store($folder,$storageDisk);
            $this->save();
        }
    }

}