<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {

        $this->forge->addField(
            [
                    'id' => [
                        'type'           => 'INT',
                        'constraint'     => 150,
                        'unsigned'       => true,
                        'auto_increment' => true,
                    ],

                    'email' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 150,
                        'null' => false
                    ],
                    'firstName' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 150,
                        'null' => false
                    ],
                    'lastName' => [
                        'type'       => 'VARCHAR',
                        'constraint' => 150,
                        'null' => false
                    ],
                    'created_at' => [
                        'type' => 'VARCHAR',
                        'constraint' => 150,
                        'null' => false
                    ],
                    'updated_at' => [
                        'type' => 'VARCHAR',
                        'constraint' => 150,
                        'null' => true
                    ],
                    'deleted_at' => [
                        'type' => 'VARCHAR',
                        'constraint' => 150,
                        'null' => true
                    ]
                ]
        );
        $this->forge->addKey('id', true);
        $this->forge->createTable(
            'users',
            true,
        );
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
