<?php

namespace App\Controllers;

use Illuminate\Http\Request;

class home_c extends Controller
{
  function index(){
    return view('home');
  }
}
