<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmployee extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_employee'          => [
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
                        'employee_data_created'       => [
                                'type'           => 'DATETIME',
                        ],
                        'employee_data_updated'       => [
                                'type'           => 'DATETIME',
                        ],
                ]);
                $this->forge->addKey('id_employee', true);
                $this->forge->createTable('employees');
        }

        public function down()
        {
                $this->forge->dropTable('employees');
        }
}