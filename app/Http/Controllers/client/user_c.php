<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;
use Str;
use Image;
use App\Admin;
use App\User;
use App\user_image as img;
use App\user_title as title;

class user_c extends Controller
{
  function me(){
    $user = auth::user();
    $user->img->map(function($i){
      return $i;
    });
    return compact('user');
  }
}
