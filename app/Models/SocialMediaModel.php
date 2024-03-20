<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialMediaModel extends Model
{
    protected $table            = 'social_media';
    protected $primaryKey       = 'id_social_media';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['youtube_url', 'facebook_url', 'github_url', 'twitter_url', 'linkedin_url', 'instagram_url'];
}
