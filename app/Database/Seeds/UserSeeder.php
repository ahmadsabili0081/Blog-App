<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => "Ahmad Sabili alghifari",
            'username' => "ahmdsblii",
            'email' => 'ahmadsabili0081@gmail.com',
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'picture' => 'default.jpg'
        ];
        $this->db->table('users')->insert($data);
    }
}
