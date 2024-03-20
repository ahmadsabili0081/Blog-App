<?php

namespace App\Models;

use CodeIgniter\Model;

class SubCategoriesModel extends Model
{
    protected $table            = 'sub_categories';
    protected $primaryKey       = 'id_sub';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['sub_kategori', 'slug', 'id_kategori', 'description', 'ordering'];
}
