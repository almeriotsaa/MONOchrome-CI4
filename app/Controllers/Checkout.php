<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;
use App\Models\PaymentDetailModel;


class Checkout extends BaseController
{

public function index()
{
    $cart = session()->get('cart');
    if (!$cart) return redirect()->to('/');

    $total = 0;
    foreach ($cart as $item) {
        $total += (float)$item['price'] * (int)$item['quantity'];
    }

    $data = [
        'cart'  => $cart,
        'total' => $total
    ];

    return view('checkout/index', $data);
}

    public function process()
    {
        
        $cart = session()->get('cart');
        $userId = session()->get('user_id'); 

        if (!$cart || empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

       
        $address  = $this->request->getPost('address');
        $shipping = $this->request->getPost('shipping_method');
        $total    = $this->request->getPost('total_amount');
        $bankName = $this->request->getPost('bank_name'); 
        $method   = "Bank Transfer"; 

        
        $db = \Config\Database::connect();
        $db->transStart(); 

        try {
            
            $orderModel = new OrderModel();
            $orderId = $orderModel->insert([
                'user_id'    => $userId,
                'order_date' => date('Y-m-d H:i:s'),
                'address'    => $address,
                'shipping'   => $shipping,
                'total'      => $total,
                'status'     => 'pending'
            ]);

            
            $orderItemModel = new OrderItemModel();
            foreach ($cart as $item) {
            $orderItemModel->insert([
                'order_id'   => $orderId,
                'product_id' => $item['id'],       
                'quantity'   => $item['quantity'], 
                'size'       => $item['size']
            ]);
                
                
            }

            
            $paymentModel = new PaymentModel();
            $paymentId = $paymentModel->insert([
                'order_id'     => $orderId,
                'method'       => $method,
                'amount'       => $total,
                'payment_date' => date('Y-m-d H:i:s'),
                'status'       => 'unpaid'
            ]);

            
            $paymentDetailModel = new PaymentDetailModel();
            $paymentDetailModel->insert([
                'payment_id'     => $paymentId,
                'provider'       => $bankName,
                'account_number' => $this->generateVA($bankName), 
                'status_message' => 'Waiting for customer payment'
            ]);

            $db->transComplete(); 

            if ($db->transStatus() === false) {
                
                return redirect()->back()->with('error', 'Gagal memproses pesanan. Silakan coba lagi.');
            }

            
            session()->remove('cart');

            return redirect()->to("/checkout/success/$orderId")->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($orderId)
    {
    $orderModel = new OrderModel();
    
   
    $data['order'] = $orderModel->select('orders.*, payments.method, payment_details.provider, payment_details.account_number')
        ->join('payments', 'payments.order_id = orders.order_id')
        ->join('payment_details', 'payment_details.payment_id = payments.payment_id')
        ->where('orders.order_id', $orderId)
        ->first();

    if (!$data['order']) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('checkout/success', $data);
}

public function confirmPayment($orderId)
{
    $orderModel = new \App\Models\OrderModel();
    $orderItemModel = new \App\Models\OrderItemModel();


    $order = $orderModel->select('orders.*, payments.method, payment_details.provider, payment_details.account_number')
        ->join('payments', 'payments.order_id = orders.order_id')
        ->join('payment_details', 'payment_details.payment_id = payments.payment_id')
        ->where('orders.order_id', $orderId)
        ->first();

    if (!$order) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    
    $items = $orderItemModel->select('order_items.*, products.name_product AS name, products.price, products.image') 
        ->join('products', 'products.product_id = order_items.product_id')
        ->where('order_items.order_id', $orderId)
        ->findAll();

    $data = [
        'order'       => $order,
        'order_items' => $items 
    ];

    
    return view('checkout/payment_success', $data);
}

    
    private function generateVA($bank)
    {
        $prefix = ($bank == 'BCA') ? '8801' : '9902';
        return $prefix . rand(10000000, 99999999);
    }
}
