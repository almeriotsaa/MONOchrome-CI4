<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => password_hash('customer123', PASSWORD_DEFAULT),
                'role' => 'customer',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}