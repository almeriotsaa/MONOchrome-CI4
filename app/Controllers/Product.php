<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $gender = $this->request->getGet('gender');
        $type = $this->request->getGet('type');
        
        $data['products'] = $this->productModel->filterByCategory($gender, $type);
        $data['categories'] = $this->categoryModel->findAll();
        $data['selectedGender'] = $gender;
        $data['selectedType'] = $type;
        
        return view('collection', $data);
    }

    public function detail($id)
    {
        $product = $this->productModel->select('products.*, categories.category_gender, categories.category_type')
                                      ->join('categories', 'categories.category_id = products.category_id', 'left')
                                      ->find($id);
        
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data['product'] = $product;
        $data['latestProducts'] = $this->productModel
                                      ->where('product_id !=', $id)
                                      ->orderBy('created_at', 'DESC')
                                      ->limit(4)
                                      ->find();
        
        return view('product_detail', $data);
    }
}