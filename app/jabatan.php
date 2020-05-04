<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
  protected $table = 'jabatan';
  protected $guarded = [];
  // PARENT
  function user(){
    return $this->hasMany('App\User', 'jabatan_id', 'jabatan_id');
  }
}
