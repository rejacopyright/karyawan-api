<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\role;

class role_c extends Controller
{
  function role(Request $data){
    $page = role::orderBy('name');
    if ($data->q) { $page->where('name', 'like', '%'.$data->q.'%'); }
    $page = $page->paginate(10);
    $role = $page->map(function($i){
      return $i;
    });
    return compact('role', 'page');
  }
  function store(Request $data){
    $role_id = role::max('role_id')+1;
    $role = new role;
    $role->role_id = $role_id;
    $role->name = $data->name;
    $role->desc = $data->desc;
    if (count($data->role)) {
      $role->role = implode('|', $data->role);
    }
    $role->save();
    return $role;
  }
  function update(Request $data){
    $role = role::where('role_id', $data->role_id)->first();
    if ($data->name) { $role->name = $data->name; }
    if ($data->desc) { $role->desc = $data->desc; }
    if (count($data->role)) {
      $role->role = implode('|', $data->role);
    }else {
      $role->role = null;
    }
    $role->save();
    return $role;
  }
  function detail($role_id){
    $role = role::where('role_id', $role_id)->first();
    $access = explode('|', $role->role);
    return compact('role', 'access');
  }
  function delete(Request $data){
    $role = role::where('role_id', $data->role_id)->first();
    $role->delete();
    return compact('role');
  }
}
