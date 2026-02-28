<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MONO Admin Dashboard</title>
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
                    <h1 class="text-xl font-light tracking-tight">Dashboard Overview</h1>
                    <nav class="flex text-[10px] text-gray-400 uppercase tracking-widest space-x-2">
                        <span>Admin</span>
                        <span>/</span>
                        <span class="text-black">Analytics</span>
                    </nav>
                </div>
                <div class="flex items-center gap-6">
                    <a href="<?= base_url('/') ?>" class="text-[10px] uppercase tracking-widest hover:underline">View Site</a>
                    <a href="<?= base_url('logout') ?>" class="text-[10px] uppercase tracking-widest hover:underline">Logout</a>
                </div>
            </header>

            <div class="p-8 lg:p-12 space-y-12 max-w-7xl mx-auto w-full">
                <!-- Metrics Section -->
                <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-8 border border-mono-border flex flex-col justify-between h-48">
                        <div class="flex justify-between items-start">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Total Revenue</span>
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <div>
                            <p class="text-3xl font-light tracking-tighter">
                                Rp <?= number_format($totalRevenue ?? 0, 0, ',', '.') ?>
                            </p>
                            <p class="text-[10px] font-bold mt-1 uppercase tracking-widest text-mono-soft">
                                FROM COMPLETED ORDERS
                            </p>
                        </div>
                    </div>

                    <div class="p-8 border border-mono-border flex flex-col justify-between h-48">
                        <div class="flex justify-between items-start">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Orders</span>
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </div>
                        <div>
                            <p class="text-3xl font-light tracking-tighter"><?= $totalOrders ?? 1240 ?></p>
                            <p class="text-[10px] font-bold mt-1 uppercase tracking-widest">+5.2% COMPLETED</p>
                        </div>
                    </div>

                    <div class="p-8 border border-mono-border flex flex-col justify-between h-48">
                        <div class="flex justify-between items-start">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Customers</span>
                            <span class="material-symbols-outlined">person_add</span>
                        </div>
                        <div>
                            <p class="text-3xl font-light tracking-tighter"><?= $totalCustomers ?? 482 ?></p>
                            <p class="text-[10px] font-bold mt-1 uppercase tracking-widest">+12.0% GROWTH</p>
                        </div>
                    </div>
                </section>

                <!-- Recent Orders Table -->
                <section class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-[11px] font-bold uppercase tracking-widest">Recent Orders</h2>
                        <a href="<?= base_url('admin/orders') ?>" class="text-[10px] font-bold uppercase tracking-widest border-b border-black">View All</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-black">
                                    <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Order ID</th>
                                    <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Customer</th>
                                    <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Date</th>
                                    <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Amount</th>
                                    <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-mono-border">
                                <?php foreach ($recentOrders as $order): ?>
                                    <tr class="hover:bg-mono-gray/50 transition-colors">
                                        <td class="py-6 text-sm font-light">#<?= $order['order_id'] ?></td>
                                        <td class="py-6">
                                            <div class="flex items-center gap-3">
                                                <div class="size-7 bg-mono-gray flex items-center justify-center text-[10px] font-bold">
                                                    <?= substr($order['name'] ?? 'U', 0, 1) ?>
                                                </div>
                                                <span class="text-xs uppercase tracking-wider font-bold"><?= $order['name'] ?? 'User' ?></span>
                                            </div>
                                        </td>
                                        <td class="py-6 text-[11px] text-gray-500 uppercase tracking-widest">
                                            <?= date('M d, Y H:i:s', strtotime($order['created_at'])) ?>
                                        </td>
                                        <td class="py-6 text-sm font-medium">$<?= number_format($order['total'] ?? 0, 2) ?></td>
                                        <td class="py-6 text-right">
                                            <span class="inline-block px-3 py-1 <?= $order['status'] == 'shipped' ? 'bg-black text-white' : 'border border-black' ?> text-[9px] font-bold uppercase tracking-widest">
                                                <?= $order['status'] ?>
                                            </span>
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
</body>

</html>