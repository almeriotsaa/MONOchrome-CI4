<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'payment_id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'order_id', 
        'method', 
        'amount', 
        'payment_date', 
        'status', 
        'created_at', 
        'updated_at'
    ];

    protected $useTimestamps = true; 
}