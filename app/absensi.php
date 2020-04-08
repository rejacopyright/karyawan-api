<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
  protected $table = 'absensi';
  protected $guarded = [];
  // PARENT
  function user(){
    return $this->belongsTo('App\User', 'user_id', 'user_id');
  }
}
