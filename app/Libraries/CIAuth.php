<?php

namespace App\Libraries;

class CIAuth
{

  public static function set_login_session($userdata)
  {
    $session = session();
    $session->set($userdata);
    return true;
  }

  public static function set_remove_login_session($userdata)
  {
    $session = session();
    $session->remove($userdata);
    return true;
  }
}
