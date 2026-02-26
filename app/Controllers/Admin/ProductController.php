<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data['products'] = $this->productModel
            ->select('products.*, categories.category_type')
            ->join('categories', 'categories.category_id = products.category_id', 'left')
            ->findAll();

        return view('admin/products', $data);
    }

    public function create()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/create', $data);
    }

    public function store()
    {
        $file = $this->request->getFile('image');
        $imageName = '';

        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/', $imageName);
        }

        $this->productModel->save([
            'category_id'  => $this->request->getPost('category_id'),
            'name_product' => $this->request->getPost('name_product'),
            'description'  => $this->request->getPost('description'),
            'price'        => $this->request->getPost('price'),
            'stock'        => $this->request->getPost('stock'),
            'size'         => $this->request->getPost('size'),
            'image'        => $imageName,
        ]);

        return redirect()->to('/admin/products');
    }

    public function edit($id)
    {
        $data['product']    = $this->productModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();

        return view('admin/edit', $data);
    }

    public function update($id)
    {
        $file = $this->request->getFile('image');
        $imageName = '';

        if ($file && $file->isValid()) {
            $imageName = $file->getRandomName();
            $file->move('uploads/', $imageName);
        }

        $this->productModel->update($id, [
            'category_id'  => $this->request->getPost('category_id'),
            'name_product' => $this->request->getPost('name_product'),
            'description'  => $this->request->getPost('description'),
            'price'        => $this->request->getPost('price'),
            'stock'        => $this->request->getPost('stock'),
            'size'         => $this->request->getPost('size'),
            'image'        => $imageName,
        ]);

        return redirect()->to('/admin/products');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}