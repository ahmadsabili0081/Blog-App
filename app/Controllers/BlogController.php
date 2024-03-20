<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SubCategoriesModel;
use App\Models\PostsModel;

class BlogController extends BaseController
{
    protected $sub_categories_model;
    protected $posts_model;

    public function __construct()
    {
        helper(['url', 'form', 'CI_get_user', 'CI_function', 'CIMailer']);
        $this->sub_categories_model = new SubCategoriesModel();
        $this->posts_model = new PostsModel();
    }
    public function index()
    {
        $data = [
            'page_title' => "Home | Blog App"
        ];
        return view('frontend/Home/index', $data);
    }

    public function category_posts($category)
    {
        $sub_categories_value = $this->sub_categories_model->where('slug', $category)->first();
        $data = [
            'title' => $sub_categories_value['sub_kategori'] . '| Blog App',
            'category' => $sub_categories_value,
            'posts' => $this->posts_model->where('visibility', 1)->where('id_kategori', $sub_categories_value['id_kategori'])->paginate(6),
            'pager' => $this->posts_model->pager,
        ];

        return view('frontend/Home/pages', $data);
    }
}
