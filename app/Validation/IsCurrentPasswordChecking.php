<?php

namespace App\Validation;

use App\Libraries\Hash;
use App\Libraries\CIAuth;
use App\Models\UsersModel;

class IsCurrentPasswordChecking
{
    public function check_current_password($password): bool
    {
        $password = trim($password);
        $id_user = session()->get('id_user');
        $user = new UsersModel();
        $user_info = $user->where('id_user', $id_user)->first();
        if (!Hash::check_password($password, $user_info['password'])) {
            return false;
        }
        return true;
    }
}
