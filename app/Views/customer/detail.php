<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-6 py-16">

    <div class="flex justify-between items-center mb-12 mt-12">
        <h1 class="text-[11px] tracking-[0.4em] uppercase">
            Order Detail
        </h1>
        <a href="<?= base_url('my-orders') ?>" 
           class="text-[10px] tracking-[0.3em] uppercase border-b border-black pb-1 hover:text-gray-600 hover:border-gray-400 transition-all">
            ← Back to Orders
        </a>
    </div>

    <?php if (isset($order)) : ?>

        <div class="border-t border-b border-black/20 py-10 mb-12">

            <div class="flex justify-between items-center">

                <div class="space-y-3">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500">
                        Order
                    </p>
                    <p class="text-lg font-light">
                        #<?= $order['order_id'] ?>
                    </p>
                    <p class="text-[11px] tracking-widest text-gray-600">
                        <?= date('d M Y', strtotime($order['created_at'])) ?>
                    </p>
                </div>

                <div class="text-center">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-2">
                        Total
                    </p>
                    <p class="text-lg">
                        Rp <?= number_format($order['total'], 0, ',', '.') ?>
                    </p>
                </div>

                <div class="text-center">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-2">
                        Status
                    </p>
                    <p class="text-[11px] tracking-widest uppercase
                        <?= $order['status'] == 'pending' ? 'text-gray-500' : '' ?>
                        <?= $order['status'] == 'paid' || $order['status'] == 'complete' ? 'text-black' : '' ?>
                        <?= $order['status'] == 'cancelled' ? 'text-gray-400' : '' ?>">
                        <?= $order['status'] ?>
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-2">
                        Shipping
                    </p>
                    <p class="text-[11px] tracking-widest">
                        <?= isset($order['shipping_method']) ? $order['shipping_method'] : 'Standard' ?>
                    </p>
                </div>

            </div>

        </div>

        <div class="divide-y divide-black/20 border-b border-black/20 mb-12">

            <?php foreach ($items as $item) : ?>
                <div class="py-10 flex justify-between items-center">

                    <div class="flex items-center gap-8 flex-1">
                        
                        <div class="w-20 h-24 bg-gray-50 border border-black/10 overflow-hidden flex-shrink-0">
                            <?php if (!empty($item['image'])): ?>
                                <img src="<?= base_url('uploads/' . $item['image']) ?>" 
                                     class="w-full h-full object-cover grayscale">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-[8px] tracking-widest">
                                    IMAGE
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-2">
                            <p class="text-sm uppercase tracking-[0.2em]">
                                <?= $item['name_product'] ?>
                            </p>
                            <p class="text-[11px] tracking-widest text-gray-500">
                                Size <?= $item['size'] ?>
                            </p>
                            <p class="text-[11px] tracking-widest text-gray-500">
                                Qty <?= $item['quantity'] ?>
                            </p>
                        </div>

                    </div>

                    <div class="text-center w-32">
                        <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-2">
                            Price
                        </p>
                        <p class="text-sm">
                            Rp <?= number_format($item['price'], 0, ',', '.') ?>
                        </p>
                    </div>

                    <div class="text-right w-32">
                        <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-2">
                            Subtotal
                        </p>
                        <p class="text-sm font-medium">
                            Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                        </p>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

        <div class="flex justify-between items-center">

            <div class="space-y-3">
                <div class="flex items-center gap-12">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 w-24">
                        Subtotal
                    </p>
                    <p class="text-sm w-32 text-right">
                        Rp <?= number_format($order['total'], 0, ',', '.') ?>
                    </p>
                </div>
                
                <?php if (isset($order['shipping_cost']) && $order['shipping_cost'] > 0): ?>
                <div class="flex items-center gap-12">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 w-24">
                        Shipping
                    </p>
                    <p class="text-sm w-32 text-right">
                        Rp <?= number_format($order['shipping_cost'], 0, ',', '.') ?>
                    </p>
                </div>
                <?php endif; ?>
                
                <div class="flex items-center gap-12 pt-3 border-t border-black/10">
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 w-24">
                        Total
                    </p>
                    <p class="text-base font-light w-32 text-right">
                        Rp <?= number_format($order['total'], 0, ',', '.') ?>
                    </p>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="<?= base_url('shop') ?>" 
                   class="text-[10px] tracking-[0.4em] uppercase border border-black px-6 py-3 hover:bg-black hover:text-white transition-all">
                    Continue Shopping
                </a>
                
                <?php if ($order['status'] == 'pending'): ?>
                <a href="<?= base_url('checkout/' . $order['order_id']) ?>" 
                   class="text-[10px] tracking-[0.4em] uppercase bg-black text-white border border-black px-6 py-3 hover:bg-white hover:text-black transition-all">
                    Pay Now
                </a>
                <?php endif; ?>
            </div>

        </div>

    <?php else : ?>
        
        <div class="text-center py-20 border border-black/20">
            <p class="text-[11px] tracking-[0.3em] uppercase text-gray-500 mb-4">
                Order not found
            </p>
            <a href="<?= base_url('my-orders') ?>" 
               class="text-[10px] tracking-[0.4em] uppercase border border-black px-6 py-3 inline-block hover:bg-black hover:text-white transition-all">
                Back to My Orders
            </a>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>