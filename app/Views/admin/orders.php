<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MONO Admin - Orders</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#000000",
                        "mono-black": "#000000",
                        "mono-gray": "#f2f2f2",
                        "mono-border": "#e5e5e5",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-white text-black font-display overflow-x-hidden">
    <div class="flex min-h-screen">
        <?= $this->include('admin/sidebar') ?>

        <main class="flex-1 flex flex-col min-w-0">
            <header class="h-20 border-b border-mono-border flex items-center justify-between px-8 bg-white/80 backdrop-blur-md sticky top-0 z-10">
                <div class="flex flex-col">
                    <h1 class="text-xl font-light tracking-tight">Orders Management</h1>
                    <nav class="flex text-[10px] text-gray-400 uppercase tracking-widest space-x-2">
                        <span>Admin</span>
                        <span>/</span>
                        <span class="text-black">Orders</span>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <select id="statusFilter" onchange="filterOrders()" class="px-4 py-2 border border-black text-[10px] font-bold uppercase tracking-widest">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </header>

            <div class="p-8 lg:p-12 max-w-7xl mx-auto w-full">
                <section class="space-y-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="ordersTable">
                            <thead>
                                <tr class="border-b border-black">
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-gray-400">Order ID</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-gray-400">Customer</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-gray-400">Date</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-gray-400">Total</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-gray-400">Status</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-gray-400 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-mono-border">
                                <?php foreach ($orders as $order): ?>
                                    <tr class="hover:bg-mono-gray/30 transition-colors group" data-status="<?= $order['status'] ?>">
                                        <td class="py-8 text-sm font-light">#<?= $order['order_id'] ?></td>
                                        <td class="py-8">
                                            <div class="flex items-center gap-3">
                                                <div class="size-8 bg-mono-gray flex items-center justify-center text-[10px] font-bold">
                                                    <?= substr($order['name'] ?? 'U', 0, 1) ?>
                                                </div>
                                                <span class="text-xs uppercase tracking-widest font-bold"><?= $order['name'] ?? 'User' ?></span>
                                            </div>
                                        </td>
                                        <td class="py-8 text-[11px] text-gray-500 uppercase tracking-widest">
                                            <?= date('M d, Y H:i:s', strtotime($order['created_at'])) ?>
                                        </td>
                                        <td class="py-8 text-sm font-medium">Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?></td>
                                        <td class="py-8">
                                            <div class="flex items-center gap-4">

                                                <!-- STATUS BADGE -->
                                                <span class="order-status px-3 py-1 text-xs font-semibold uppercase tracking-widest rounded-full 
            <?= $order['status'] == 'completed' ? 'bg-green-100 text-green-600' : ($order['status'] == 'pending' ? 'bg-yellow-100 text-yellow-600' :
                                        'bg-gray-200 text-gray-600') ?>">

                                                    <?= $order['status'] ?>
                                                </span>

                                                <!-- BUTTON -->
                                                <?php if ($order['status'] != 'completed'): ?>
                                                    <button
                                                        onclick="updateStatus(<?= $order['order_id'] ?>, 'completed', this)"
                                                        class="px-4 py-1.5 text-xs font-medium bg-black text-white rounded-full hover:bg-gray-800 transition duration-200">
                                                        Complete
                                                    </button>
                                                <?php endif; ?>

                                            </div>
                                        </td>
                                        <td class="py-6">
                                            <div class="flex items-center gap-4">

                                                <!-- VIEW -->
                                                <button
                                                    onclick="openOrderModal(<?= $order['order_id'] ?>)"
                                                    class="text-gray-600 hover:text-black transition">
                                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                                </button>

                                                <!-- DELETE -->
                                                <button
                                                    onclick="confirmDelete(<?= $order['order_id'] ?>)"
                                                    class="text-red-500 hover:text-red-700 transition">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div id="orderModal"
        class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

        <div class="bg-white w-[900px] max-h-[90vh] overflow-y-auto p-8 relative">


            <button onclick="closeOrderModal()"
                class="absolute top-4 right-4">
                <span class="material-symbols-outlined">close</span>
            </button>

            <div id="orderDetailContent">

            </div>

        </div>
    </div>

    <script>
        function filterOrders() {
            const filter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#ordersTable tbody tr');

            rows.forEach(row => {
                if (!filter || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        async function updateStatus(orderId, status, button) {
            const response = await fetch(`<?= base_url('admin/orders/update-status') ?>/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    status: status
                })
            });

            const result = await response.json();

            if (result.status) {
                const row = button.closest('tr');
                const statusElement = row.querySelector('.order-status');

                statusElement.textContent = status;
                row.dataset.status = status;
            } else {
                alert(result.message);
            }
        }
    </script>
    <script>
        function openOrderModal(orderId) {
            document.getElementById('orderModal').classList.remove('hidden');
            document.getElementById('orderModal').classList.add('flex');

            fetch("<?= base_url('admin/orders/detail') ?>/" + orderId)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('orderDetailContent').innerHTML = data;
                });
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
            document.getElementById('orderModal').classList.remove('flex');
        }
    </script>
</body>

</html>