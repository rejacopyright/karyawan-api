<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\jabatan;

class jabatan_c extends Controller
{
  function jabatan(Request $data){
    $page = jabatan::orderBy('name');
    if ($data->q) { $page->where('name', 'like', '%'.$data->q.'%'); }
    $page = $page->paginate(10);
    $jabatan = $page->map(function($i){
      return $i;
    });
    return compact('jabatan', 'page');
  }
  function store(Request $data){
    $jabatan_id = jabatan::max('jabatan_id')+1;
    $jabatan = new jabatan;
    $jabatan->jabatan_id = $jabatan_id;
    $jabatan->name = $data->name;
    $jabatan->salary = $data->salary;
    $jabatan->desc = $data->desc;
    $jabatan->save();
    return $jabatan;
  }
  function update(Request $data){
    $jabatan = jabatan::where('jabatan_id', $data->jabatan_id)->first();
    if ($data->name) { $jabatan->name = $data->name; }
    if ($data->salary) { $jabatan->salary = $data->salary; }
    if ($data->desc) { $jabatan->desc = $data->desc; }
    $jabatan->save();
    return $jabatan;
  }
  function detail($jabatan_id){
    $jabatan = jabatan::where('jabatan_id', $jabatan_id)->first();
    return compact('jabatan');
  }
  function multiple(Request $data){
    $jabatan = jabatan::whereIn('jabatan_id', $data->jabatan_id ?? [])->get();
    return compact('jabatan');
  }
  function delete(Request $data){
    $jabatan = jabatan::where('jabatan_id', $data->jabatan_id)->first();
    $jabatan->delete();
    return compact('jabatan');
  }
}
