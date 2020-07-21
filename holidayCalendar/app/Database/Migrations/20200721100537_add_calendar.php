<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCalendar extends Migration
{

        public function up()
        {
                $this->forge->addField([
                        'id_calendar'          => [
                                'type'           => 'INT',
                                'unsigned'       => true,
                                'auto_increment' => true,
                        ],
                        'id_employer'          => [
                                'type'           => 'INT',
                        ],
                        'name'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '255',
                        ],
                        'code'       => [
                                'type'           => 'VARCHAR',
                                'constraint'     => '255',
                        ],
                        'year'       => [
                                'type'           => 'INT',
                        ],
                ]);
                $this->forge->addKey('id_calendar', true);
                $this->forge->createTable('calendar');
        }

        public function down()
        {
                $this->forge->dropTable('calendar');
        }
}