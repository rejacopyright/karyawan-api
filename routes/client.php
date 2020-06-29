<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/c', function(){return 'ok client';});
Route::post('login', 'client\auth_c@login');
// Get Image Data
Route::group(["middleware" => "auth:client-api"], function(){
  Route::get('test', 'client\auth_c@test');
  Route::get('me', 'client\user_c@me');
  Route::get('/', function(){
    return 'Nanti di isi dokumentasi penggunaan API, Endpoint, Method, dll';
  });
  // Dashboard
  Route::get('dashboard', 'home_c@dashboard');
  Route::get('grafik', 'home_c@grafik');

  // TESTER
  Route::get('absen/test', 'absen_c@test');
});
