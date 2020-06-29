<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;

class auth_c extends Controller
{
  function test(){
    return auth::user();
  }
  function auth(){
    return auth::guard('client-api')->check() ? 1 : 0;
  }
  function check_username(Request $data){
    $check = user::where('username', $data->username);
    if ($data->except) {
      $check->where('username', '!=', $data->except);
    }
    return $check->count();
  }
  function login(Request $data) {
    if (!$data->username) {
      return ['value' => 'username', 'message' => 'Username tidak boleh kosong'];
    }
    if (!$data->password) {
      return ['value' => 'password', 'message' => 'Password tidak boleh kosong'];
    }
    $credential = ['username' => $data->username, 'password' => $data->password];
    Auth::guard('client')->attempt($credential);
    if (!Auth::guard('client')->check()) {
      return ['value' => 'failed', 'message' => 'Kami tidak menemukan username dan password yang cocok'];
    }else {
      return Auth::guard('client')->user();
    }
  }
  function logout(Request $data) {
    auth::guard('client')->logout();
    return redirect('/');
  }
}
