<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $data['newArrivals'] = $productModel->getNewArrivals(4);
        
        return view('home', $data);
    }
}