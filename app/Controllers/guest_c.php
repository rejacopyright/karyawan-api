<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Storage;
use Str;
use Image;

class guest_c extends Controller
{
  function image_data(){
    // if (!is_dir('public/img/temp/absen')) { mkdir('public/img/temp/absen', 0777, true); }
    // if ($data->image) {
    //   Image::make($data->image)->resize(150, null, function($c){$c->aspectRatio();})->save('public/img/temp/absen/image.jpg', 50);
    // }
    $path = base64_encode(file_get_contents(url('public/img/capture1.jpg')));
    return $path;
  }
}
