<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Storage;
use Str;
use Image;
use App\Admin;
use App\User;
use App\user_image as img;

class user_c extends Controller
{
  function user(){
    $user = User::paginate(10)->map(function($i){
      $i->img->map(function($m){
        $m['base'] = base64_encode(file_get_contents(url('public/img/user/thumb/'.$m['name'])));
        return $m;
      });
      return $i;
    });
    return $user;
  }
  function detail($user_id){
    $user = User::where('user_id', $user_id)->first();
    $images = $user->img->map(function($i){$i['base'] = base64_encode(file_get_contents(url('public/img/user/'.$i['name'])));return $i;});
    return compact('user', 'images');
  }
  function store(Request $data){
    $user_id = User::max('user_id')+1;
    $user = new User;
    $user->user_id = $user_id;
    $user->name = $data->name;
    $user->gender = $data->gender;
    $user->job = $data->job;
    $user->nik = $data->nik;
    $user->kk = $data->kk;
    $user->tlp = $data->tlp;
    $user->alamat = $data->alamat;
    $user->username = $data->username;
    $user->password = bcrypt(($data->password ?? '0000'));
    $user->api_token = Str::random(80);
    $user->email = $data->email;
    $user->save();

    // Image
    if ($user->save() && count($data->img)) {
      if (!is_dir('public/img/user')) { mkdir('public/img/user', 0777, true); }
      if (!is_dir('public/img/user/thumb')) { mkdir('public/img/user/thumb', 0777, true); }
      $image_id = img::max('image_id')+1;
      for ($i=0; $i < count($data->img); $i++) {
        $filename = $user_id.'_'.date('Ymd').'_'.($i+1).'.jpg';
        Image::make($data->img[$i])->resize(500, null, function($c){$c->aspectRatio();})->save('public/img/user/'.$filename, 50);
        Image::make($data->img[$i])->resize(150, null, function($c){$c->aspectRatio();})->save('public/img/user/thumb/'.$filename, 50);
        // STORE
        img::create(['image_id' => $image_id+$i, 'user_id' => $user_id, 'name' => $filename]);
      }
    }
    return $user;
  }
  function update(Request $data){
    $user = User::where('user_id', $data->user_id)->first();
    if ($data->name) { $user->name = $data->name; }
    if ($data->gender) { $user->gender = $data->gender; }
    $user->job = $data->job;
    $user->nik = $data->nik;
    $user->kk = $data->kk;
    $user->tlp = $data->tlp;
    $user->alamat = $data->alamat;
    if ($data->username) { $user->username = $data->username; }
    $user->password = bcrypt(($data->password ?? '0000'));
    if ($data->email) { $user->email = $data->email; }
    $user->save();


    // Image
    if ($user->save() && $data->has('img')) {
      // Delete Image Record and Files
      $user->img->map(function($i){return Storage::delete('public/img/user/'.$i->name);});
      $user->img->map(function($t){return Storage::delete('public/img/user/thumb/'.$t->name);});
      img::where('user_id', $data->user_id)->delete();
      // Storage
      $image_id = img::max('image_id')+1;
      for ($i=0; $i < count($data->img); $i++) {
        $filename = $user->user_id.'_'.date('Ymd').'_'.($i+1).'.jpg';
        Image::make($data->img[$i])->resize(500, null, function($c){$c->aspectRatio();})->save('public/img/user/'.$filename, 50);
        Image::make($data->img[$i])->resize(150, null, function($c){$c->aspectRatio();})->save('public/img/user/thumb/'.$filename, 50);
        // STORE
        img::create(['image_id' => $image_id+$i, 'user_id' => $user->user_id, 'name' => $filename]);
      }
    }
    return $user;
  }
  function delete(Request $data){
    $user = User::where('user_id', $data->user_id)->first();
    if ($user->img->count()) {
      $user->img->map(function($i){return Storage::delete('public/img/user/'.$i->name);});
      $user->img->map(function($t){return Storage::delete('public/img/user/thumb/'.$t->name);});
      img::where('user_id', $data->user_id)->delete();
    }
    $user->delete();
    return $this->user();
  }
}
