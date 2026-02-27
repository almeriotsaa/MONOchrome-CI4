<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }


    public function index()
    {
        $orders = $this->orderModel
            ->select('orders.*, users.name')
            ->join('users', 'users.user_id = orders.user_id')
            ->orderBy('order_date', 'DESC')
            ->findAll();

        return view('admin/orders', [
            'orders' => $orders
        ]);
    }


    public function detail($id)
    {
        $order = $this->orderModel
            ->select('orders.*, users.name, users.email')
            ->join('users', 'users.user_id = orders.user_id')
            ->where('orders.order_id', $id)
            ->first();

        $items = (new \App\Models\OrderItemModel())
            ->select('order_items.*, products.name_product, products.price')
            ->join('products', 'products.product_id = order_items.product_id')
            ->where('order_items.order_id', $id)
            ->findAll();

        return view('admin/detail', [
            'order' => $order,
            'items' => $items
        ]);
    }


    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');

        $this->orderModel->update($id, [
            'status' => $status
        ]);

        return redirect()->back()->with('success', 'Order status updated');
    }


    public function delete($id)
    {
        $this->orderModel->delete($id);

        return redirect()->to('/admin/orders')
            ->with('success', 'Order deleted successfully');
    }
}
