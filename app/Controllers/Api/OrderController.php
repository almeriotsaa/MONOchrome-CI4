<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class OrderController extends ResourceController
{
    protected $modelName = 'App\Models\OrderModel';
    protected $format    = 'json';

    
    public function index()
    {
        $orders = $this->model->findAll();

        return $this->respond([
            'status' => 200,
            'data'   => $orders
        ]);
    }

    
    public function show($id = null)
    {
        $order = $this->model->find($id);

        if (!$order) {
            return $this->failNotFound('Order tidak ditemukan');
        }

        return $this->respond([
            'status' => 200,
            'data'   => $order
        ]);
    }

    
    public function update($id = null)
    {
        $order = $this->model->find($id);

        if (!$order) {
            return $this->failNotFound('Order tidak ditemukan');
        }

        $data = $this->request->getRawInput();

        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Order berhasil diupdate'
        ]);
    }

    
    public function delete($id = null)
    {
        $order = $this->model->find($id);

        if (!$order) {
            return $this->failNotFound('Order tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Order berhasil dihapus'
        ]);
    }
}