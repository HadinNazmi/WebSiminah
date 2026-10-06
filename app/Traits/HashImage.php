<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;


trait HashImage
{
    public function uploadImage($request, $newNameOfImage, $path)
    {
        if($request->has('photo')){
            $request->gambar->move($path, $newNameOfImage);
        }else {
            $request->file->move($path, $newNameOfImage);
        }
    }

    public function deleteImage($path, $oldImageName) {
        if(File::exists($path . '/' . $oldImageName)){
            File::delete($path . '/' .$oldImageName);
        }
    }

    public function updateImage($request, $path, $oldImageName, $newNameOfImage) {
        $this->uploadImage($request, $newNameOfImage, $path);
        $this->deleteImage($path, $oldImageName);
    }
}