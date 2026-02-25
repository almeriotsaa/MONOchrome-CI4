<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Cart extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        helper(['cart']);
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $productId = $this->request->getJSON('product_id');
            $quantity = $this->request->getJSON('quantity') ?? 1;
            $size = $this->request->getJSON('size');
            
            $product = $this->productModel->find($productId);
            
            if (!$product) {
                return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
            }
            
            $cart = session()->get('cart') ?? [];
            
            // Check if product already in cart
            $found = false;
            foreach ($cart as &$item) {
                if ($item['id'] == $productId && $item['size'] == $size) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $cart[] = [
                    'id' => $productId,
                    'name' => $product['name_product'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'size' => $size,
                    'quantity' => $quantity
                ];
            }
            
            session()->set('cart', $cart);
            
            return $this->response->setJSON([
                'success' => true,
                'cart_count' => count($cart),
                'message' => 'Product added to cart'
            ]);
        }
        
        return redirect()->back();
    }

    public function get()
    {
        $cart = session()->get('cart') ?? [];
        $total = cart_total();
        
        return $this->response->setJSON([
            'items' => $cart,
            'total' => $total,
            'count' => count($cart)
        ]);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $itemId = $this->request->getJSON('item_id');
            $quantity = $this->request->getJSON('quantity');
            
            $cart = session()->get('cart') ?? [];
            
            foreach ($cart as &$item) {
                if ($item['id'] == $itemId) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            
            session()->set('cart', $cart);
            
            return $this->response->setJSON([
                'success' => true,
                'cart_count' => count($cart),
                'total' => cart_total()
            ]);
        }
    }

    public function remove()
    {
        if ($this->request->isAJAX()) {
            $itemId = $this->request->getJSON('item_id');
            
            $cart = session()->get('cart') ?? [];
            
            $cart = array_filter($cart, function($item) use ($itemId) {
                return $item['id'] != $itemId;
            });
            
            session()->set('cart', array_values($cart));
            
            return $this->response->setJSON([
                'success' => true,
                'cart_count' => count($cart),
                'total' => cart_total()
            ]);
        }
    }
}