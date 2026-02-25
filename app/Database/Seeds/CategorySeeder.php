<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_gender' => 'Men',
                'category_type' => 'Tops',
            ],
            [
                'category_gender' => 'Men',
                'category_type' => 'Outwear',
            ],
            [
                'category_gender' => 'Men',
                'category_type' => 'Bottom',
            ],
            [
                'category_gender' => 'Women',
                'category_type' => 'Tops',
            ],
            [
                'category_gender' => 'Women',
                'category_type' => 'Outwear',
            ],
            [
                'category_gender' => 'Women',
                'category_type' => 'Bottom',
            ],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}