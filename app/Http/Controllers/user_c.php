<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Str;
use Image;
use App\Admin;
use App\User;
use App\user_image as img;
use App\user_title as title;

class user_c extends Controller
{
  function user(Request $data){
    $page = user::orderBy('updated_at', 'DESC');
    if ($data->jabatan_id) { $page->where('jabatan_id', $data->jabatan_id); }
    if ($data->q) { $page->where('name', 'like', '%'.$data->q.'%'); }
    $page = $page->paginate(10);
    $user = $page->map(function($i) use($data){
      $i->img->map(function($m) use($data){
        if (!$data->noBase) {
          $m['base'] = base64_encode(file_get_contents(url('public/img/user/'.$m['name'])));
        }
        return $m;
      });
      $i->jabatan = $i->jabatan;
      return $i;
    });
    return compact('user', 'page');
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
    $user->jabatan_id = $data->jabatan_id;
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
    if ($data->has('gender')) { $user->gender = $data->gender; }
    if ($data->jabatan_id) { $user->jabatan_id = $data->jabatan_id; }
    if ($data->has('nik')) { $user->nik = $data->nik; }
    if ($data->has('kk')) { $user->kk = $data->kk; }
    if ($data->has('tlp')) { $user->tlp = $data->tlp; }
    if ($data->has('alamat')) { $user->alamat = $data->alamat; }
    if ($data->has('u_pokok')) { $user->u_pokok = $data->u_pokok; }
    if ($data->has('u_makan')) { $user->u_makan = $data->u_makan; }
    if ($data->has('u_transport')) { $user->u_transport = $data->u_transport; }
    if ($data->has('u_anis')) { $user->u_anis = $data->u_anis; }
    if ($data->username) { $user->username = $data->username; }
    if ($data->has('password')) { $user->password = bcrypt(($data->password ?? '0000')); }
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
    $user->img;
    return ['update' => $user, 'user' => $this->user($data)['user']];
  }
  function delete(Request $data){
    $user = User::where('user_id', $data->user_id)->first();
    if ($user->img->count()) {
      $user->img->map(function($i){return Storage::delete('public/img/user/'.$i->name);});
      $user->img->map(function($t){return Storage::delete('public/img/user/thumb/'.$t->name);});
      img::where('user_id', $data->user_id)->delete();
    }
    $user->delete();
    return ['update' => $user, 'user' => $this->user($data)['user']];
  }
}
