<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Libraries\Hash;
use App\Libraries\CIAuth;
use App\Models\PasswordTokensModel;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form'];
    protected $user_model;
    protected $password_tokens_model;

    public function __construct()
    {
        helper(['url', 'form', 'CIMailer']);
        $this->user_model = new UsersModel();
        $this->password_tokens_model = new PasswordTokensModel();
    }

    public function index()
    {
        $data = [
            'title' => "Auth | Blog App"
        ];
        return view('auth/index', $data);
    }

    public function register()
    {
        $data = [
            'title' => "Auth | Blog App"
        ];
        return view('auth/register', $data);
    }

    public function submit()
    {
        $is_registrasi = $this->request->getPost('registrasi');

        if (!$is_registrasi) {
            $field_type_check = filter_var($this->request->getPost('login_value'), FILTER_VALIDATE_EMAIL)  ? 'email' : 'password';
            if ($field_type_check == 'email') {
                $rules_fields = 'required|trim|valid_email|is_not_unique[users.email]';
            } else {
                $rules_fields = 'required|trim|is_not_unique[users.username]';
            }

            $rules = [
                'login_value' => [
                    'rules' => $rules_fields,
                    'errors' => [
                        'required' => "Kolom Username or Email harus terisi!",
                        'valid_email' => "Email harus valid!",
                        'is_not_unique' => "Username {value} Tidak terdaftar!"
                    ],
                ],
                'password' => [
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => "Kolom Password harus terisi!"
                    ],
                ]
            ];
        } else {
            $rules = [
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Nama harus terisi!"
                    ],
                ],
                'username' => [
                    'rules' => 'required|is_unique[users.username]|trim',
                    'errors' => [
                        'required' => "Kolom username harus terisi!",
                        'is_unique' => "Username sudah terdaftar!"
                    ],
                ],
                'email' => [
                    'rules' => 'required|is_unique[users.email]|trim|valid_email',
                    'errors' => [
                        'required' => "Kolom Email harus terisi!",
                        'is_unique' => "Email sudah terdaftar!",
                        'valid_email' => "Email harus valid!",
                        'is_not_unique' => "Email yang anda masukan tidak terdaftar"
                    ],
                ],
                'password' => [
                    'rules' => 'required|trim|matches[password2]|min_length[3]',
                    'errors' => [
                        'required' => "Kolom password harus terisi!",
                        'matches' => "Password harus sama dengan Konfirmasi Password!",
                        'min_length' => "Password min 3 Karakter"
                    ],
                ],
                'password2' => [
                    'rules' => 'required|trim|matches[password]|min_length[3]',
                    'errors' => [
                        'required' => "Kolom password harus terisi!",
                        'matches' => "Konfirmasi Password harus sama dengan Password!",
                        'min_length' => "Konfirmasi Password min 3 Karakter"
                    ],
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        } else {
            if ($is_registrasi) {
                $data = [
                    ''
                ];
            } else {
                $userdata  = $this->user_model->get_by($this->request->getPost('login_value'));
                if (!empty($userdata['email'])) {
                    if (Hash::check_password($this->request->getPost('password'), $userdata['password'])) {
                        $data = [
                            'id_role' => $userdata['id_role'],
                            'id_user' => $userdata['id_user'],
                            'email' => $userdata['email'],
                        ];
                        if ($userdata['id_role'] == 1) {
                            CIAuth::set_login_session($data);
                            return redirect()->to(base_url('admin'));
                        } else {
                            CIAuth::set_login_session($data);
                            return redirect()->to(base_url('user'));
                        }
                    } else {
                        session()->setFlashdata('fail', 'Password anda masukan salah!');
                        return redirect()->to(base_url('admin/login'));
                    }
                } else {
                    session()->setFlashdata('fail', 'Email atau Username yang anda masukan salah!');
                    return redirect()->to(base_url('admin/login'));
                }
            }
        }
    }

    public function forgot_password()
    {
        $data = [
            'title' => "Lupa Password | Blog App"
        ];

        return view('auth/forgot_password', $data);
    }

    public function send_password()
    {
        $rules = [
            'email' => [
                'rules' => 'required|trim|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Kolom Email harus terisi!',
                    'valid_email' => "Email harus valid!",
                    'is_not_unique' => "Email Tidak terdaftar!"
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        } else {
            $user_info = $this->user_model->where('email', $this->request->getPost('email'))->first();

            // generate tokens
            $token  = bin2hex(openssl_random_pseudo_bytes(65));

            // get reset password tokens
            $is_old_token_exist = $this->password_tokens_model->where('email', $user_info['email'])->first();

            if ($is_old_token_exist) {
                // update existing token
                $this->password_tokens_model->where('email', $user_info['email'])
                    ->set(['token' => $token, 'created_at' => Carbon::now()])
                    ->update();
            } else {
                $this->password_tokens_model->insert([
                    'email' => $user_info['email'],
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]);
            }

            // create action link

            $action_link = base_url('admin/reset_password/' . $token);

            $mail_data = [
                'action_link' => $action_link,
                'user' => $user_info,
            ];

            $view = \Config\Services::renderer();
            $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/forgot_email');

            $mail_config = [
                'mail_from_email' => 'blog_app@blog.test',
                'mail_from_name' => 'BLOG_APP',
                'mail_recipient_email' => $user_info['email'],
                'mail_recipient_name' => $user_info['name'],
                'mail_subject' => "Reset Password",
                'mail_body' => $mail_body,
            ];

            // send email
            if (send_email($mail_config)) {
                return redirect()->to(base_url('admin/forgot_password'))->with('success', 'Sistem telah mengirim Link reset password!');
            } else {
                return redirect()->to(base_url('admin/forgot_password'))->with('fail', 'Gagal mengirim link reset password');
            }
        }
    }

    public function reset_password($token)
    {
        $check_token = $this->password_tokens_model->where('token', $token)->first();
        if (!$check_token) {
            return redirect()->to(base_url('admin/forgot_password'))->with('fail', 'token tidak valid, minta tautan setel ulang kata sandi lainnya.');
        } else {
            // check time password token
            $diffmins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token['created_at'])->diffInMinutes(Carbon::now());
            if ($diffmins > 15) {
                return redirect()->to(base_url('admin/forgot_password'))->with('fail', 'Token expired, minta tautan setel ulang kata sandi lainnya.');
            } else {
                $data = [
                    'title' => "Reset Password | Blog App",
                    'token' => $token
                ];
                return view('auth/reset_password', $data);
            }
        }
    }

    public function reset_password_submit($token)
    {
        // buat validasi custom dengan php spark make:validation
        // setelah itu, masuk ke valiation file yang udah dibuat
        // setelah itu, masuk ke config validaation, atur validasi rulesnya
        $rules = [
            'password' => [
                'rules' => 'required|min_length[3]|max_length[45]|is_password_strong[password]|matches[password2]',
                'errors' => [
                    'required' => "Kolom Password harus terisi!",
                    'min_length' => "Panjang password min 3 karakter!",
                    'max_length' => "panjang Password max 45 karakter!",
                    'is_password_strong' => 'Password harus berisi minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter khusus!',
                    'matches' => "Password harus sama dengan konfirmasi password!",
                ]
            ],
            'password2' => [
                'rules' => 'required|min_length[3]|max_length[45]|is_password_strong[password2]|matches[password]',
                'errors' => [
                    'required' => "Kolom Konfirmasi Password harus terisi!",
                    'min_length' => "Panjang Konfirmasi Password min 3 karakter!",
                    'max_length' => "panjang Konfirmasi Password max 45 karakter!",
                    'is_password_strong' => 'Konfirmasi Password harus berisi minimal 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter khusus!',
                    'matches' => "Konfirmasi Password harus sama dengan password!",
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        } else {
            $get_token = $this->password_tokens_model->where('token', $token)->first();
            $user_data = $this->user_model->where('email', $get_token['email'])->first();

            if (!$get_token) {
                return redirect()->back()->with('fail', 'Token tidak valid!');
            } else {
                // update admin password in DB
                $this->user_model->where('email', $user_data['email'])
                    ->set(['password' => Hash::make($this->request->getPost('password'))])
                    ->update();

                // send notification to email
                $mail_data = [
                    'user' => $user_data,
                    'password' => $this->request->getPost('password')
                ];
                // membuat view notif
                $view = \Config\Services::renderer();
                $mail_body  = $view->setVar('mail_data', $mail_data)->render('email-templates/notification_email');
                $mail_config = [
                    'mail_from_email' => 'blog_app@blog.test',
                    'mail_from_name' => 'BLOG_APP',
                    'mail_recipient_email' => $user_data['email'],
                    'mail_recipient_name' => $user_data['name'],
                    'mail_subject' => "Pemberitahuan Reset Password",
                    'mail_body' => $mail_body,
                ];

                if (send_email($mail_config)) {
                    $this->password_tokens_model->where('email', $user_data['email'])
                        ->delete();
                    return redirect()->to(base_url('admin/forgot_password'))->with('success', 'Selesai!, Kata sandi Anda telah diubah!. Gunakan kata sandi baru untuk masuk ke sistem');
                } else {
                    return redirect()->back()->withInput()->with('fail', 'Sistem gagal merubah password baru!');
                }
            }
        }
    }

    public function logout()
    {
        $data = ['id_role', 'id_user', 'email'];
        CIAuth::set_remove_login_session($data);
        return redirect()->to(base_url('admin/login'))->with('fail', 'Anda berhasil Logout!');
    }
}
