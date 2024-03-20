<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_posts' => [
                'type' => "INT",
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_author' => [
                'type' => "INT",
                'unsigned' => true,
                'constraint' => 11,
            ],
            'id_kategori' => [
                'type' => "INT",
                'unsigned' => true,
                'constraint' => 11,
            ],
            'post_title' => [
                'type' => "VARCHAR",
                'constraint' => 128,
            ],
            'slug' => [
                'type' => "VARCHAR",
                'constraint' => 128,
            ],
            'content' => [
                'type' => "TEXT",
                'null' => true,
            ],
            'featured_image' => [
                'type' => "VARCHAR",
                'constraint' => 255,
            ],
            'tags' => [
                'type' => "TEXT",
                'null' => true
            ],
            'meta_keywords' => [
                'type' => "TEXT",
                'null' => true
            ],
            'meta_description' => [
                'type' => "TEXT",
                'null' => true
            ],
            'visibility' => [
                'type' => "INT",
                'constraint' => 11,
                'default' => 1
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id_posts');
        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
