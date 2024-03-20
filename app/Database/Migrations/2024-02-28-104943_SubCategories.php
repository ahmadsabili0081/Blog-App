<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sub' => [
                'type' => "INT",
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sub_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ordering' => [
                'type' => "INT",
                "constraint" => 11,
                'default' => 10000
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id_sub');
        $this->forge->createTable('sub_categories');
    }

    public function down()
    {
        $this->forge->dropTable('sub_categories');
    }
}
