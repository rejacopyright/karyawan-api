<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\absensi;
use App\device;
use App\User;
use App\user_image as img;
use Carbon\Carbon;

class absen_c extends Controller
{
  function hadir(Request $data){
    $dt = $data->date;
    $date = device::whereDate('created_at', $dt ?? Carbon::today());
    if ($data->q) {
      $user_query = user::where('name', 'like', '%'.$data->q.'%')->distinct('user_id')->pluck('user_id')->all();
      $date->whereIn('user_id', $user_query);
    }
    if ($data->sortby == 'checkin' || $data->sortby == 'checkout') { $date->orderby('created_at', $data->type); }
    // HADIR
    $page = $date->groupBy('user_id')->paginate(10);
    $hadir = $page->map(function($i) use($dt){
      $usr = User::where('user_id', $i->user_id)->first();
      $i['user'] = $usr;
      $i['name'] = $usr->name;
      $i['first_capture'] = device::whereDate('created_at', $dt ?? Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'ASC')->pluck('created_at')->first();
      $i['last_capture'] = device::whereDate('created_at', $dt ?? Carbon::today())->where('user_id', $i->user_id)->orderBy('created_at', 'DESC')->pluck('created_at')->first();
      $i['img'] = img::where('user_id', $usr->user_id)->orderBy('created_at', 'DESC')->first()->name;
      $i['count'] = device::whereDate('created_at', $dt ?? Carbon::today())->where('user_id', $i->user_id)->count();
      return $i;
    });
    if ($data->sortby == 'checkout') { if ($data->type == 'asc') { $hadir = $hadir->sortby('last_capture')->values(); }else { $hadir = $hadir->sortbydesc('last_capture')->values(); } }
    if ($data->sortby == 'counter') { if ($data->type == 'asc') { $hadir = $hadir->sortby('count')->values(); }else { $hadir = $hadir->sortbydesc('count')->values(); } }
    if ($data->sortby == 'name') { if ($data->type == 'asc') { $hadir = $hadir->sortby('name')->values(); }else { $hadir = $hadir->sortbydesc('name')->values(); } }

    $count = device::whereDate('created_at', Carbon::today())->count();
    return compact('hadir', 'page', 'count');
  }
  function absen(Request $data){
    $dt = $data->date;
    $user_id = device::whereDate('created_at', $dt ?? Carbon::today())->distinct('user_id')->pluck('user_id')->all();
    $page = User::whereNotIn('user_id', $user_id);
    if ($data->q) { $page->where('name', 'like', '%'.$data->q.'%'); }
    $page = $page->paginate(10);
    $absen = $page->map(function($r){
      $usr = User::where('user_id', $r->user_id)->first();
      $r['user'] = $usr;
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    return compact('absen', 'page');
  }
  function ijin(Request $data){
    $dt = $data->date;
    $page = absensi::whereDate('created_at', $dt ?? Carbon::today())->where('status', 3)->paginate(10);
    $ijin = $page->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    return compact('ijin', 'page');
  }
  function cuti(Request $data){
    $dt = $data->date;
    $page = absensi::whereDate('created_at', $dt ?? Carbon::today())->where('status', 4)->paginate(10);
    $cuti = $page->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    return compact('cuti', 'page');
  }
  function absen_count(){
    $user_id = device::whereDate('created_at', Carbon::today())->distinct('user_id')->pluck('user_id')->all();
    $hadir = count($user_id);
    $absen = user::whereNotIn('user_id', $user_id)->count();
    $ijin = absensi::whereDate('created_at', Carbon::today())->where('status', 3)->count();
    $cuti = absensi::whereDate('created_at', Carbon::today())->where('status', 4)->count();
    return compact('hadir', 'absen', 'ijin', 'cuti');
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
