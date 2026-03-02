<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class OrderController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $data['orders'] = $this->orderModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('customer/index', $data);
    }

    public function detail($id)
    {
        $userId = session()->get('user_id');

        $order = $this->orderModel
            ->where('order_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $db = \Config\Database::connect();

        $items = $db->table('order_items')
            ->select('order_items.*, products.name_product, products.price, products.image')
            ->join('products', 'products.product_id = order_items.product_id')
            ->where('order_items.order_id', $id)
            ->get()
            ->getResultArray();

        return view('customer/detail', [
            'order' => $order,
            'items' => $items
        ]);
    }
}
