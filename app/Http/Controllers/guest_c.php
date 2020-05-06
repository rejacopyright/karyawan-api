<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\face;
use App\device;
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
    $absen = device::whereDate('created_at', Carbon::today())->orderBy('created_at', 'DESC')->paginate(10)->map(function($i){
      $usr = User::where('user_id', $i->user_id)->first();
      $i['user'] = $usr;
      $i['img'] = img::where('user_id', $usr->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $i;
    });

    // $absen = ($absen->toArray());
    $absen_id = device::whereDate('created_at', Carbon::today())->distinct('user_id')->pluck('user_id')->all();
    $belum = User::whereNotIn('user_id', $absen_id)->paginate(10)->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    $count = device::whereDate('created_at', date('Y-m-d'))->count();
    return compact('absen', 'belum', 'count');
  }
  function face(Request $data){
    $page = face::orderBy('created_at', 'DESC');
    if ($data->q) {
      $user_id = user::where('name', 'like', '%'.$data->q.'%')->distinct('user_id')->pluck('user_id')->all();
      $page = $page->whereIn('user_id', $user_id);
    }
    $face = $page->paginate(10)->map(function($r){
      $user = User::where('user_id', $r->user_id)->first();
      return $user;
    });
    return $face;
  }
  function devices(Request $data){
    $page = device::orderBy('created_at', 'DESC');
    if ($data->q) {
      $user_id = user::where('name', 'like', '%'.$data->q.'%')->distinct('user_id')->pluck('user_id')->all();
      $page = $page->whereIn('user_id', $user_id);
    }
    if ($data->device_id) {
      $page = $page->whereIn('device_id', $data->device_id);
    }else {
      $page = $page->where('device_id', device::orderBy('device_id')->first()->device_id);
    }
    $device = $page->paginate(10)->map(function($r){
      $user = User::where('user_id', $r->user_id)->first();
      return $user;
    });
    // dd($device);
    return $device;
  }
  function devices_list(Request $data){
    $all = device::distinct('device_id')->pluck('device_id')->all();
    $default = device::orderBy('device_id')->first()->device_id;
    return compact('all', 'default');
  }
}
