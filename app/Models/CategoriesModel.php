<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kategori', 'ordering'];
}
