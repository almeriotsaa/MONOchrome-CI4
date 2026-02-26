<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentDetailModel extends Model
{
    protected $table            = 'payment_details';
    protected $primaryKey       = 'detail_id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'payment_id', 
        'provider', 
        'account_number', 
        'status_message'
    ];

    protected $useTimestamps = false; 
}