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
            $json = $this->request->getJSON();
            
            if (!$json) {
                return $this->response->setJSON(['success' => false, 'message' => 'No data received']);
            }

            $productId = $json->product_id ?? null;
            $quantity  = $json->quantity ?? 1;
            $size      = $json->size ?? null;
            
            if (!$productId || !$size) {
                return $this->response->setJSON(['success' => false, 'message' => 'Product ID or Size is missing']);
            }

            $product = $this->productModel->find($productId);
            
            if (!$product) {
                return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
            }
            
            $cart = session()->get('cart') ?? [];
            
            
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
                    'id'    => $productId,
                    'name'  => $product['name_product'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'size'  => $size,
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
        // Pastikan helper cart_total() ada di app/Helpers/cart_helper.php
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
            $json = $this->request->getJSON();
            $itemId = $json->item_id ?? null;
            $quantity = $json->quantity ?? 1;
            
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
        try {
            if ($this->request->isAJAX()) {
                $json = $this->request->getJSON();
                
                if (!$json) {
                    return $this->response->setJSON(['success' => false, 'message' => 'JSON tidak terbaca']);
                }

                $productId = $json->product_id ?? null;
                $size      = $json->size ?? null;

                if (!$productId || !$size) {
                    return $this->response->setJSON(['success' => false, 'message' => 'ID atau Size kosong']);
                }

                $cart = session()->get('cart') ?? [];
                $newCart = [];

                foreach ($cart as $item) {
                    // Logika: Masukkan ke array baru jika BUKAN barang yang mau dihapus
                    if (!($item['id'] == $productId && $item['size'] == $size)) {
                        $newCart[] = $item;
                    }
                }

                session()->set('cart', $newCart);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Berhasil dihapus',
                    'total'   => cart_total(),
                    'count'   => count($newCart)
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }
}