<?php

use App\Models\CategoriesModel;
use App\Models\SettingsModel;
use App\Models\SocialMediaModel;
use App\Models\SubCategoriesModel;
use App\Models\PostsModel;
use Carbon\Carbon;


if (!function_exists('get_settings')) {
  function get_settings()
  {
    $result = new SettingsModel();
    return $result->first();
  }
}


if (!function_exists('get_social_media')) {
  function get_social_media()
  {
    $result = null;
    $social_media  = new SocialMediaModel();
    $social_media_data = $social_media->first();

    if (!$social_media_data) {
      $data = array(
        'youtube_url' => null,
        'facebook_url' => null,
        'github_url' => null,
        'twitter_url' => null,
        'linkedin_url' => null,
        'instagram' => null
      );
      $social_media->save($data);
      $new_social_media_data = $social_media->first();
      $result = $new_social_media_data;
    } else {
      $result = $social_media_data;
    }

    return $result;
  }
}

if (!function_exists('current_root_name')) {
  function current_root_name()
  {
    $route = \Config\Services::router();
    $route_name = $route->getMatchedRouteOptions()['as'];
    return $route_name;
  }
}

if (!function_exists('get_parent_category')) {
  function get_parent_category()
  {
    $category = new CategoriesModel();
    return $category->orderBy('ordering', 'asc')->findAll();
  }
}

if (!function_exists('get_sub_category_by_parent_category')) {
  function get_sub_category_by_parent_category($id)
  {
    $sub_category = new SubCategoriesModel();
    return $sub_category->orderBy('ordering', 'asc')->where('id_kategori', $id)->findAll();
  }
}

if (!function_exists('get_dependent_subcategories')) {
  function get_dependent_subcategories()
  {
    $sub_category = new SubCategoriesModel();
    return $sub_category->orderBy('ordering', 'asc')->where('id_kategori = ', 0)->findAll();
  }
}


if (!function_exists('date_formatter')) {
  function date_formatter($date)
  {
    // ll nov 12 2024
    // LL November 12 2024
    return Carbon::createFromFormat('Y-m-d H:i:s', $date)->isoFormat('ll');
  }
}

if (!function_exists('get_reading_time')) {
  function get_reading_time($content)
  {
    $word_count =  str_word_count($content);
    $word_per_minute = 200;
    $m = ceil($word_count / $word_per_minute);
    return $m <= 1 ? $m . ' Min Read' : $m . ' Mins Read';
  }
}

if (!function_exists('limit_words')) {
  function limit_words($content = null, $limit = 8)
  {


    // Memisahkan string menjadi array kata
    $words = explode(' ', $content);

    // Mengambil 5 kata pertama dari array
    $limited_words = array_slice($words, 0, $limit);

    // Menggabungkan kembali array kata menjadi string
    $limited_content = implode(' ', $limited_words);

    return $limited_content;
  }
}

if (!function_exists('lates_limit_words')) {
  function lates_limit_words($content = null)
  {


    // Memisahkan string menjadi array kata
    $words = explode(' ', $content);

    // Mengambil 30 kata pertama dari array
    $limited_words = array_slice($words, 0, 30);

    // Menggabungkan kembali array kata menjadi string
    $limited_content = implode(' ', $limited_words);

    return $limited_content;
  }
}

if (!function_exists('get_latest_post')) {
  function get_latest_post()
  {
    $post = new PostsModel();
    return $post->asObject()->where('visibility', 1)->orderBy('created_at', 'desc')->first();
  }
}

// get latest 6 posts
if (!function_exists('get_latest_6_posts')) {
  function get_latest_6_posts()
  {
    $posts = new PostsModel();
    return $posts->where('visibility', 1)->limit(6, 1)->orderBy('created_at', 'desc')->find();
  }
}

if (!function_exists('get_random_posts')) {
  function get_random_posts($max = 4)
  {
    $posts = new PostsModel();
    return $posts->where('visibility', 1)
      ->orderBy('RAND()')
      ->limit(4)
      ->find();
  }
}


// sidebar Categories
if (!function_exists('get_sidebar_categories')) {
  function get_sidebar_categories()
  {
    $sub_cat = new SubCategoriesModel();
    return $sub_cat->orderBy('sub_kategori', 'asc')->findAll();
  }
}

if (!function_exists('get_sidebar_categories_by_id')) {
  function get_sidebar_categories_by_id($id)
  {
    $post = new PostsModel();
    $post_value = $post->where('visibility', 1)->where('id_kategori', $id)->findAll();
    return count($post_value);
  }
}
