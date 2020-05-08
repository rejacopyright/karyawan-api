<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\device;
use App\User;
use App\user_image as img;
use Carbon\Carbon;

class absen_c extends Controller
{
  function absen(Request $data){
    $today = device::whereDate('created_at', Carbon::today());
    if ($data->q) {
      $user_query = user::where('name', 'like', '%'.$data->q.'%')->distinct('user_id')->pluck('user_id')->all();
      $today->whereIn('user_id', $user_query);
    }
    $device_page = $today->groupBy('user_id')->paginate(10);
    $hadir = $device_page->map(function($i) use($today){
      $usr = User::where('user_id', $i->user_id)->first();
      $i['user'] = $usr;
      $i['first_capture'] = device::whereDate('created_at', Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'ASC')->pluck('created_at')->first();
      $i['last_capture'] = device::whereDate('created_at', Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'DESC')->pluck('created_at')->first();
      $i['img'] = img::where('user_id', $usr->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $i;
    });
    // $hadir = ($hadir->toArray());
    $user_id = device::whereDate('created_at', Carbon::today())->distinct('user_id')->pluck('user_id')->all();
    $absen_page = User::whereNotIn('user_id', $user_id);
    if ($data->q) { $absen_page->where('name', 'like', '%'.$data->q.'%'); }
    $absen_page = $absen_page->paginate(10);
    $absen = $absen_page->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    $count = device::whereDate('created_at', date('Y-m-d'))->count();
    return compact('hadir', 'device_page', 'absen', 'absen_page', 'count');
  }
  function test(Request $data){
    $page = device::paginate(5);
    $device = $page->map(function($i){
      $i->user = user::where('user_id', $i->user_id)->first();
      return $i;
    });
    return compact('page', 'device');
  }
}
