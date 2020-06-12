<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\absensi;
use App\device;
use App\User;
use App\jabatan;
use App\user_image as img;
use Carbon\Carbon;

class absen_c extends Controller
{
  function hadir(Request $data){
    $from = $data->from .' 00:00:00';
    $to = $data->to .' 23:59:59';
    $now = Carbon::today();
    $dt = array($from ?? $now, $to ?? $now);
    $date = device::whereBetween('created_at', $dt);
    if ($data->q) {
      $user_query = user::where('name', 'like', '%'.$data->q.'%')->distinct('user_id')->pluck('user_id')->all();
      $date->whereIn('user_id', $user_query);
    }
    if ($data->sortby == 'checkin' || $data->sortby == 'checkout') { $date->orderby('created_at', $data->type); }
    // HADIR

    // ================ TEST ================
    // $date = $date->get()->groupBy(function($i){return Carbon::parse($i->created_at)->format('Y-m-d');});
    // $collect = new Collection;
    // foreach ($date as $key => $val) {
    //   $collect = $collect->merge($val->unique('user_id')->values());
    // }

    // $date->groupBy(function($i){
    //   dd($i->get());
    // }) ->paginate(10);
    $page = $date->groupBy('user_id')->paginate(6);
    $hadir = $page->map(function($i) use($dt){
      $usr = User::where('user_id', $i->user_id)->first();
      $i['user'] = $usr;
      $i['name'] = $usr->name;
      $i['first_capture'] = device::whereBetween('created_at', $dt)->where('user_id', $i->user_id)->orderBy('created_at', 'ASC')->pluck('created_at')->first();
      $i['last_capture'] = device::whereBetween('created_at', $dt)->where('user_id', $i->user_id)->orderBy('created_at', 'DESC')->pluck('created_at')->first();
      $i['img'] = img::where('user_id', $usr->user_id)->orderBy('created_at', 'DESC')->first()->name;
      $i['count'] = device::whereBetween('created_at', $dt)->where('user_id', $i->user_id)->count();
      return $i;
    });
    if ($data->sortby == 'checkout') { if ($data->type == 'asc') { $hadir = $hadir->sortby('last_capture')->values(); }else { $hadir = $hadir->sortbydesc('last_capture')->values(); } }
    if ($data->sortby == 'counter') { if ($data->type == 'asc') { $hadir = $hadir->sortby('count')->values(); }else { $hadir = $hadir->sortbydesc('count')->values(); } }
    if ($data->sortby == 'name') { if ($data->type == 'asc') { $hadir = $hadir->sortby('name')->values(); }else { $hadir = $hadir->sortbydesc('name')->values(); } }

    $count = device::whereBetween('created_at', $dt)->count();
    return compact('hadir', 'page', 'count');
  }
  function hadir_user(Request $data){
    $from = $data->from .' 00:00:00';
    $to = $data->to .' 23:59:59';
    $now = Carbon::today();
    $dt = array($from ?? $now, $to ?? $now);
    $date = device::whereBetween('created_at', $dt)->where('user_id', $data->user_id);
    if ($data->q) {
      // $user_query = user::where('name', 'like', '%'.$data->q.'%')->distinct('user_id')->pluck('user_id')->all();
      // $date->whereIn('user_id', $user_query);
    }
    if ($data->sortby == 'checkin' || $data->sortby == 'checkout') { $date->orderby('created_at', $data->type); }
    // USER
    $user = User::where('user_id', $data->user_id)->first();
    $user->avatar = img::where('user_id', $data->user_id)->orderBy('created_at', 'DESC')->first()->name;
    $user->count = device::whereBetween('created_at', $dt)->where('user_id', $data->user_id)->count();
    // HADIR
    $page = $date->paginate(6);
    $hadir = $page->map(function($i){
      return $i;
    });
    if ($data->sortby == 'checkout') { if ($data->type == 'asc') { $hadir = $hadir->sortby('last_capture')->values(); }else { $hadir = $hadir->sortbydesc('last_capture')->values(); } }

    return compact('user', 'hadir', 'page');
  }
  function hadir_export(Request $data){
    $from = $data->from .' 00:00:00';
    $to = $data->to .' 23:59:59';
    $now = Carbon::today();
    $dt = array($from ?? $now, $to ?? $now);
    $date = device::whereBetween('created_at', $dt)->orderBy('created_at');
    // HADIR

    // ================ TEST ================
    $date = $date->get()->groupBy(function($i){return Carbon::parse($i->created_at)->format('Y-m-d');});
    $collect = new Collection;
    $date = $date->map(function($d) use($collect){
      return $d->sortBy('created_at')->unique('user_id')->values();
    });
    // dd($date->collapse());
    $hadir = $date->collapse()->map(function($i) use($dt){
      $usr = User::where('user_id', $i->user_id)->first();
      $i['user'] = $usr;
      $i['user_id'] = $usr->user_id;
      $i['name'] = $usr->name;
      $i['jabatan'] = $usr->jabatan->name ?? '';
      $i['first_capture'] = device::whereBetween('created_at', $dt)->where('user_id', $i->user_id)->orderBy('created_at', 'ASC')->pluck('created_at')->first();
      $i['last_capture'] = device::whereBetween('created_at', $dt)->where('user_id', $i->user_id)->orderBy('created_at', 'DESC')->pluck('created_at')->first();
      $i['img'] = img::where('user_id', $usr->user_id)->orderBy('created_at', 'DESC')->first()->name;
      $i['count'] = device::whereBetween('created_at', $dt)->where('user_id', $i->user_id)->count();
      return $i;
    });
    // dd($hadir);
    return compact('hadir');
  }
  function absen(Request $data){
    $dt = $data->from;
    $dt = $data->to;
    $now = Carbon::today();
    $user_id = device::whereDate('created_at', $dt ?? $now)->distinct('user_id')->pluck('user_id')->all();
    $page = User::whereNotIn('user_id', $user_id);
    if ($data->q) { $page->where('name', 'like', '%'.$data->q.'%'); }
    if ($data->sortby == 'name') { if ($data->type == 'asc') { $page = $page->orderby('name', 'asc'); }else { $page = $page->orderBy('name', 'desc'); } }
    $page = $page->paginate(6);
    $absen = $page->map(function($r){
      $usr = User::where('user_id', $r->user_id)->first();
      $r['user'] = $usr;
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    return compact('absen', 'page');
  }
  function ijin(Request $data){
    $dt = $data->from;
    $dt = $data->to;
    $now = Carbon::today();
    $page = absensi::whereDate('created_at', $dt ?? $now)->where('status', 3)->paginate(10);
    $ijin = $page->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    return compact('ijin', 'page');
  }
  function cuti(Request $data){
    $dt = $data->from;
    $dt = $data->to;
    $now = Carbon::today();
    $page = absensi::whereDate('created_at', $dt ?? $now)->where('status', 4)->paginate(10);
    $cuti = $page->map(function($r){
      $r['img'] = img::where('user_id', $r->user_id)->orderBy('created_at', 'DESC')->first()->name;
      return $r;
    });
    return compact('cuti', 'page');
  }
  function absen_count(){
    $now = Carbon::today();
    $user_id = device::whereDate('created_at', $now)->distinct('user_id')->pluck('user_id')->all();
    $hadir = count($user_id);
    $absen = user::whereNotIn('user_id', $user_id)->count();
    $ijin = absensi::whereDate('created_at', $now)->where('status', 3)->count();
    $cuti = absensi::whereDate('created_at', $now)->where('status', 4)->count();
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
