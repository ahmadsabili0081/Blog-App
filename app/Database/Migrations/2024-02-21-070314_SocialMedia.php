<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SocialMedia extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_social_media' => [
                'type' => "INT",
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'youtube_url' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
            'facebook_url' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
            'github_url' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
            'twitter_url' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
            'linkedin_url' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
            'instagram_url' => [
                'type' => 'VARCHAR',
                'constraint' => 128,
                'null' => true
            ],
        ]);
        $this->forge->addKey('id_social_media', true);
        $this->forge->createTable('social_media');
    }

    public function down()
    {
        $this->forge->dropTable('social_media');
    }
}
