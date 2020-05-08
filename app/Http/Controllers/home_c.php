<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\carbon;
use App\User;
use App\Setting;
use App\device;

class home_c extends Controller
{
  function index(){
    return view('home');
  }
  function dashboard(Request $data){
    $userToday = device::whereDate('created_at', carbon::today());
    $userToday_id = $userToday->distinct('user_id')->pluck('user_id')->all();
    $total_user = user::count();
    $user_hadir = count($userToday_id);
    $user_absen = $total_user - $user_hadir;
    // dd($user_absen);
    return compact('total_user', 'user_hadir', 'user_absen');
  }
  function grafik(Request $data){
    $h0 = device::whereBetween('created_at', [carbon::today(), carbon::now()]);
    $h1 = device::whereBetween('created_at', [carbon::today(), carbon::now()->sub(1, 'hours')]);
    $h2 = device::whereBetween('created_at', [carbon::today(), carbon::now()->sub(2, 'hours')]);
    $h3 = device::whereBetween('created_at', [carbon::today(), carbon::now()->sub(3, 'hours')]);
    $h4 = device::whereBetween('created_at', [carbon::today(), carbon::now()->sub(4, 'hours')]);

    $total_user = user::count();
    $series = array();
    // Jumlah User terdeteksi
    $series['detected']['name'] = 'Terdeteksi Kamera';
    $series['detected']['data'] = [$h4->count(), $h3->count(), $h2->count(), $h1->count(), $h0->count()];
    // Jumlah User Hadir
    $series['hadir']['name'] = 'Hadir';
    $series['hadir']['data'] = [
      count($h4->distinct('user_id')->pluck('user_id')->all()),
      count($h3->distinct('user_id')->pluck('user_id')->all()),
      count($h2->distinct('user_id')->pluck('user_id')->all()),
      count($h1->distinct('user_id')->pluck('user_id')->all()),
      count($h0->distinct('user_id')->pluck('user_id')->all())
    ];
    // Jumlah Absen Absen
    $series['absen']['name'] = 'Absen';
    $series['absen']['data'] = [
      $total_user - count($h4->distinct('user_id')->pluck('user_id')->all()),
      $total_user - count($h3->distinct('user_id')->pluck('user_id')->all()),
      $total_user - count($h2->distinct('user_id')->pluck('user_id')->all()),
      $total_user - count($h1->distinct('user_id')->pluck('user_id')->all()),
      $total_user - count($h0->distinct('user_id')->pluck('user_id')->all())
    ];
    return compact('series');
  }
}
