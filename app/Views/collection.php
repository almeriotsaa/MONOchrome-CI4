<?= $this->extend('layouts/header') ?>
<?= $this->section('title') ?>Collection<?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="pt-32 pb-64 px-12">
    <div class="max-w-[1800px] mx-auto">
        <div class="flex justify-between items-center mb-16">
            <div class="flex items-center gap-4">
                <button onclick="toggleFilters()" class="px-8 py-3 bg-black text-white text-[10px] uppercase tracking-[0.2em] hover:bg-zinc-800 transition-colors duration-300">
                    Filter
                </button>
                
          
                <div id="filterDropdown" class="absolute top-32 left-12 bg-white border border-black p-6 hidden z-40">
                    <form method="get" action="<?= base_url('collection') ?>" class="space-y-4">
                        <div>
                            <label class="text-[8px] uppercase tracking-widest block mb-2">Gender</label>
                            <select name="gender" class="text-[9px] uppercase tracking-widest border border-black p-2">
                                <option value="">All</option>
                                <option value="Men" <?= $selectedGender == 'Men' ? 'selected' : '' ?>>Men</option>
                                <option value="Women" <?= $selectedGender == 'Women' ? 'selected' : '' ?>>Women</option>
                                <option value="Kids" <?= $selectedGender == 'Kids' ? 'selected' : '' ?>>Kids</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[8px] uppercase tracking-widest block mb-2">Type</label>
                            <select name="type" class="text-[9px] uppercase tracking-widest border border-black p-2">
                                <option value="">All</option>
                                <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_type'] ?>" <?= $selectedType == $cat['category_type'] ? 'selected' : '' ?>>
                                    <?= $cat['category_type'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="w-full py-2 bg-black text-white text-[8px] uppercase tracking-widest">Apply</button>
                    </form>
                </div>
            </div>
            <div class="text-[9px] uppercase tracking-[0.4em] text-black/40">
                Showing <?= count($products) ?> Products
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-24">
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <a href="<?= base_url('detail/' . $product['product_id']) ?>" class="group cursor-pointer">
                        <div class="aspect-[2/3] overflow-hidden bg-white border-thin mb-6">
                            <?php if (!empty($product['image'])) : ?>
                                <img
                                    alt="<?= esc($product['name_product']) ?>"
                                    class="w-full h-full object-cover grayscale transition-transform duration-700 group-hover:scale-105"
                                    src="<?= base_url('uploads/' . esc($product['image'])) ?>"
                                />
                            <?php else : ?>
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                    <span class="text-[9px] uppercase tracking-[0.3em] text-black/30">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex justify-between items-baseline">
                            <h3 class="text-[10px] uppercase tracking-[0.3em] font-light">
                                <?= esc($product['name_product']) ?>
                            </h3>
                            <span class="text-[10px] tracking-widest text-black/60">
                                Rp <?= number_format($product['price'], 0, ',', '.') ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-3 text-center py-24">
                    <p class="text-[9px] uppercase tracking-[0.4em] text-black/40">No products found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
function toggleFilters() {
    document.getElementById('filterDropdown').classList.toggle('hidden');
}
</script>

<?= $this->endSection() ?>