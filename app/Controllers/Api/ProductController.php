<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;

class ProductController extends ResourceController
{
    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    public function index()
    {
        $products = $this->model->getWithCategory();
        return $this->respond($products);
    }

    public function show($id = null)
    {
        $product = $this->model->find($id);
        if ($product) {
            return $this->respond($product);
        }
        return $this->failNotFound('Product not found');
    }

    public function create()
    {
        $rules = [
            'category_id' => 'required|numeric',
            'name_product' => 'required|min_length[3]',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $data = $this->request->getJSON(true);
        if ($this->model->save($data)) {
            return $this->respondCreated($data, 'Product created successfully');
        }

        return $this->fail('Failed to create product');
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        $data['product_id'] = $id;

        if ($this->model->save($data)) {
            return $this->respondUpdated($data, 'Product updated successfully');
        }

        return $this->fail('Failed to update product');
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id], 'Product deleted successfully');
        }

        return $this->fail('Failed to delete product');
    }
}