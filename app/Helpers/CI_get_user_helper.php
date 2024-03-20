<?php

use App\Models\UsersModel;

if (!function_exists('get_user_session')) {
  function get_user_session()
  {
    if (!empty(session()->get('id_user'))) {
      $user = new UsersModel();
      return $user->where('id_user', session()->get('id_user'))->first();
    } else {
      return redirect()->to(base_url('admin/login'))->with('fail', 'Lakukan login terlebih dahulu!');
    }
  }
}
