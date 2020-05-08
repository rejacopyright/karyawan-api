<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('admin/login', 'admin\auth_c@login');
Route::get('user/absen', 'guest_c@absen');
Route::get('user/face', 'guest_c@face');
Route::get('user/devices/list', 'guest_c@devices_list');
Route::get('user/devices', 'guest_c@devices');
// Get Image Data
Route::get('image_data', 'guest_c@image_data');
Route::group(["middleware" => "auth:admin-api"], function(){
  Route::get('/', function(){
    return 'Nanti di isi dokumentasi penggunaan API, Endpoint, Method, dll';
  });
  // Dashboard
  Route::get('dashboard', 'home_c@dashboard');
  Route::get('grafik', 'home_c@grafik');

  Route::get('user', 'user_c@user');
  Route::get('user/detail/{user_id}', 'user_c@detail');
  Route::post('user/store', 'user_c@store');
  Route::post('user/update', 'user_c@update');
  Route::post('user/delete', 'user_c@delete');
  // Role
  Route::get('role', 'role_c@role');
  Route::post('role/store', 'role_c@store');
  Route::post('role/update', 'role_c@update');
  Route::get('role/detail/{role_id}', 'role_c@detail');
  Route::post('role/delete', 'role_c@delete');
  // Role
  Route::get('jabatan', 'jabatan_c@jabatan');
  Route::post('jabatan/store', 'jabatan_c@store');
  Route::post('jabatan/update', 'jabatan_c@update');
  Route::post('jabatan/delete', 'jabatan_c@delete');
  Route::get('jabatan/detail/{jabatan_id}', 'jabatan_c@detail');
  // Setting
  Route::get('setting', 'setting_c@setting');
  Route::post('setting/update', 'setting_c@update');
  Route::get('absen', 'absen_c@absen');
  // TESTER
  Route::get('absen/test', 'absen_c@test');
});
