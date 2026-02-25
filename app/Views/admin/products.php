<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MONO Admin - Products</title>
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
                    <h1 class="text-xl font-light tracking-tight">Products</h1>
                    <nav class="flex text-[10px] text-gray-400 uppercase tracking-widest space-x-2">
                        <span>Inventory</span>
                        <span>/</span>
                        <span class="text-black">Collection 2024</span>
                    </nav>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative hidden md:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">search</span>
                        <input id="searchInput" onkeyup="searchProducts()" class="pl-10 pr-4 py-2 border border-mono-border text-[10px] font-bold tracking-widest uppercase focus:outline-none focus:border-black w-64" placeholder="SEARCH PRODUCTS..." type="text" />
                    </div>
                    <a href="<?= base_url('admin/products/create') ?>" class="flex items-center gap-2 px-6 py-3 bg-black text-white text-[11px] font-bold uppercase tracking-widest hover:opacity-90 transition-all">
                        <span class="material-symbols-outlined text-sm">add</span>
                        Add New Product
                    </a>
                </div>
            </header>
            
            <div class="p-8 lg:p-12 space-y-8 max-w-7xl mx-auto w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="productsTable">
                        <thead>
                            <tr class="border-b border-black">
                                <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">ID</th>
                                <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Image</th>
                                <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Name</th>
                                <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Category</th>
                                <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Price</th>
                                <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500">Stock</th>
                                <th class="py-5 text-[10px] font-bold uppercase tracking-widest text-gray-500 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-mono-border">
                            <?php foreach ($products as $product): ?>
                            <tr class="hover:bg-mono-gray/30 transition-colors">
                                <td class="py-6 text-sm font-medium"><?= $product['product_id'] ?></td>
                                <td class="py-6">
                                    <div class="size-16 bg-mono-gray border border-mono-border overflow-hidden grayscale">
                                        <img alt="Product" class="w-full h-full object-cover" src="<?= base_url('uploads/' . $product['image']) ?>" />
                                    </div>
                                </td>
                                <td class="py-6 text-sm font-medium"><?= $product['name_product'] ?></td>
                                <td class="py-6 text-sm font-medium"><?= $product['category_type'] ?? 'General' ?></td>
                                <td class="py-6 text-sm font-medium">Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                                <td class="py-6 text-sm font-medium"><?= $product['stock'] ?></td>
                                <td class="py-6 text-right">
                                    <div class="flex items-center justify-end gap-4">
                                        <a href="<?= base_url('admin/products/edit/' . $product['product_id']) ?>" class="material-symbols-outlined text-lg hover:text-gray-400 transition-colors">edit</a>
                                        <button onclick="deleteProduct(<?= $product['product_id'] ?>)" class="material-symbols-outlined text-lg hover:text-gray-400 transition-colors">delete</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="flex items-center justify-between pt-8 border-t border-mono-border">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                        Showing <?= count($products) ?> products
                    </span>
                </div>
            </div>
        </main>
    </div>

    <script>
    function searchProducts() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('productsTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const tdName = tr[i].getElementsByTagName('td')[2];
            if (tdName) {
                const txtValue = tdName.textContent || tdName.innerText;
                tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? '' : 'none';
            }
        }
    }

    async function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            const response = await fetch(`<?= base_url('admin/products/delete') ?>/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.ok) {
                location.reload();
            }
        }
    }
    </script>
</body>
</html>