<?= $this->extend('layouts/header') ?>
<?= $this->section('title') ?><?= esc($product['name_product']) ?><?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="max-w-[1800px] mx-auto px-8 pt-32 pb-20">
    <div class="flex flex-col lg:flex-row gap-0">
        
        <div class="lg:w-[70%] space-y-12 pr-16">
            <div class="aspect-[4/5] overflow-hidden bg-gray-50 border-thin">
                <img 
                    alt="<?= esc($product['name_product']) ?> Main View" 
                    class="w-full h-full object-cover grayscale" 
                    src="<?= base_url('uploads/' . $product['image']) ?>" />
            </div>
        </div>

        
        <div class="lg:w-[30%]">
            <div class="sticky top-32 space-y-16">
                <header class="space-y-6">
                    <h1 class="text-4xl font-serif font-light leading-tight tracking-tight uppercase">
                        <?= esc($product['name_product']) ?>
                    </h1>
                    <p class="text-xl font-serif italic text-black/80">
                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                    </p>
                </header>

                <div class="space-y-12">
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-baseline border-b border-black/10 pb-2">
                            <span class="text-[10px] uppercase tracking-[0.3em] font-medium">Select Size</span>
                            <button class="text-[9px] uppercase tracking-[0.3em] opacity-40 hover:opacity-100">Size Guide</button>
                        </div>
                        <div class="flex flex-wrap gap-x-8 gap-y-4">
                            <?php 
                            $sizes = explode(',', $product['size']);
                            foreach ($sizes as $index => $size) :
                                $size = trim($size);
                            ?>
                            <button onclick="selectSize('<?= $size ?>')" class="size-option text-[10px] tracking-[0.3em] <?= $index === 0 ? 'font-bold border-b border-black' : 'opacity-40 hover:opacity-100 transition-opacity' ?>" data-size="<?= $size ?>">
                                <?= esc($size) ?>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-4 border border-black p-2">
                        <button onclick="decreaseQty()" class="px-3 py-1 text-lg">-</button>
                        <span id="quantity" class="flex-1 text-center text-[10px] uppercase tracking-widest">1</span>
                        <button onclick="increaseQty()" class="px-3 py-1 text-lg">+</button>
                    </div>

                    <button onclick="handleAddToCart(<?= $product['product_id'] ?>)" class="w-full py-5 border border-black text-[10px] uppercase tracking-[0.4em] hover:bg-black hover:text-white transition-all duration-500 bg-white text-black">
                        Add to Bag
                    </button>

                    
                    <div class="space-y-6 pt-8 border-t border-black/10">
                        <p class="text-[14px] leading-relaxed text-black/90 font-serif italic">
                            <?= esc($product['description']) ?>
                        </p>
                        <div class="space-y-4">
                            <h2 class="text-[10px] uppercase tracking-[0.3em] font-medium">Details</h2>
                            <ul class="text-[10px] space-y-3 uppercase tracking-[0.2em] text-black/60">
                                <li>Size: <?= esc($product['size']) ?></li>
                                <li>Stock: <?= esc($product['stock']) ?> pcs</li>
                                <li>Category: <?= esc($product['category_type'] ?? 'General') ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <section class="mt-64">
        <h2 class="text-2xl font-serif italic text-center mb-24 font-light">Latest Products</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12">
            <?php foreach ($latestProducts as $item) : ?>
            <a href="<?= base_url('detail/' . $item['product_id']) ?>" class="group cursor-pointer space-y-6">
                <div class="aspect-[3/4] overflow-hidden bg-gray-50 border-thin">
                    <img 
                        alt="<?= esc($item['name_product']) ?>" 
                        class="w-full h-full object-cover grayscale transition-transform duration-700 group-hover:scale-105" 
                        src="<?= base_url('uploads/' . $item['image']) ?>" 
                    />
                </div>
                <div class="flex justify-between text-[10px] uppercase tracking-[0.2em]">
                    <span><?= esc($item['name_product']) ?></span>
                    <span class="opacity-40">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<script>
let selectedSize = null;

function selectSize(size) {
    selectedSize = size;
    document.querySelectorAll('.size-option').forEach(btn => {
        btn.classList.remove('font-bold', 'border-b', 'border-black');
        btn.classList.add('opacity-40');
    });
    
    const btn = event.currentTarget; 
    btn.classList.add('font-bold', 'border-b', 'border-black');
    btn.classList.remove('opacity-40');
}

function increaseQty() {
    const qtySpan = document.getElementById('quantity');
    qtySpan.textContent = parseInt(qtySpan.textContent) + 1;
}

function decreaseQty() {
    const qtySpan = document.getElementById('quantity');
    let qty = parseInt(qtySpan.textContent);
    if (qty > 1) qtySpan.textContent = qty - 1;
}

function handleAddToCart(productId) {
    if (!selectedSize) {
        alert('Please select a size first!');
        return;
    }
    const quantity = parseInt(document.getElementById('quantity').textContent);
    
    addToCart(productId, quantity, selectedSize);
}
</script>

<?= $this->endSection() ?>