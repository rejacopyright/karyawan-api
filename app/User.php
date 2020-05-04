<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'api_token', 'remember_token', ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // PARENT
    function jabatan(){
      return $this->belongsTo('App\jabatan', 'jabatan_id', 'jabatan_id');
    }
    // CHILD
    function img(){
      return $this->hasMany('App\user_image', 'user_id', 'user_id');
    }
}
