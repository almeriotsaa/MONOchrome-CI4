<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful | Fashion Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body class="bg-white text-black font-sans">
    <div class="max-w-3xl mx-auto p-8 lg:p-20">
        
        <div class="text-center mb-16">
            <span class="material-symbols-outlined text-6xl font-extralight">verified_user</span>
            <h1 class="text-[14px] uppercase tracking-[0.6em] font-bold mt-6">Payment Successful</h1>
            <p class="text-[10px] text-gray-400 mt-3 uppercase tracking-[0.3em]">Thank you. Your order is now being processed.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 border-t border-black pt-12">
            <div class="space-y-8 text-left">
                <div>
                    <h2 class="text-[10px] uppercase tracking-widest font-bold mb-4 border-b pb-2">Shipping Details</h2>
                    <p class="text-[11px] leading-relaxed text-gray-600 uppercase">
                        Address:<br>
                        <?= $order['address'] ?>
                    </p>
                    <p class="text-[11px] mt-4 text-gray-600 uppercase">
                        Method: <?= $order['shipping'] ?>
                    </p>
                </div>

                <div>
                    <h2 class="text-[10px] uppercase tracking-widest font-bold mb-4 border-b pb-2">Payment Info</h2>
                    <p class="text-[11px] text-gray-600 uppercase tracking-widest">
                        Method: <?= $order['method'] ?> (<?= $order['provider'] ?>)<br>
                        Status: <span class="text-black font-bold">Paid</span>
                    </p>
                </div>
            </div>
                <div class="bg-[#fafafa] p-8 border border-black/5">
                    <h2 class="text-[10px] uppercase tracking-widest font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-8 text-left">
                        <?php foreach($order_items as $item): ?>
                        <div class="flex justify-between text-[11px] uppercase tracking-tighter border-b border-black/5 pb-2">
                            <div>
                                <span class="block font-medium text-black"><?= $item['name'] ?></span>
                                <span class="text-gray-400 text-[9px]">Size: <?= $item['size'] ?> | Qty: <?= $item['quantity'] ?></span>
                            </div>
                            <span class="font-bold">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pt-4 flex justify-between items-center border-t border-black">
                        <span class="text-[10px] uppercase tracking-widest font-bold">Total Paid</span>
                        <span class="text-[16px] font-bold">Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
                    </div>
                </div>
        </div>

        <div class="mt-16 text-center border-t border-black pt-12">
            <a href="<?= base_url('/') ?>" class="inline-block px-16 py-5 bg-black text-white text-[9px] uppercase tracking-[0.4em] hover:bg-gray-800 transition-all">
                Continue Shopping
            </a>
        </div>
    </div>
</body>
</html>