<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FrontendController extends BaseController
{
    public function index()
    {
        return view('frontend/elFinder/elfinder');
    }
}
