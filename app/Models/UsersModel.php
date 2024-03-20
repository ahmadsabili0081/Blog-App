<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'username', 'email', 'password', 'picture', 'bio', 'id_role'];

    public function get_by($result)
    {
        $field_type = filter_var($result, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if ($field_type == 'email') {
            return $this->where('email', $result)->first();
        } else {
            return $this->where('username', $result)->first();
        }
    }

    public function get_by_id($id = false)
    {
        if ($id) {
            return $this->where('id_role', $id)->first();
        }
        return $this->findAll();
    }
}
