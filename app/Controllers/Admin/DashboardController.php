<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    protected $orderModel;
    protected $productModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new \App\Models\OrderModel();
        $this->productModel = new \App\Models\ProductModel();
        $this->userModel = new \App\Models\UserModel();

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        $data['totalOrders'] = $this->orderModel->countAll();
        $data['totalProducts'] = $this->productModel->countAll();
        $data['totalCustomers'] = $this->userModel->where('role', 'customer')->countAllResults();
        $data['recentOrders'] = $this->orderModel
            ->select('orders.*, users.name')
            ->join('users', 'users.user_id = orders.user_id')
            ->orderBy('orders.created_at', 'DESC')
            ->limit(5)
            ->find();

        return view('admin/dashboard', $data);
    }
}
