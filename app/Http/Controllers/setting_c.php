<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\setting;

class setting_c extends Controller
{
  function setting(){
    return setting::first();
  }
  function update(Request $data){
    $setting = setting::firstOrNew();
    if ($data->name) {
      $setting->name = $data->name;
    }
    if ($data->image) {
      $setting->image = $data->image;
    }
    if ($data->desc) {
      $setting->desc = $data->desc;
    }
    if ($data->in) {
      $setting->in = $data->in;
    }
    if ($data->out) {
      $setting->out = $data->out;
    }
    $setting->save();
    return $setting;
  }
}
