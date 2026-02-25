<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentDetailsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'detail_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'payment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'provider' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'account_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status_message' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('detail_id', true);
        $this->forge->addForeignKey('payment_id', 'payments', 'payment_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('payment_details');
    }

    public function down()
    {
        $this->forge->dropTable('payment_details');
    }
}