<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Fashion Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black font-sans">
    <div class="max-w-4xl mx-auto p-8 lg:p-20">
        <h1 class="text-[12px] uppercase tracking-[0.5em] font-bold mb-12 border-b border-black pb-4">Shipping & Payment</h1>

        <form action="<?= base_url('checkout/process') ?>" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-16">
            <?= csrf_field() ?>
            
            <div class="space-y-8">
                <div>
                    <label class="text-[9px] uppercase tracking-widest block mb-3">Shipping Address</label>
                    <textarea name="address" required class="w-full border border-black p-4 text-[11px] focus:outline-none focus:bg-gray-50 h-32" placeholder="Full Address, City, Postal Code..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] uppercase tracking-widest block mb-3">Courier</label>
                        <select name="shipping_method" class="w-full border border-black p-4 text-[11px] appearance-none focus:outline-none">
                            <option value="JNE">JNE - Regular</option>
                            <option value="JNT">J&T - Express</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] uppercase tracking-widest block mb-3">Payment Method</label>
                        <select name="bank_name" class="w-full border border-black p-4 text-[11px] appearance-none focus:outline-none">
                            <option value="BCA">BCA Transfer</option>
                            <option value="MANDIRI">Mandiri VA</option>
                            <option value="BNI">BNI Transfer</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-8 h-fit border border-black/5">
                <h2 class="text-[10px] uppercase tracking-widest mb-6 font-bold">Order Summary</h2>
                
                <div class="space-y-4 border-b border-black/10 pb-6 mb-6">
                    <?php foreach($cart as $item): ?>
                    <div class="flex justify-between text-[11px]">
                        <span><?= $item['name'] ?> (x<?= $item['quantity'] ?>)</span>
                        <span>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-between items-center mb-8">
                    <span class="text-[10px] uppercase tracking-widest font-bold">Total Amount</span>
                    <span class="text-[14px] font-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>

                <input type="hidden" name="total_amount" value="<?= $total ?>">
                
                <button type="submit" class="w-full py-4 bg-black text-white text-[9px] uppercase tracking-[0.4em] hover:bg-gray-800 transition-all">
                    Complete Purchase
                </button>
                
                <a href="<?= base_url('/') ?>" class="block text-center mt-4 text-[9px] uppercase tracking-widest text-gray-500 hover:text-black">
                    Back to Shopping
                </a>
            </div>
        </form>
    </div>
</body>
</html>