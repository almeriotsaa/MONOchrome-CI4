<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id'; 
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    
    protected $allowedFields    = [
        'user_id', 
        'order_date', 
        'address', 
        'shipping', 
        'total', 
        'status', 
        'created_at', 
        'updated_at'
    ];

    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}