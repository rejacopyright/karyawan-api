<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\face;
use App\User;
use App\user_image as img;
use Carbon\Carbon;

class guest_c extends Controller
{
  function image_data(){
      $image = base64_encode(file_get_contents(url('public/img/capture1.jpg')));
    return $image;
  }
  function absen(Request $data){
    $absen = face::whereDate('created_at', Carbon::today())->orderBy('created_at', 'DESC')->paginate(10)->map(function($i){
      $usr = User::where('id', $i->user_id)->first();
      $i['user'] = $usr;
      $i['img'] = img::where('user_id', $usr->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $i;
    });

    // $absen = ($absen->toArray());
    $absen_id = face::whereDate('created_at', Carbon::today())->distinct('user_id')->pluck('user_id')->all();
    $belum = User::whereNotIn('id', $absen_id)->paginate(10)->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    $count = face::whereDate('created_at', date('Y-m-d'))->count();
    return compact('absen', 'belum', 'count');
  }
}
