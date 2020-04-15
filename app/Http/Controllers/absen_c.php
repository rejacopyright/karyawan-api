<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\face;
use App\User;
use App\user_image as img;
use Carbon\Carbon;

class absen_c extends Controller
{
  function absen(Request $data){
    $userToday = face::whereDate('created_at', Carbon::today());
    $absen = $userToday->groupBy('user_id')->paginate(10)->map(function($i) use($userToday){
      $i['user'] = User::where('id', $i->user_id)->first();
      $i['first_capture'] = face::whereDate('created_at', Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'ASC')->pluck('created_at')->first();
      $i['last_capture'] = face::whereDate('created_at', Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'DESC')->pluck('created_at')->first();
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
