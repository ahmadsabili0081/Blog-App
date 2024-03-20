<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'BlogController::index');
$routes->get('post/(:any)', 'BlogController::index/$1', ['as' => 'read_post']);
$routes->get('category_posts/(:any)', 'BlogController::category_posts/$1', ['as' => 'category_posts']);

$routes->group('admin', static function ($routes) {
  $routes->group('', ['filter' => 'cifilter:auth'], static function ($routes) {
    $routes->get('', 'AdminController::index', ['as' => 'admin.home']);
    $routes->get('/', 'AdminController::index', ['as' => 'admin.home']);
    $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile']);
    $routes->get('logout', 'AuthController::logout', ['as' => 'admin.logout']);
    $routes->post('submit_personal_details', 'AdminController::submit_personal_details', ['as' => 'admin.submit_personal_details']);
    $routes->post('update_profile', 'AdminController::update_profile', ['as' => 'admin.update_profile']);
    $routes->post('change_password_submit', 'AdminController::change_password_submit', ['as' => 'admin.change_password_submit']);
    $routes->get('settings', 'AdminController::settings', ['as' => 'admin.settings']);
    $routes->post('update_general_settings', 'AdminController::update_general_settings', ['as' => 'admin.update_general_settings']);
    $routes->post('update_logo', 'AdminController::update_logo', ['as' => 'admin.update_logo']);
    $routes->post('social_media_submit', 'AdminController::social_media_submit', ['as' => 'admin.social_media_submit']);
    $routes->get('categories', 'AdminController::categories', ['as' => 'admin.categories']);
    $routes->post('kategori_submit', 'AdminController::kategori_submit', ['as' => 'admin.kategori_submit']);
    $routes->get('get_categories', 'AdminController::get_categories', ['as' => 'admin.get_categories']);
    $routes->get('get_categories_update', 'AdminController::get_categories_update', ['as' => 'admin.get_categories_update']);
    $routes->post('update_categories', 'AdminController::update_categories', ['as' => 'admin.update_categories']);
    $routes->get('delete_category', 'AdminController::delete_category', ['as' => 'admin.delete_category']);
    $routes->get('reorder_categories', 'AdminController::reorder_categories', ['as' => 'admin.reorder_categories']);
    $routes->get('get_parent_category', 'AdminController::get_parent_category', ['as' => 'admin.get_parent_category']);
    $routes->post('sub_kategori_submit', 'AdminController::sub_kategori_submit', ['as' => 'admin.sub_kategori_submit']);
    $routes->get('get_sub_category', 'AdminController::get_sub_category', ['as' => 'admin.get_sub_category']);
    $routes->get('get_sub_category_id', 'AdminController::get_sub_category_id', ['as' => 'admin.get_sub_category_id']);
    $routes->get('getSubCategory', 'AdminController::getSubCategory', ['as' => "admin.getSubCategory"]);
    $routes->post('sub_edit_sub_category', 'AdminController::sub_edit_sub_category', ['as' => 'admin.sub_edit_sub_category']);
    $routes->get('delete_sub_category', 'AdminController::delete_sub_category', ['as' => 'admin.delete_sub_category']);
    $routes->get('reoder_sub_categories', 'AdminController::reoder_sub_categories', ['as' => 'admin.reoder_sub_categories']);

    $routes->group('posts', static function ($routes) {
      $routes->get('new_posts', 'AdminController::new_posts', ['as' => 'admin.new_posts']);
      $routes->post('submit_posts', 'AdminController::submit_posts', ['as' => 'admin.submit_posts']);
      $routes->get('all_posts', 'AdminController::all_posts', ['as' => 'admin.all_posts']);
      $routes->get('get_posts', 'AdminController::get_posts', ['as' => 'admin.get_posts']);
      $routes->get('edit_posts/(:num)', 'AdminController::edit_posts/$1', ['as' => 'admin.edit_posts']);
      $routes->post('submit_edit_posts', 'AdminController::submit_edit_posts', ['as' => 'admin.submit_edit_posts']);
      $routes->get('delete_posts', 'AdminController::delete_posts', ['as' => 'admin.delete_posts']);
      $routes->get('frontend', 'FrontendController::index', ['as' => 'admin.frontend']);
    });
  });

  $routes->group('', ['filter' => 'cifilter:guest'], static function ($routes) {
    $routes->get('login', 'AuthController::index', ['as' => 'admin.login.index']);
    $routes->get('register', 'AuthController::register', ['as' => 'admin.register.register']);
    $routes->post('submit', 'AuthController::submit', ['as' => 'admin.submit.submit']);
    $routes->get('forgot_password', 'AuthController::forgot_password', ['as' => 'admin.forgot_password']);
    $routes->post('send_password', 'AuthController::send_password', ['as' => 'admin.send_password']);
    $routes->get('reset_password/(:any)', 'AuthController::reset_password/$1', ['as' => 'admin.reset_password']);
    $routes->post('reset_password_submit/(:any)', 'AuthController::reset_password_submit/$1', ['as' => 'admin.reset_password_submit']);
  });
});
