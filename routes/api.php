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
  Route::get('jabatan/multiple', 'jabatan_c@multiple');
  // Payroll
  Route::get('payroll', 'payroll_c@payroll');
  Route::post('payroll/store', 'payroll_c@store');
  Route::post('payroll/update', 'payroll_c@update');
  Route::get('payroll/detail/{payroll_id}', 'payroll_c@detail');
  Route::get('payroll/bpjs/kesehatan', 'payroll_c@bpjs_kesehatan');
  Route::post('payroll/bpjs/kesehatan/update', 'payroll_c@bpjs_kesehatan_update');
  Route::get('payroll/bpjs/ketenagakerjaan', 'payroll_c@bpjs_ketenagakerjaan');
  Route::post('payroll/bpjs/ketenagakerjaan/update', 'payroll_c@bpjs_ketenagakerjaan_update');
  Route::get('payroll/pph/ptkp', 'payroll_c@pph_ptkp');
  Route::post('payroll/pph/ptkp/update', 'payroll_c@pph_ptkp_update');
  Route::get('payroll/pph/pkp', 'payroll_c@pph_pkp');
  Route::post('payroll/pph/pkp/update', 'payroll_c@pph_pkp_update');
  // Setting
  Route::get('setting', 'setting_c@setting');
  Route::post('setting/update', 'setting_c@update');
  Route::get('absen/hadir', 'absen_c@hadir');
  Route::get('absen/absen', 'absen_c@absen');
  Route::get('absen/ijin', 'absen_c@ijin');
  Route::get('absen/cuti', 'absen_c@cuti');
  Route::get('absen/count', 'absen_c@absen_count');
  // TESTER
  Route::get('absen/test', 'absen_c@test');
});
