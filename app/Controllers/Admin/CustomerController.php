<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class CustomerController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }


    public function index()
    {
        $customers = $this->userModel
            ->where('role', 'customer')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/customers', [
            'customers' => $customers
        ]);
    }

    
    public function detail($id)
    {
        $customer = $this->userModel
            ->where('role', 'customer')
            ->find($id);

        if (!$customer) {
            return redirect()->to('/admin/customers')
                             ->with('error', 'Customer not found');
        }

        return view('admin/customers/detail', [
            'customer' => $customer
        ]);
    }


    public function delete($id)
    {
        $customer = $this->userModel->find($id);

        if ($customer && $customer['role'] === 'customer') {
            $this->userModel->delete($id);
        }

        return redirect()->to('/admin/customers')
                         ->with('success', 'Customer deleted successfully');
    }
}