<?= $this->extend('layouts/header') ?>
<?= $this->section('title') ?>Home<?= $this->endSection() ?>
<?= $this->section('content') ?>


<section class="h-screen w-full pt-16 px-12 pb-12">
    <div class="relative w-full h-full border-thin overflow-hidden group">
        <img alt="Editorial monochrome" class="w-full h-full object-cover grayscale brightness-90 transition-transform duration-[2000ms] group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBPdtQ4PiWMKeD8ewAg5ITYR43qe0aQmZYcEBUi5STh1LELWIG6GCrDPxF45dmKoG1ZE9_Zfaj42mCI8EOlzphJyOK33Tjyf4A6TOdFyfCIJmQdgLxBnU-A63P3ba5aoElP17NlS0OBuePWKloqislccYKAgHUbhz2NinFnkAUaJrciZPNQnpGbduHB2E16jC_q_pkIQklcs7FOsbk4rhriIYPGFf0krg0SoX1hw1sFZeEqroQ-PYMS6eHKB5sTWaMRmPNfYQQvwoE" />
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
            <div class="mb-4">
                <span class="font-serif-luxury text-2xl tracking-[0.8em] opacity-80">MONO</span>
            </div>
            <div class="mt-8">
                <a class="text-[9px] uppercase tracking-[0.6em] font-light hover:underline underline-offset-8" href="<?= base_url('collection') ?>">Enter</a>
            </div>
        </div>
    </div>
</section>


<section class="py-64 bg-white">
    <div class="max-w-[1200px] mx-auto px-12 text-center">
        <h1 class="font-serif-luxury text-5xl md:text-6xl italic leading-tight mb-16">The reduction to essentials.</h1>
        <p class="text-[10px] uppercase tracking-[0.5em] font-light max-w-lg mx-auto leading-loose text-black/60">
            A study of silhouette and texture. Eliminating the superfluous to reveal the architecture of form.
        </p>
    </div>
</section>


<section class="px-12 pb-64">
    <div class="max-w-[1800px] mx-auto">
        <div class="flex justify-between items-baseline mb-24 border-thin-b pb-4">
            <h2 class="font-serif-luxury text-4xl">New Arrivals</h2>
            <span class="text-[9px] uppercase tracking-[0.4em]">01 — 0<?= count($newArrivals) ?></span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-24">
            <?php foreach ($newArrivals as $item) : ?>
            <a href="<?= base_url('detail/' . $item['product_id']) ?>" class="group relative">
                <div class="aspect-[2/3] overflow-hidden bg-white border-thin">
                    <img 
                        alt="<?= esc($item['name_product']) ?>" 
                        class="w-full h-full object-cover grayscale" 
                        src="<?= base_url('uploads/' . $item['image']) ?>" 
                    />
                </div>
                <div class="product-info absolute inset-0 bg-white/90 flex flex-col items-center justify-center opacity-0 transition-opacity duration-500 pointer-events-none px-6 text-center">
                    <h4 class="text-[10px] uppercase tracking-[0.4em] mb-4"><?= esc($item['name_product']) ?></h4>
                    <p class="text-[10px] font-light tracking-widest text-black/60">
                        Rp <?= number_format($item['price'], 0, ',', '.') ?>
                    </p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<section class="px-12 pb-64">
    <div class="max-w-[1800px] mx-auto grid grid-cols-12 items-center gap-12">
        <div class="col-span-12 lg:col-span-7">
            <div class="aspect-[16/9] overflow-hidden border-thin">
                <img alt="Texture detail" class="w-full h-full object-cover grayscale" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDo4XKaNNSKD8jO-H9f7ojFc9esUA0ncOpCBqZZxBvIwDF5FrqJcUUjXrrJLm1f0NIIB1DSBLgupkGNxZdeS_W-E1qwPn13ARd-4GmzkeV8gYk2Fa1P5o1cV7IWCFnHU7l40PZteyJpqWyiyKEUI3m9YO-VsJaH3YDMx_0BLbHnTWRdVLOEssXLViVted3ZMChUfYa52O6GGX5F7ymCWHidgdB9y2pYnJxJExpnjSGFoUnzVfkslDbqtWU5vdbRNoAtx1ASiuIrYXI" />
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4 lg:col-start-9">
            <h3 class="font-serif-luxury text-4xl mb-8 leading-tight">Quiet confidence.</h3>
            <p class="text-[10px] uppercase tracking-[0.4em] font-light leading-loose text-black/60 mb-12">
                A curated selection for the modern wardrobe. Functional, lasting, and devoid of noise.
            </p>
            <a class="text-[9px] uppercase tracking-[0.4em] border-thin px-8 py-3 hover:bg-black hover:text-white transition-colors" href="<?= base_url('collection') ?>">Discover</a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>