<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCalendarEmployee extends Migration
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
                        'number_free_days'       => [
                                'type'           => 'INT',
                        ],
                        'days_used'       => [
                                'type'           => 'INT',
                        ],
                ]);
                $this->forge->addKey('id', true);
                $this->forge->createTable('calendar_employee');
        }

        public function down()
        {
                $this->forge->dropTable('calendar_employee');
        }
}