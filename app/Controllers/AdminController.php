<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\UsersModel;
use App\Models\SettingsModel;
use App\Models\SocialMediaModel;
use App\Models\CategoriesModel;
use SSP;
use Mberecall\CI_Slugify\SlugService;
use App\Models\SubCategoriesModel;
use App\Models\PostsModel;

class AdminController extends BaseController
{

    protected $user_model;
    protected $settings_model;
    protected $social_media;
    protected $categories_model;
    protected $sub_catergories_modal;
    protected $db;
    protected $posts_model;

    public function __construct()
    {
        helper(['url', 'form', 'CIMailer', 'CI_get_user', 'CI_function']);
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
        $this->user_model = new UsersModel();
        $this->settings_model  = new SettingsModel();
        $this->social_media = new SocialMediaModel();
        $this->categories_model = new CategoriesModel();
        $this->sub_catergories_modal = new SubCategoriesModel();
        $this->posts_model = new PostsModel();
    }

    public function index()
    {
        $data = [
            'title' => "Dashboard Admin | Blog App"
        ];
        return view('Admin/index', $data);
    }

    public function profile()
    {
        $data = [
            'title' => "Profile | Blog App"
        ];
        return view('Admin/profile/index', $data);
    }

    public function submit_personal_details()
    {

        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        if ($request->isAJAX()) {
            $this->validate([
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Nama harus terisi!"
                    ],
                ],
                'username' => [
                    'rules' => 'required|trim|min_length[4]',
                    'errors' => [
                        'required' => "Kolom Username harus terisi!",
                        'min_length' => "Kolom Username panjang karakter min 4!"
                    ],
                ]
            ]);
            if ($validation->run() == false) {
                $errors = $this->validator->getErrors();
                return json_encode(['status' => 0, 'error' => $errors]);
            } else {
                $update = $this->user_model->where('id_user', get_user_session()['id_user'])
                    ->set([
                        'name' => $request->getPost('name'),
                        'username' => $request->getPost('username'),
                        'bio' => $request->getPost('bio')
                    ])->update();

                if ($update) {
                    $user_info = $this->user_model->find(get_user_session()['id_user']);
                    return json_encode(['status' => 1, 'user_info' => $user_info, 'msg' => 'Detail pribadi Anda telah berhasil diperbarui.']);
                } else {
                    return json_encode(['status' => 0, 'msg' => 'Ada Kesalahan saat mengubah Detail Pribadi']);
                }
            }
        }
    }

    public function update_profile()
    {
        $request = \Config\Services::request();
        $user_info = $this->user_model->where('id_user', get_user_session()['id_user'])->first();
        $path = 'frontend/images/user/';
        $file = $request->getFile('user_profile_file');
        $old_file_picture = $user_info['picture'];
        $new_file_name = "Blog_app" . $user_info['id_user'] . $file->getRandomName();

        // if ($file->move($path, $new_file_name)) {
        //     if ($old_file_picture != null && file_exists($path . $old_file_picture) && $old_file_picture != 'default.jpg') {
        //         unlink($path . $old_file_picture);
        //     }
        //     $this->user_model->where('id_user', $user_info['id_user'])
        //         ->set(['picture' => $new_file_name])
        //         ->update();
        //     echo json_encode(['status' => 1, 'msg' => 'Profile anda berhasil diperbarui!']);
        // } else {
        //     echo json_encode(['status' => 0, 'msg' => 'Ada kesalahan saat mengubah foto!']);
        // }
        //  image manipulation
        $upload_image = \Config\Services::image()
            ->withFile($file)
            ->resize(450, 450, true, 'height')
            ->save($path . $new_file_name);
        if ($upload_image) {
            if ($old_file_picture != null && file_exists($path . $old_file_picture) && $old_file_picture != 'default.jpg') {
                unlink($path . $old_file_picture);
            }
            $this->user_model->where('id_user', $user_info['id_user'])
                ->set(['picture' => $new_file_name])
                ->update();
            echo json_encode(['status' => 1, 'msg' => 'Profile anda berhasil diperbarui!']);
        } else {
            echo json_encode(['status' => 0, 'msg' => 'Ada kesalahan saat mengubah foto!']);
        }
    }

    public function change_password_submit()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        if ($request->isAJAX()) {
            $user_info = $this->user_model->where('id_user', get_user_session()['id_user'])->first();
            $this->validate([
                'password_old' => [
                    'rules' => "required|check_current_password[password_old]",
                    'errors' => [
                        'required' => 'Kolom password Saat ini harus terisi!',
                        'check_current_password' => "Password Saat ini salah!",
                    ],
                ],
                'password_new' => [
                    'rules' => "required|min_length[4]|is_password_strong[password_new]",
                    'errors' => [
                        'required' => 'Kolom password Baru harus terisi!',
                        'min_length' => "Kolom password panjang karakter min 4!",
                        'is_password_strong' => "Password harus berisi minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter khusus!"
                    ],
                ],
                'confirm_password_new' => [
                    'rules' => "required|min_length[4]|is_password_strong[confirm_password_new]",
                    'errors' => [
                        'required' => 'Kolom Konfirmasi password harus terisi!',
                        'is_password_strong' => "Konfirmasi Password harus berisi minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter khusus!",
                        'min_length' => "Kolom password panjang karakter min 4!"
                    ],
                ],
            ]);
            if ($validation->run() === FALSE) {
                return $this->response->setJSON(['status' => 0, 'error' => $this->validator->getErrors()]);
            } else {

                $this->user_model->where('id_user', get_user_session()['id_user'])
                    ->set(['password' => Hash::make($request->getPost('password_new'))])
                    ->update();
                // send notification to email
                $mail_data = [
                    'user' => $user_info,
                    'password' => $request->getPost('password_new')
                ];
                // membuat view notif
                $view = \Config\Services::renderer();
                $mail_body  = $view->setVar('mail_data', $mail_data)->render('email-templates/notification_email');
                $mail_config = [
                    'mail_from_email' => 'blog_app@blog.test',
                    'mail_from_name' => 'BLOG_APP',
                    'mail_recipient_email' => $user_info['email'],
                    'mail_recipient_name' => $user_info['name'],
                    'mail_subject' => "Pemberitahuan Reset Password",
                    'mail_body' => $mail_body,
                ];
                send_email($mail_config);
                return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Good']);
            }
        }
    }

    public function settings()
    {
        $data = [
            'title' => "Setting | Blog App",
            'get_data' => $this->settings_model->get_data()
        ];
        return view('Admin/settings/index', $data);
    }

    public function update_general_settings()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        if ($request->isAJAX()) {
            $rules = [
                'blog_title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Judul Blog harus terisi!"
                    ],
                ],
                'blog_email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => "Kolom Email Blog harus terisi!",
                        'valid_email' => "Email harus valid!"
                    ],
                ],
                'blog_no_telp' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom No Telepon Blog harus terisi!"
                    ],
                ],
                'blog_meta_keywords' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Kata Kunci Blog harus terisi!"
                    ],
                ],
                'description_blog' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Desktipsi Blog harus terisi!"
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'error' => $validation->getErrors()]);
            } else {
                $settingId = $this->settings_model->get_data();
                $update = $this->settings_model->where('id_setting', $settingId['id_setting'])
                    ->set([
                        'blog_title' => $request->getPost('blog_title'),
                        'blog_email' => $request->getPost('blog_email'),
                        'blog_no_telp' => $request->getPost('blog_no_telp'),
                        'blog_meta_keywords' => $request->getPost('blog_meta_keywords'),
                        'description_blog' => $request->getPost('description_blog')
                    ])->update();
                if ($update) {
                    return $this->response->setJSON(['status' => 1, 'msg' => 'Pengaturan umum berhasil diperbaharui!']);
                } else {
                    return $this->response->setJSON(['status' => 0, 'msg' => 'Ada kesalahan saat memperbaharui pengaturan umum!']);
                }
            }
        }
    }

    public function update_logo()
    {
        $request = \Config\Services::request();
        $file = $this->request->getFile('blog_logo');

        if ($request->isAJAX()) {
            $path = 'frontend/images/blog/';
            $setting_data = $this->settings_model->get_data();
            $old_blog_logo = $setting_data['blog_logo'];
            $new_file_name = 'Blog_app' . '_' . $file->getRandomName();
            if ($file->move($path, $new_file_name)) {
                if ($old_blog_logo != null && file_exists($path . $old_blog_logo)) {
                    if ($old_blog_logo != 'default.png') {
                        unlink($path . $old_blog_logo);
                    }
                }
                $id = $this->settings_model->get_data();
                $update = $this->settings_model->save([
                    'id_setting' => $id['id_setting'],
                    'blog_logo' => $new_file_name
                ]);
                if ($update) {
                    return $this->response->setJSON(['status' => 1, 'msg' => 'Logo Berhasil di ubah!']);
                } else {
                    return $this->response->setJSON(['status' => 0, 'msg' => 'Logo gagal di ubah!']);
                }
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => 'Gagal saat mengubah logo!']);
            }
        }
    }

    public function social_media_submit()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        if ($request->isAJAX()) {
            $rules = [
                'youtube_url' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Url Youtube harus terisi!"
                    ],
                ],
                'facebook_url' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Url Facebook harus terisi!"
                    ],
                ],
                'github_url' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Url Github harus terisi!"
                    ],
                ],
                'twitter_url' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Url Twitter harus terisi!"
                    ],
                ],
                'linkedin_url' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Url Linkedin harus terisi!"
                    ],
                ],
                'instagram_url' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Url Instagram harus terisi!"
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'error' => $validation->getErrors()]);
            } else {
                $social_media_id = $this->social_media->first();
                $update = $this->social_media->where('id_social_media', $social_media_id['id_social_media'])
                    ->set([
                        'youtube_url' => $request->getPost('youtube_url'),
                        'facebook_url' => $request->getPost('facebook_url'),
                        'github_url' => $request->getPost('github_url'),
                        'twitter_url' => $request->getPost('twitter_url'),
                        'linkedin_url' => $request->getPost('linkedin_url'),
                        'instagram_url' => $request->getPost('instagram_url')
                    ])
                    ->update();

                if ($update) {
                    return $this->response->setJSON(['status' => 1, 'msg' => 'Social Media berhasil diubah!']);
                } else {
                    return $this->response->setJSON(['status' => 0, 'msg' => 'Social Media gagal di ubah!']);
                }
            }
        }
    }

    public function categories()
    {
        $data = [
            'title' => "Kategori | Blog App"
        ];

        return view('Admin/categories/index', $data);
    }

    public function kategori_submit()
    {
        $request = \Config\Services::request();
        $validation  = \Config\Services::validation();

        if ($request->isAJAX()) {
            $rules = [
                'kategori' => [
                    'rules' => 'required|is_unique[categories.kategori]',
                    'errors' => [
                        'required' => "Kolom Kategori harus terisi!",
                        'is_unique' => "{value} sudah terdaftar!"
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                $validationErrors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $validationErrors]);
            } else {
                $save = $this->categories_model->save([
                    'kategori' => $this->request->getPost('kategori')
                ]);

                if ($save) {
                    return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => "Kategori berhasil ditambahkan!"]);
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => "Kategori gagal ditambahkan!"]);
                }
            }
        }
    }

    // langkah kedua download ssp 

    public function get_categories()
    {
        $dbDetails = array(
            "host" => $this->db->hostname,
            "user" => $this->db->username,
            "pass" => $this->db->password,
            "db" => $this->db->database
        );

        $table = "categories";
        $primaryKey = "id_kategori";
        $colums = array(
            array(
                "db" => "id_kategori",
                "dt" => 0
            ),
            array(
                "db" => "kategori",
                "dt" => 1
            ),
            array(
                "db" => "id_kategori",
                "dt" => 2,
                "formatter" => function ($d, $row) {
                    $id_sub = $this->sub_catergories_modal->where('id_kategori', $row['id_kategori'])->findAll();
                    return count($id_sub);
                }
            ),
            array(
                "db" => "id_kategori",
                "dt" => 3,
                "formatter" => function ($d, $row) {
                    return "<div class='btn-group row col'> 
                    <button class='btn btn-sm btn-warning  editCategoryBtn' data-id='" . $row['id_kategori'] . "'>Edit</button>
                    <button class='btn btn-sm btn-danger deleteCategoriBtn' data-id='" . $row['id_kategori'] . "'>Delete</button>   
                    </div>";
                }
            ),
            array(
                "db" => "ordering",
                "dt" => 4,
            )
        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $colums)
        );
    }

    public function get_categories_update()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id = $request->getVar('id_kategori');
            $category_data  = $this->categories_model->where('id_kategori', $id)->find();
            return $this->response->setJSON(['data' => $category_data]);
        }
    }

    public function update_categories()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id = $request->getPost('id_kategori');
            $rules = [
                'kategori' => [
                    'rules' => 'required|is_unique[categories.kategori,id_kategori,' . $id . ']',
                    'errors' => [
                        'required' => "Kolom Kategori harus terisi!",
                        'is_unique' => "{value} sudah terdaftar!"
                    ],
                ],
            ];
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validator->getErrors()]);
            } else {
                $save = $this->categories_model->save([
                    'id_kategori' => $id,
                    'kategori' => $this->request->getPost('kategori'),
                ]);
                if ($save) {
                    return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => "Berhasil Mengedit kategori!"]);
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => "Gagal Mengedit kategori!"]);
                }
            }
        }
    }

    public function delete_category()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id_kategori  = $request->getVar('id_kategori');
            $sub_categories = $this->sub_catergories_modal->where('id_kategori', $id_kategori)->findAll();
            if (count($sub_categories)) {
                $msg =  "Ada (" . count($sub_categories) . ") Kategori berelasi pada Sub Kategori ini! Tidak dapat menghapus Kategori!";
                return $this->response->setJSON(['status' => 0, 'msg' => $msg]);
            } else {
                $delete = $this->categories_model->where('id_kategori', $id_kategori)->delete();
                if ($delete) {
                    return $this->response->setJSON(['status' => 1, 'msg' => "Berhasil menghapus kategori!"]);
                } else {
                    return $this->response->setJSON(['status' => 0, 'msg' => "Gagal menghapus kategori!"]);
                }
            }
        }
    }

    public function reorder_categories()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $positions = $request->getVar('positions');
            foreach ($positions as $position) {
                $index = $position[0];
                $new_posisition = $position[1];
                $this->categories_model->where('id_kategori', $index)
                    ->set(['ordering' => $new_posisition])
                    ->update();
            }
            return $this->response->setJSON(['status' => 1, 'msg' => "Berhasil merubah urutan kategori!"]);
        }
    }

    public function get_parent_category()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id_kategori = $request->getVar('id_kategori');
            $options = '<option value="0">--Piih Kategori--</option>';
            $parent_kategori =  $this->categories_model->findAll();

            if (count($parent_kategori)) {
                $added_options = '';
                foreach ($parent_kategori as $kategori) {
                    $is_selected = $kategori['id_kategori'] === $id_kategori ? 'selected' : '';
                    $added_options .= '<option value="' . $kategori['id_kategori'] . '" ' . $is_selected . '>' . $kategori['kategori'] . '</option>';
                }
                $options = $options . $added_options;
                return $this->response->setJSON(['status' => 1, 'data' => $options]);
            } else {
                return $this->response->setJSON(['status' => 1, 'data' => $options]);
            }
        }
    }

    public function sub_kategori_submit()
    {
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        if ($request->isAJAX()) {
            $rules = [
                'sub_kategori' => [
                    'rules' => "required|is_unique[sub_categories.sub_kategori]",
                    'errors' => [
                        'required' => "Kolom Sub Kategori harus terisi!",
                        'is_unique' => "{value} Sudah terdaftar!"
                    ],
                ],
            ];
            if (!$this->validate($rules)) {
                $validationErrors = $validation->getErrors();
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $validationErrors]);
            } else {
                $sub_category = $request->getVar('sub_kategori');
                $sub_category_slug = SlugService::model(SubCategoriesModel::class)->make($sub_category);
                $save =  $this->sub_catergories_modal->save([
                    'sub_kategori' => $sub_category,
                    'slug' => $sub_category_slug,
                    'id_kategori' => $request->getVar('id_kategori'),
                    'description' => $request->getVar('description')
                ]);

                if ($save) {
                    return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Berhasil menambahkan sub kategori!']);
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Gagal Saat menyimpan Sub Kategori!']);
                }
            }
        }
    }

    public function get_sub_category()
    {
        $dbDetails = array(
            "host" => $this->db->hostname,
            "user" => $this->db->username,
            "pass" => $this->db->password,
            "db" => $this->db->database
        );

        $table = "sub_categories";
        $primaryKey = "id_sub";
        $columns = array(
            array(
                "db" => "id_sub",
                "dt" => 0
            ),
            array(
                "db" => "sub_kategori",
                "dt" => 1
            ),
            array(
                "db" => "id_sub",
                "dt" => 2,
                "formatter" => function ($d, $row) {
                    $id_kategori = $this->sub_catergories_modal->where('id_sub', $row['id_sub'])->first();
                    $parent_name = " - ";
                    if ($id_kategori['id_kategori'] != 0) {
                        $get_value = $this->categories_model->where('id_kategori', $id_kategori['id_kategori'])->first();
                        $parent_name = $get_value['kategori'];
                    }
                    return $parent_name;
                }
            ),
            array(
                "db" => "id_kategori",
                "dt" => 3,
                "formatter" => function ($d, $row) {
                    $posts = $this->posts_model->where(['id_kategori' => $row['id_kategori']])->findAll();
                    return count($posts);
                }
            ),
            array(
                "db" => "id_sub",
                "dt" => 4,
                "formatter" => function ($d, $row) {
                    return "<div class='btn-group row col'> 
                    <button class='btn btn-sm btn-warning  editSubCategoryBtn' data-id='" . $row['id_sub'] . "'>Edit</button>
                    <button class='btn btn-sm btn-danger deleteSubCategoriBtn' data-id='" . $row['id_sub'] . "'>Delete</button>   
                    </div>";
                }
            ),
            array(
                "db" => "ordering",
                "dt" => 5,
            ),
        );
        return json_encode(
            SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function getSubCategory()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id_sub = $request->getVar('id_sub');
            $data = $this->sub_catergories_modal->where('id_sub', $id_sub)->first();
            return $this->response->setJSON(['data' => $data]);
        }
    }

    public function sub_edit_sub_category()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id_sub = $request->getVar('id_sub');
            $rules = [
                'sub_kategori' => [
                    'rules' => 'required|is_unique[sub_categories.sub_kategori,id_sub,' . $id_sub . ']',
                    'errors' => [
                        'required' => "Kolom Sub Kategori harus terisi!"
                    ],
                ],
            ];
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validator->getErrors()]);
            } else {
                $sub_category = $request->getVar('sub_kategori');
                $sub_category_slug = SlugService::model(SubCategoriesModel::class)->make($sub_category);
                $edit_save = $this->sub_catergories_modal->where('id_sub', $id_sub)
                    ->set([
                        'sub_kategori' => $request->getVar('sub_kategori'),
                        'slug' => $sub_category_slug,
                        'id_kategori' => $request->getVar('id_kategori'),
                        'description' => $request->getVar('description')
                    ])
                    ->update();
                if ($edit_save) {
                    return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' =>  "Berhasil Mengedit Sub Kategori!"]);
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' =>  "Gagal Mengedit Sub Kategori!"]);
                }
            }
        }
    }

    public function delete_sub_category()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id_sub = $request->getVar('id_sub');
            $sub_categories = $this->sub_catergories_modal->where('id_sub', $id_sub)->first();
            $sub_categories_delete = $this->posts_model->where('id_kategori', $sub_categories['id_kategori'])->find();
            if (count($sub_categories_delete)) {
                $msg =  "Ada (" . count($sub_categories_delete) . ") Postingan yang sudah ada, tidak dapat menghapus Sub Kategori!";
                return $this->response->setJSON(['status' => 0, 'msg' => $msg]);
            } else {
                $delete_sub_kategori = $this->sub_catergories_modal->where('id_sub', $id_sub)->delete();
                if ($delete_sub_kategori) {
                    return $this->response->setJSON(['status' => 1, 'msg' => "Berhasil Menghapus Sub Kategori!"]);
                } else {
                    return $this->response->setJSON(['status' => 0, 'msg' => "Gagal Menghapus Sub Kategori!"]);
                }
            }
        }
    }

    public function reoder_sub_categories()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $positions = $request->getVar('positions');
            foreach ($positions as $position) {
                $index = $position[0];
                $new_posisition = $position[1];
                $update = $this->sub_catergories_modal->where('id_sub', $index)
                    ->set(['ordering' => $new_posisition])
                    ->update();
                if ($update) {
                    return $this->response->setJSON(['status' => 1, 'msg' => "Posisi Sub Kategori berhasil diubah!"]);
                } else {
                    return $this->response->setJSON(['status' => 0, 'msg' => "Posisi Sub Kategori Gagal diubah!"]);
                }
            }
        }
    }

    public function new_posts()
    {
        $data = [
            'title' => "Tambah Postingan Baru | Blog App",
            'categories' => $this->categories_model->findAll(),
        ];
        return view('Admin/new_posts/index', $data);
    }

    public function submit_posts()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $rules = [
                'post_title' => [
                    'rules' => "required|is_unique[posts.post_title]",
                    'errors' => [
                        'required' => "Kolom Judul Postingan harus terisi!",
                        'is_unique' => "{value} Sudah terdaftar!"
                    ],
                ],
                'content' => [
                    'rules' => "required|min_length[30]",
                    'errors' => [
                        'required' => "Kolom Konten harus terisi!",
                        'min_length' => "Postingan Konten harus memiliki minimal 30 Karakter!"
                    ],
                ],
                'id_kategori' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => "Kolom Kategori harus terisi!"
                    ],
                ],
                'featured_image' => [
                    'rules' => "uploaded[featured_image]|is_image[featured_image]|max_size[featured_image,2048]",
                    'errors' => [
                        'uploaded' => "Posting Gambar harus terisi!",
                        'is_image' => "Pilih sebuah file type image!",
                        'max_size' => "Ukuran gambar max 2Mb!"
                    ],
                ],
                'meta_keywords' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => "Kolom Postingan Kata Kunci Meta harus terisi!"
                    ],
                ],
                'meta_description' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => "Kolom Posting Desktipsi Meta harus terisi!"
                    ],
                ],
            ];
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validator->getErrors()]);
            } else {
                $path = 'frontend/images/posts_images/';
                $file = $request->getFile('featured_image');
                $filename = $file->getRandomName();

                if (!is_dir($path)) mkdir($path, 0777, true);

                if ($file->move($path, $filename)) {
                    \Config\Services::image()
                        ->withFile($path . $filename)
                        ->fit(150, 150, 'center')
                        ->save($path . 'thumb_' . $filename);

                    // untuk meresize gambar
                    \Config\Services::image()
                        ->withFile($path . $filename)
                        ->resize(450, 300, true)
                        ->save($path . 'resized_' . $filename);

                    $data = [
                        'id_author' => get_user_session()['id_user'],
                        'id_kategori' => $request->getPost('id_kategori'),
                        'post_title' => $request->getPost('post_title'),
                        'slug' => SlugService::model(PostsModel::class)->make($request->getPost('post_title')),
                        'content' => $request->getPost('content'),
                        'featured_image' => $filename,
                        'tags' => $request->getPost('tags'),
                        'meta_keywords' => $request->getPost('meta_keywords'),
                        'meta_description' => $request->getPost('meta_description'),
                        'visibility' => $request->getPost('visibility'),
                    ];
                    $save = $this->posts_model->save($data);
                    $last_id = $this->posts_model->getInsertID();
                    if ($save) {
                        return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => "Berhasil Membuat postingan baru!"]);
                    } else {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => "Gagal Membuat postingan baru!"]);
                    }
                } else {
                    return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => "Gagal Saat mengupload Gambar!"]);
                }
            }
        }
    }

    public function all_posts()
    {
        $data = [
            'title' => "Semua Postingan | Blog App"
        ];

        return view('Admin/all_post/index', $data);
    }

    public function get_posts()
    {
        $db_details = [
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database
        ];
        $table = 'posts';
        $id_posts = 'id_posts';
        $columns = array(
            array(
                "db" => "id_posts",
                "dt" => 0,
            ),
            array(
                'db' => "id_posts",
                "dt" => 1,
                'formatter' => function ($d, $row) {
                    $image = $this->posts_model->where('id_posts', $row['id_posts'])->first();
                    return "<img class='img-thumbnail' src='" . base_url("frontend/images/posts_images/thumb_$image[featured_image]") . "' style='max-width : 70px;'>";
                }
            ),
            array(
                "db" => "post_title",
                'dt' => 2
            ),
            array(
                "db" => "id_posts",
                "dt" => 3,
                'formatter' => function ($d, $row) {
                    $category_id = $this->posts_model->where('id_posts', $row['id_posts'])->first();
                    $category = $this->categories_model->where('id_kategori', $category_id['id_kategori'])->first();
                    return $category['kategori'];
                }
            ),
            array(
                "db" => "id_posts",
                "dt" => 4,
                'formatter' => function ($d, $row) {
                    $visibilty = $this->posts_model->where('id_posts', $row['id_posts'])->first();
                    return $visibilty['visibility'] == 1 ? 'Public' : 'Private';
                }
            ),

            array(
                "db" => "id_posts",
                "dt" => 5,
                'formatter' => function ($d, $row) {
                    return "<a class='btn btn-sm btn-warning' href='" . base_url('admin/posts/edit_posts/' . $row['id_posts']) . "'><i class='fas fa fa-edit'></i></a>
                    <a class='btn btn-sm btn-danger btnDelete'  data-id='" . $row['id_posts'] . "' href='" . base_url('admin/posts/delete_posts/' . $row['id_posts']) . "'><i class='fas fa fa-trash'></i></a>  ";
                }
            ),

        );
        return json_encode(
            SSP::simple($_GET, $db_details, $table, $id_posts, $columns)
        );
    }

    public function edit_posts($id)
    {
        $data = [

            'title' => 'Edit Postingan | Blog App',
            'categories' => $this->categories_model->findAll(),
            'data' => $this->posts_model->asObject()->find($id)
        ];
        return view('Admin/all_post/edit_post', $data);
    }

    public function submit_edit_posts()
    {
        $request = \Config\Services::request();
        if ($request->isAJAX()) {
            $id_posts = $request->getVar('id_posts');
            $file = $request->getFile('featured_image');

            if ($file->getError() == 4) {
                $rules = [
                    'post_title' => [
                        'rules' => 'required|is_unique[posts.post_title,id_posts,' . $id_posts . ']',
                        'errors' => [
                            'required' => "Kolom Judul Postingan harus terisi!",
                            'is_unique' => "{value} Sudah terdaftar!"
                        ],
                    ],
                    'content' => [
                        'rules' => 'required|min_length[20]',
                        'errors' => [
                            'required' => "Kolom Konten Postingan harus terisi!",
                            'min_length' => "Karakter Panjang Min 20!"
                        ],
                    ],
                ];
            } else {
                $rules = [
                    'post_title' => [
                        'rules' => 'required|is_unique[posts.post_title,id_posts,' . $id_posts . ']',
                        'errors' => [
                            'required' => "Kolom Judul Postingan harus terisi!",
                            'is_unique' => "{value} Sudah terdaftar!"
                        ],
                    ],
                    'content' => [
                        'rules' => 'required|min_length[20]',
                        'errors' => [
                            'required' => "Kolom Konten Postingan harus terisi!",
                            'min_length' => "Karakter Panjang Min 20!"
                        ],
                    ],
                    'featured_image' => [
                        'rules' => 'uploaded[featured_image]|is_image[featured_image]|max_size[featured_image,2048]',
                        'errors' => [
                            'required' => "Gambar Postingan harus terisi!",
                            'is_image' => "feature_image bukan file unggahan yang valid.",
                            'max_size' => "Gambar Postingan max ukuran 2Mb!"
                        ],
                    ],
                ];
            }

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validator->getErrors()]);
            } else {
                $path = 'frontend/images/posts_images/';
                $filename = $file->getRandomName();
                $old_image = $this->posts_model->asObject()->find($id_posts)->featured_image;
                if (!$file->getError() == 4) {
                    if ($file->move($path, $filename)) {
                        \Config\Services::image()
                            ->withFile($path . $filename)
                            ->fit(150, 150, 'center')
                            ->save($path . 'thumb_' . $filename);
                        \Config\Services::image()
                            ->withFile($path . $filename)
                            ->resize(450, 300, true, 'width')
                            ->save($path . 'resized_' . $filename);

                        if ($old_image != null && file_exists($path . $old_image)) {
                            unlink($path . $old_image);
                        }

                        if (file_exists($path . 'thumb_' . $old_image)) {
                            unlink($path . 'thumb_' . $old_image);
                        }

                        if (file_exists($path . 'resized_' . $old_image)) {
                            unlink($path . 'resized_' . $old_image);
                        }

                        $data = [
                            'id_posts' => $id_posts,
                            'id_author' => get_user_session()['id_user'],
                            'id_kategori' => $request->getVar('id_kategori'),
                            'post_title' => $request->getVar('post_title'),
                            'slug' => SlugService::model(PostsModel::class)->make($request->getVar('post_title')),
                            'content' => $request->getVar('content'),
                            'featured_image' => $filename,
                            'tags' => $request->getVar('tags'),
                            'meta_keywords' => $request->getVar('meta_keywords'),
                            'meta_description' => $request->getVar('meta_description'),
                            'visibility' => $request->getVar('visibility'),
                        ];
                        $update = $this->posts_model->save($data);
                        if ($update) {
                            return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Berhasil Mengedit Postingan']);
                        } else {
                            return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Gagal Mengedit Postingan']);
                        }
                    }
                } else {
                    $data = [
                        'id_posts' => $id_posts,
                        'id_author' => get_user_session()['id_user'],
                        'id_kategori' => $request->getVar('id_kategori'),
                        'post_title' => $request->getVar('post_title'),
                        'slug' => SlugService::model(PostsModel::class)->make($request->getVar('post_title')),
                        'content' => $request->getVar('content'),
                        'tags' => $request->getVar('tags'),
                        'meta_keywords' => $request->getVar('meta_keywords'),
                        'meta_description' => $request->getVar('meta_description'),
                        'visibility' => $request->getVar('visibility'),
                    ];
                    $update = $this->posts_model->save($data);
                    if ($update) {
                        return $this->response->setJSON(['status' => 1, 'token' => csrf_hash(), 'msg' => 'Berhasil Mengedit Postingan']);
                    } else {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'msg' => 'Gagal Mengedit Postingan']);
                    }
                }
            }
        }
    }

    public function delete_posts()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $id_posts = $request->getVar('id_posts');
            $path = 'frontend/images/posts_images/';
            $old_image = $this->posts_model->asObject()->find($id_posts)->featured_image;

            $delete_posts = $this->posts_model->delete($id_posts);
            if ($delete_posts) {
                if ($old_image != null && file_exists($path . $old_image)) {
                    unlink($path . $old_image);
                }

                if (file_exists($path . 'thumb_' . $old_image)) {
                    unlink($path . 'thumb_' . $old_image);
                }

                if (file_exists($path . 'resized_' . $old_image)) {
                    unlink($path . 'resized_' . $old_image);
                }

                return $this->response->setJSON(['status' => 1, 'msg' => "Postingan berhasil di hapus!"]);
            } else {
                return $this->response->setJSON(['status' => 0, 'msg' => "Gagal Saat Menghapus postingan"]);
            }
        }
    }
}
