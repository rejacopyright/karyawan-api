<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_image extends Model
{
  protected $table = 'user_image';
  protected $guarded = [];
  // PARENT
  function img(){
    return $this->belongsTo('App\User', 'user_id', 'user_id');
  }
}
