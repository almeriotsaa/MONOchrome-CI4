<h2 class="text-lg font-bold tracking-widest mb-6">
    ORDER #<?= $order['order_id'] ?>
</h2>

<div class="mb-6">
    <p class="text-xs text-gray-400">Customer</p>
    <p class="font-bold"><?= $order['name'] ?></p>

    <p class="text-xs text-gray-400 mt-3">Email</p>
    <p><?= $order['email'] ?></p>

    <p class="text-xs text-gray-400 mt-3">Status</p>
    <p class="uppercase"><?= $order['status'] ?></p>
</div>

<h3 class="text-sm font-bold tracking-widest mb-3">ITEMS</h3>

<table class="w-full text-sm border-t border-b">
    <?php foreach ($items as $item): ?>
    <tr class="border-b">
        <td class="py-3"><?= $item['name_product'] ?></td>
        <td><?= $item['quantity'] ?>x</td>
        <td>Rp <?= number_format($item['price'],0,',','.') ?></td>
    </tr>
    <?php endforeach; ?>
</table>