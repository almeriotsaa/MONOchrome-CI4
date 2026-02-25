<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MONO Admin - Customers</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&amp;family=Bodoni+Moda:ital,wght@0,400..900;1,400..900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "mono-black": "#000000",
                        "mono-gray": "#f2f2f2",
                        "mono-border": "#e5e5e5",
                        "mono-soft": "#7a7a7a",
                        "mono-light-gray": "#F9F9F9"
                    },
                    fontFamily: {
                        "sans": ["Inter", "sans-serif"],
                        "serif": ["Bodoni Moda", "serif"]
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-white text-black font-sans antialiased overflow-x-hidden">
    <div class="flex min-h-screen">
        <?= $this->include('admin/sidebar') ?>
        
        <main class="flex-1 flex flex-col min-w-0">
            <header class="h-20 border-b border-mono-border flex items-center justify-between px-8 bg-white/80 backdrop-blur-md sticky top-0 z-10">
                <div class="flex flex-col">
                    <h1 class="text-xl font-light tracking-tight">Customers</h1>
                    <nav class="flex text-[10px] text-gray-400 uppercase tracking-widest space-x-2">
                        <span>Admin</span>
                        <span>/</span>
                        <span class="text-black">Customers</span>
                    </nav>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative hidden md:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">search</span>
                        <input id="searchInput" onkeyup="searchCustomers()" class="pl-10 pr-4 py-2 border border-black text-[10px] font-bold tracking-widest uppercase w-64" placeholder="SEARCH CUSTOMERS..." type="text" />
                    </div>
                </div>
            </header>
            
            <div class="p-12 max-w-7xl mx-auto w-full">
                <section class="bg-white">
                    <div class="mb-10 flex items-center justify-between">
                        <h2 class="text-[11px] font-bold uppercase tracking-widest border-b-2 border-black pb-1">
                            All Registered Users (<?= count($customers) ?>)
                        </h2>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse" id="customersTable">
                            <thead>
                                <tr class="border-b border-black">
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-mono-soft">Name</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-mono-soft">Email</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-mono-soft">Registered</th>
                                    <th class="py-6 text-[10px] font-bold uppercase tracking-widest text-mono-soft text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-mono-border">
                                <?php foreach ($customers as $customer): ?>
                                <tr class="hover:bg-mono-light-gray transition-colors">
                                    <td class="py-8">
                                        <div class="flex items-center gap-4">
                                            <div class="size-10 bg-mono-gray flex items-center justify-center text-[10px] font-bold grayscale border border-mono-border">
                                                <?= substr($customer['name'], 0, 2) ?>
                                            </div>
                                            <span class="py-8 text-xs font-bold tracking-widest"><?= $customer['name'] ?></span>
                                        </div>
                                    </td>
                                    <td class="py-8 text-xs font-medium text-mono-soft"><?= $customer['email'] ?></td>
                                    <td class="py-8 text-xs font-bold tracking-widest">
                                        <?= date('M d, Y', strtotime($customer['created_at'])) ?>
                                    </td>
                                    <td class="py-8 text-right">
                                        <button onclick="viewOrders(<?= $customer['user_id'] ?>)" class="text-[10px] font-bold uppercase tracking-widest hover:underline">
                                            View Orders
                                        </button>
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

    <script>
    function searchCustomers() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('customersTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const tdName = tr[i].getElementsByTagName('td')[0];
            const tdEmail = tr[i].getElementsByTagName('td')[1];
            if (tdName || tdEmail) {
                const nameValue = tdName.textContent || tdName.innerText;
                const emailValue = tdEmail.textContent || tdEmail.innerText;
                tr[i].style.display = nameValue.toUpperCase().indexOf(filter) > -1 || emailValue.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }

    function viewOrders(userId) {
        window.location.href = `<?= base_url('admin/orders') ?>?user_id=${userId}`;
    }
    </script>
</body>
</html>