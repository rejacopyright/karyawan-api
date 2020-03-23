<?php

namespace App\Controllers\admin;

use App\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;

class auth_c extends Controller {
  function auth(){
    return auth::guard('admin-api')->check() ? 1 : 0;
  }
  function check_username(Request $data){
    $check = admin::where('username', $data->username);
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
    Auth::guard('admin')->attempt($credential);
    if (!Auth::guard('admin')->check()) {
      return ['value' => 'failed', 'message' => 'Kami tidak menemukan username dan password yang cocok'];
    }else {
      return Auth::guard('admin')->user();
    }
  }
  function logout(Request $data) {
    auth::guard('admin')->logout();
    return redirect('/');
  }
}
