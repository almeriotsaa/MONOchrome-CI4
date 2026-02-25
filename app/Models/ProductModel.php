<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'category_id', 'image', 'name_product', 
        'description', 'price', 'stock', 'size'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getNewArrivals($limit = 4)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    public function getWithCategory()
    {
        return $this->select('products.*, categories.category_gender, categories.category_type')
                    ->join('categories', 'categories.category_id = products.category_id')
                    ->findAll();
    }

    public function filterByCategory($gender = null, $type = null)
    {
        $builder = $this->select('products.*, categories.category_gender, categories.category_type')
                       ->join('categories', 'categories.category_id = products.category_id');
        
        if ($gender) {
            $builder->where('categories.category_gender', $gender);
        }
        
        if ($type) {
            $builder->where('categories.category_type', $type);
        }
        
        return $builder->findAll();
    }
}