<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MONO Admin - Add New Product</title>
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
                        "mono-soft": "#a1a1a1",
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
            <header class="h-28 border-b border-mono-border flex items-center justify-between px-12 bg-white sticky top-0 z-10">
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold tracking-[0.1em] uppercase">Add New Product</h1>
                    <nav class="flex text-[10px] text-mono-soft uppercase tracking-[0.2em] space-x-2 mt-2">
                        <span>Inventory</span>
                        <span>/</span>
                        <span class="text-black">Catalog</span>
                    </nav>
                </div>
            </header>
            
            <div class="p-12 max-w-5xl mx-auto w-full">
                <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data" class="space-y-16">
                    <?= csrf_field() ?>
                    
                    <section>
                        <h2 class="text-[11px] font-bold uppercase tracking-widest border-b border-black pb-4 mb-8">Product Information</h2>
                        <div class="grid grid-cols-2 gap-x-12 gap-y-8">
                            <div class="flex flex-col gap-2 col-span-2">
                                <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">Product Name</label>
                                <input name="name_product" class="w-full p-4 text-xs tracking-widest uppercase border border-black" placeholder="e.g. Nike Air Max" type="text" required />
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">Category</label>
                                <select name="category_id" class="w-full p-4 text-xs tracking-widest uppercase border border-black" required>
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['category_id'] ?>">
                                        <?= $category['category_gender'] ?> - <?= $category['category_type'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">Size (comma separated)</label>
                                <input name="size" class="w-full p-4 text-xs tracking-widest uppercase border border-black" placeholder="e.g. S,M,L,XL" type="text" required />
                            </div>
                            
                            <div class="flex flex-col gap-2 col-span-2">
                                <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">Description</label>
                                <textarea name="description" class="w-full p-4 text-xs tracking-widest uppercase border border-black" placeholder="Short description..." rows="2" required></textarea>
                            </div>
                        </div>
                    </section>
                    
                    <section>
                        <h2 class="text-[11px] font-bold uppercase tracking-widest border-b border-black pb-4 mb-8">Inventory & Pricing</h2>
                        <div class="grid grid-cols-2 gap-12">
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">Price (IDR)</label>
                                <input name="price" class="w-full p-4 text-xs tracking-widest uppercase border border-black" placeholder="0.00" type="number" step="0.01" required />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">Stock</label>
                                <input name="stock" class="w-full p-4 text-xs tracking-widest uppercase border border-black" placeholder="0" type="number" required />
                            </div>
                        </div>
                    </section>
                    
                    <section>
                        <h2 class="text-[11px] font-bold uppercase tracking-widest border-b border-black pb-4 mb-8">Image Upload</h2>
                        <div class="w-full aspect-video border border-dashed border-black flex flex-col items-center justify-center gap-4 bg-white hover:bg-mono-gray/20 transition-colors cursor-pointer group">
                            <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(this)" required />
                            <label for="image" class="w-full h-full flex flex-col items-center justify-center cursor-pointer">
                                <span class="material-symbols-outlined text-4xl font-light">cloud_upload</span>
                                <div class="text-center">
                                    <p class="text-[10px] font-bold uppercase tracking-widest">Drag and drop images here</p>
                                    <p class="text-[9px] text-mono-soft uppercase tracking-widest mt-1">or click to browse from files</p>
                                </div>
                                <p class="text-[8px] text-mono-soft uppercase mt-4">Recommended: 2000 x 2500px JPG/PNG</p>
                            </label>
                        </div>
                        <div id="imagePreview" class="mt-4 hidden">
                            <img class="max-h-40 border border-black" />
                        </div>
                    </section>
                    
                    <div class="flex items-center justify-end gap-6 pt-8 border-t border-mono-border">
                        <a href="<?= base_url('admin/products') ?>" class="px-12 py-4 border border-black text-black text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-mono-gray transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-12 py-4 bg-black text-white text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-neutral-800 transition-all">
                            Save Product
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const img = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html>