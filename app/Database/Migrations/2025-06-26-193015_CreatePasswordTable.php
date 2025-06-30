<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasswordTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'hashedPassword' => [
                'type' => 'TEXT'
            ],
            'attempts' => [
                'type' => 'INT'
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('passwords_twilio');
    }

    public function down()
    {
        $this->forge->dropTable('passwords_twilio');
    }
}
