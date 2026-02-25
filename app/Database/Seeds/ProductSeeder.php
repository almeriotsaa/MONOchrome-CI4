<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_id' => 1,
                'image' => 'product-1.jpg',
                'name_product' => 'Men Casual T-Shirt',
                'description' => 'Comfortable cotton t-shirt for men',
                'price' => 250000,
                'stock' => 50,
                'size' => 'S,M,L,XL',
            ],
            [
                'category_id' => 2,
                'image' => 'product-2.jpg',
                'name_product' => 'Men Jeans Pants',
                'description' => 'Classic blue jeans for men',
                'price' => 350000,
                'stock' => 30,
                'size' => '30,32,34,36',
            ],
            [
                'category_id' => 3,
                'image' => 'product-3.jpg',
                'name_product' => 'Women Summer Dress',
                'description' => 'Beautiful floral dress for summer',
                'price' => 450000,
                'stock' => 20,
                'size' => 'S,M,L',
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}