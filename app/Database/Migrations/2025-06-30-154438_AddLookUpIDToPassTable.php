<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLookUpIDToPassTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('passwords_twilio', [
            'lookUpID' => [
                'type' => 'TEXT'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('passwords_twilio', 'lookUpID');
    }
}
