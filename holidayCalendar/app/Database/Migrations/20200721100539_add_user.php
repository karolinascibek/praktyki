<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUser extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id'          => [
                                'type'           => 'INT',
                                'unsigned'       => true,
                                'auto_increment' => true,
                        ],
                        'name'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '255',
                        ],
                        'last_name'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '255',
                        ],
                        'password'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '255',
                        ],
                        'email'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '255',
                        ],
                        'firm'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '255',
                        ],
                        'nip'       => [
                                'type'           => 'int',
                                'constraint'     => '10',
                        ],
                        'user_data_created'       => [
                                'type'           => 'DATETIME',
                        ],
                        'user_data_updated'       => [
                                'type'           => 'DATETIME',
                        ],
                ]);
                $this->forge->addKey('id', true);
                $this->forge->createTable('users');
        }

        public function down()
        {
                $this->forge->dropTable('users');
        }
}