<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Settingsblog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_setting' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'blog_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'blog_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'blog_no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 14,
                'null' => true
            ],
            'blog_meta_keywords' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'description_blog' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'blog_logo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'blog_favicon' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'created_at timestamp default current_timestamp',
            'update_at timestamp default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id_setting', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
