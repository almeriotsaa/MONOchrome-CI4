<?= $this->extend('layouts/header') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto px-6 py-16">

    <h1 class="text-[11px] tracking-[0.4em] uppercase mb-12 mt-12">
        My Orders
    </h1>

    <?php if (empty($orders)) : ?>
        <div class="text-center py-20 border border-black/20">
            <p class="text-[11px] tracking-[0.3em] uppercase text-gray-500">
                You have not placed any orders yet
            </p>
        </div>
    <?php else : ?>

        <div class="divide-y divide-black/20 border-t border-b border-black/20">

            <?php foreach ($orders as $order) : ?>
                <div class="py-10 flex justify-between items-center">

                    <!-- LEFT SIDE -->
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

                    <!-- CENTER -->
                    <div class="text-center">
                        <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-2">
                            Total
                        </p>
                        <p class="text-lg">
                            Rp <?= number_format($order['total'], 0, ',', '.') ?>
                        </p>
                    </div>

                    <!-- STATUS -->
                    <div class="text-center">
                        <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500 mb-2">
                            Status
                        </p>

                        <p class="text-[11px] tracking-widest uppercase
                            <?= $order['status'] == 'pending' ? 'text-gray-500' : '' ?>
                            <?= $order['status'] == 'paid' ? 'text-black' : '' ?>
                            <?= $order['status'] == 'cancelled' ? 'text-gray-400' : '' ?>">
                            <?= $order['status'] ?>
                        </p>
                    </div>

                    <!-- ACTION -->
                    <div>
                        <a href="<?= base_url('my-orders/' . $order['order_id']) ?>"
                           class="text-[10px] tracking-[0.4em] uppercase border border-black px-6 py-3 hover:bg-black hover:text-white transition-all">
                            View
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>