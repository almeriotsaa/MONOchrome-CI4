<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MONO Admin - Edit Product</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&family=Bodoni+Moda:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

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

        <!-- HEADER -->
        <header class="h-28 border-b border-mono-border flex items-center justify-between px-12 bg-white sticky top-0 z-10">
            <div class="flex flex-col">
                <h1 class="text-3xl font-bold tracking-[0.1em] uppercase">
                    Edit Product
                </h1>
                <nav class="flex text-[10px] text-mono-soft uppercase tracking-[0.2em] space-x-2 mt-2">
                    <span>Inventory</span>
                    <span>/</span>
                    <span class="text-black">Edit</span>
                </nav>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="p-12 max-w-5xl mx-auto w-full">

            <form action="<?= base_url('admin/products/update/' . $product['product_id']) ?>"
                  method="post"
                  enctype="multipart/form-data"
                  class="space-y-16">

                <?= csrf_field() ?>

                <!-- PRODUCT INFORMATION -->
                <section>
                    <h2 class="text-[11px] font-bold uppercase tracking-widest border-b border-black pb-4 mb-8">
                        Product Information
                    </h2>

                    <div class="grid grid-cols-2 gap-x-12 gap-y-8">

                        <!-- Name -->
                        <div class="flex flex-col gap-2 col-span-2">
                            <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">
                                Product Name
                            </label>
                            <input type="text"
                                   name="name_product"
                                   value="<?= $product['name_product'] ?>"
                                   class="w-full p-4 text-xs tracking-widest uppercase border border-black"
                                   required>
                        </div>

                        <!-- Category -->
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">
                                Category
                            </label>
                            <select name="category_id"
                                    class="w-full p-4 text-xs tracking-widest uppercase border border-black"
                                    required>
                                <option value="">Select Category</option>

                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['category_id'] ?>"
                                        <?= $product['category_id'] == $category['category_id'] ? 'selected' : '' ?>>
                                        <?= $category['category_gender'] ?> - <?= $category['category_type'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Size -->
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">
                                Size
                            </label>
                            <input type="text"
                                   name="size"
                                   value="<?= $product['size'] ?>"
                                   class="w-full p-4 text-xs tracking-widest uppercase border border-black"
                                   required>
                        </div>

                        <!-- Description -->
                        <div class="flex flex-col gap-2 col-span-2">
                            <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">
                                Description
                            </label>
                            <textarea name="description"
                                      rows="3"
                                      class="w-full p-4 text-xs tracking-widest uppercase border border-black"
                                      required><?= $product['description'] ?></textarea>
                        </div>
                    </div>
                </section>

                <!-- PRICING -->
                <section>
                    <h2 class="text-[11px] font-bold uppercase tracking-widest border-b border-black pb-4 mb-8">
                        Inventory & Pricing
                    </h2>

                    <div class="grid grid-cols-2 gap-12">
                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">
                                Price (IDR)
                            </label>
                            <input type="number"
                                   name="price"
                                   value="<?= $product['price'] ?>"
                                   class="w-full p-4 text-xs tracking-widest uppercase border border-black"
                                   required>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="text-[9px] font-bold uppercase tracking-widest text-mono-soft">
                                Stock
                            </label>
                            <input type="number"
                                   name="stock"
                                   value="<?= $product['stock'] ?>"
                                   class="w-full p-4 text-xs tracking-widest uppercase border border-black"
                                   required>
                        </div>
                    </div>
                </section>

                <!-- IMAGE -->
                <section>
                    <h2 class="text-[11px] font-bold uppercase tracking-widest border-b border-black pb-4 mb-8">
                        Image
                    </h2>

                    <div class="mb-6">
                        <p class="text-[9px] uppercase tracking-widest mb-2">
                            Current Image
                        </p>
                        <img src="<?= base_url('uploads/' . $product['image']) ?>"
                             class="max-h-40 border border-black">
                    </div>

                    <div class="w-full border border-dashed border-black p-10 text-center">
                        <input type="file"
                               name="image"
                               id="image"
                               accept="image/*"
                               onchange="previewImage(this)">
                        <p class="text-[9px] uppercase tracking-widest mt-4">
                            Upload new image (optional)
                        </p>
                    </div>

                    <div id="imagePreview" class="mt-4 hidden">
                        <img class="max-h-40 border border-black">
                    </div>
                </section>

                <!-- ACTION BUTTON -->
                <div class="flex items-center justify-end gap-6 pt-8 border-t border-mono-border">

                    <a href="<?= base_url('admin/products') ?>"
                       class="px-12 py-4 border border-black text-black text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-mono-gray transition-all">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-12 py-4 bg-black text-white text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-neutral-800 transition-all">
                        Update Product
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