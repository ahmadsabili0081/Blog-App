<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordTokensModel extends Model
{
    protected $DBGroup = 'default';
    protected $table            = 'password_tokens';
    protected $allowedFields    = ['email', 'token', 'created_at'];
}
