<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function saveImage($base64Image, $path = 'default', $id)
    {
		$imageData = base64_decode($base64Image);
		
        $filename = time().'.jpg';
        // save image
		
        // $image->storeAs('public/sumbangan', $image);
		
		/* $gambar = $image;
		$filename = time().'-'.$id.'.'.$gambar->getClientOriginalExtension();
        $gambar->storeAs('public/'. $path, $filename); */
		
		\Storage::put('public/' . $path . '/' . $filename, $imageData);

        //return the path
        return $filename;

    }
}
