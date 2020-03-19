<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => "auth:admin-api"], function(){
  Route::get('/', function(){
    return 'Nanti di isi dokumentasi penggunaan API, Endpoint, Method, dll';
  });
  Route::get('user', 'user_c@user');
  Route::get('user/detail/{user_id}', 'user_c@detail');
  Route::post('user/store', 'user_c@store');
  Route::post('user/update', 'user_c@update');
  Route::post('user/delete', 'user_c@delete');
});
