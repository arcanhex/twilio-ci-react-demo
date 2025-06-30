<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MantTable extends Migration
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
			'fullName' => [
				'type' => 'VARCHAR',
				'constraint' => '128'
			],
			'phoneNumber' => [
				'type' => 'VARCHAR',
				'constraint' => '128'
			],
			'filterType' => [
				'type' => 'VARCHAR',
				'constraint' => '128'
			],
			'user_id' => [
				'type' => 'VARCHAR',
				'constraint' => '128'
			],
			'retired' => [
				'type' => 'VARCHAR',
				'constraint' => '128'
			],
			'isSent' => [
				'type'    => 'BOOLEAN',
				'null'    => false,
				'default' => false
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
		$this->forge->createTable('mant');
	}

	public function down()
	{
		$this->forge->dropTable('mant');
	}
}
