<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
  protected $table = 'role';
  protected $guarded = [];
  // CHILD
  function admin(){
    return $this->hasMany('App\Admin', 'role_id', 'role_id');
  }
}
