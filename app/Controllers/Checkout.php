<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;
use App\Models\PaymentDetailModel;
// Jika Anda ingin mengurangi stok, jangan lupa panggil ProductModel
// use App\Models\ProductModel; 

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
        // 1. Ambil data keranjang dari Session
        // Asumsi struktur session cart: [['product_id' => 1, 'qty' => 2, 'size' => 'M', 'price' => 150000], ...]
        $cart = session()->get('cart');
        $userId = session()->get('user_id'); // Pastikan user sudah login

        if (!$cart || empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 2. Ambil input dari Form Checkout
        $address  = $this->request->getPost('address');
        $shipping = $this->request->getPost('shipping_method');
        $total    = $this->request->getPost('total_amount');
        $bankName = $this->request->getPost('bank_name'); // Misal: BCA, Mandiri, dll
        $method   = "Bank Transfer"; // Atau sesuaikan dengan pilihan user

        // 3. Mulai Proses Database
        $db = \Config\Database::connect();
        $db->transStart(); // --- START TRANSACTION ---

        try {
            // TABLE 1: Simpan ke 'orders'
            $orderModel = new OrderModel();
            $orderId = $orderModel->insert([
                'user_id'    => $userId,
                'order_date' => date('Y-m-d H:i:s'),
                'address'    => $address,
                'shipping'   => $shipping,
                'total'      => $total,
                'status'     => 'pending'
            ]);

            // TABLE 2: Simpan ke 'order_items' (Looping)
            $orderItemModel = new OrderItemModel();
            foreach ($cart as $item) {
            $orderItemModel->insert([
                'order_id'   => $orderId,
                'product_id' => $item['id'],       
                'quantity'   => $item['quantity'], 
                'size'       => $item['size']
            ]);
                
                // OPTIONAL: Kurangi stok produk di sini jika diperlukan
            }

            // TABLE 3: Simpan ke 'payments'
            $paymentModel = new PaymentModel();
            $paymentId = $paymentModel->insert([
                'order_id'     => $orderId,
                'method'       => $method,
                'amount'       => $total,
                'payment_date' => date('Y-m-d H:i:s'),
                'status'       => 'unpaid'
            ]);

            // TABLE 4: Simpan ke 'payment_details'
            $paymentDetailModel = new PaymentDetailModel();
            $paymentDetailModel->insert([
                'payment_id'     => $paymentId,
                'provider'       => $bankName,
                'account_number' => $this->generateVA($bankName), // Fungsi dummy VA
                'status_message' => 'Waiting for customer payment'
            ]);

            $db->transComplete(); // --- FINISH TRANSACTION ---

            if ($db->transStatus() === false) {
                // Jika transaksi gagal
                return redirect()->back()->with('error', 'Gagal memproses pesanan. Silakan coba lagi.');
            }

            // 4. Hapus Keranjang setelah sukses
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
    
    // Ambil data lengkap dengan join ke tabel payments dan details
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

    // Fungsi sederhana untuk simulasi nomor VA/Rekening
    private function generateVA($bank)
    {
        $prefix = ($bank == 'BCA') ? '8801' : '9902';
        return $prefix . rand(10000000, 99999999);
    }
}