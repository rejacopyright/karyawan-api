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
    if ($data->q) {
      $user_query = user::where('name', 'like', '%'.$data->q.'%')->distinct('id')->pluck('id')->all();
      $userToday->whereIn('user_id', $user_query);
    }
    $absen_page = $userToday->groupBy('user_id')->paginate(10);
    $absen = $absen_page->map(function($i) use($userToday){
      $usr = User::where('id', $i->user_id)->first();
      $i['user'] = $usr;
      $i['first_capture'] = face::whereDate('created_at', Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'ASC')->pluck('created_at')->first();
      $i['last_capture'] = face::whereDate('created_at', Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'DESC')->pluck('created_at')->first();
      $i['img'] = img::where('user_id', $usr->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $i;
    });
    // $absen = ($absen->toArray());
    $absen_id = face::whereDate('created_at', Carbon::today())->distinct('user_id')->pluck('user_id')->all();
    $belum_page = User::whereNotIn('id', $absen_id);
    if ($data->q) { $belum_page->where('name', 'like', '%'.$data->q.'%'); }
    $belum_page = $belum_page->paginate(10);
    $belum = $belum_page->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    $count = face::whereDate('created_at', date('Y-m-d'))->count();
    return compact('absen', 'absen_page', 'belum', 'belum_page', 'count');
  }
  function test(Request $data){
    $page = face::paginate(5);
    $absen = $page->map(function($i){
      $i->user = user::where('id', $i->user_id)->first();
      return $i;
    });
    return compact('page', 'absen');
  }
}
