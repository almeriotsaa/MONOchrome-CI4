<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed | Fashion Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-black font-sans">
    <div class="max-w-2xl mx-auto p-8 lg:p-20 text-center">
        <div class="mb-12">
            <span class="material-symbols-outlined text-5xl">check_circle</span>
            <h1 class="text-[12px] uppercase tracking-[0.5em] font-bold mt-4">Order Confirmed</h1>
            <p class="text-[10px] text-gray-500 mt-2 uppercase tracking-widest">Order ID: #<?= $order['order_id'] ?></p>
        </div>

        <div class="border border-black p-8 space-y-6 text-left mb-12">
            <div class="flex justify-between border-b border-black/5 pb-4">
                <span class="text-[9px] uppercase tracking-widest">Total Payment</span>
                <span class="text-[14px] font-bold">Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
            </div>

            <div class="space-y-2">
                <span class="text-[9px] uppercase tracking-widest text-gray-500">Bank Transfer To:</span>
                <div class="flex justify-between items-center">
                    <span class="text-[12px] font-bold uppercase tracking-widest"><?= $order['provider'] ?></span>
                    <span class="text-[16px] font-mono font-bold text-blue-700"><?= $order['account_number'] ?></span>
                </div>
            </div>

            <div class="pt-4 border-t border-black/5 text-[10px] leading-relaxed text-gray-600">
                Please complete your payment within 24 hours. Your order will be processed immediately after payment verification.
            </div>
        </div>

        <a href="<?= base_url('/') ?>" class="inline-block px-12 py-4 bg-black text-white text-[9px] uppercase tracking-[0.4em] hover:bg-gray-800 transition-all">
            Continue Shopping
        </a>
    </div>
</body>
</html>