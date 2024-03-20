<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id_setting';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['blog_title', 'blog_email', 'blog_no_telp', 'blog_meta_keywords', 'description_blog', 'blog_logo', 'blog_favicon'];
}
