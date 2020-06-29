<?php
return [
  'defaults' => [ 'guard' => 'web', 'passwords' => 'users', ],
  'guards' => [
    'web' => [ 'driver' => 'session', 'provider' => 'users', ],
    'api' => [ 'driver' => 'token', 'provider' => 'users', 'hash' => false, ],
    'admin' => [ 'driver' => 'session', 'provider' => 'admin', ],
    'admin-api' => [ 'driver' => 'token', 'provider' => 'admin', 'hash' => false, ],
    'client' => [ 'driver' => 'session', 'provider' => 'client', ],
    'client-api' => [ 'driver' => 'token', 'provider' => 'client', 'hash' => false, ],
  ],
  'providers' => [
    'users' => [ 'driver' => 'eloquent', 'model' => App\User::class, ],
    'admin' => [ 'driver' => 'eloquent', 'model' => App\Admin::class, ],
    'client' => [ 'driver' => 'eloquent', 'model' => App\User::class, ],
  ],
  'passwords' => [
    'users' => [ 'provider' => 'users', 'table' => 'password_resets', 'expire' => 60, 'throttle' => 60, ],
    'admin' => [ 'provider' => 'admin', 'table' => 'password_resets', 'expire' => 60, 'throttle' => 60, ],
    'client' => [ 'provider' => 'client', 'table' => 'password_resets', 'expire' => 60, 'throttle' => 60, ],
  ],
  'password_timeout' => 10800,
];
