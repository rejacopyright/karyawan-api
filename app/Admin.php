<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';
    protected $table = 'admin';
    protected $guarded = [];
    protected $hidden = [ 'password', 'api_token', 'remember_token' ];
}
