<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHoliday extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id'          => [
                                'type'           => 'INT',
                                'unsigned'       => true,
                                'auto_increment' => true,
                        ],
                        'id_calendar'       => [
                                'type'           => 'INT',
                        ],
                        'id_employee'       => [
                                'type'           => 'INT',

                        ],
                        'data'       => [
                                'type'           => 'DATE',
                        ],

                ]);
                $this->forge->addKey('id', true);
                $this->forge->createTable('holiday');
        }

        public function down()
        {
                $this->forge->dropTable('holiday');
        }
}