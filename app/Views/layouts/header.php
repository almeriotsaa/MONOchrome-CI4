<?php helper('cart'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= $this->renderSection('title') ?> | MONO</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400;1,6..96,400&amp;family=Inter:wght@300;400&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style type="text/tailwindcss">
        @layer base {
            body {
                @apply bg-white text-black;
                font-family: 'Inter', sans-serif;
            }
            .font-serif-luxury {
                font-family: 'Bodoni+Moda', serif;
                font-weight: 300;
            }
        }
        .nav-link {
            @apply text-[9px] uppercase tracking-[0.4em] font-light transition-opacity hover:opacity-50;
        }
        .border-thin {
            border: 0.5px solid black;
        }
        .border-thin-b {
            border-bottom: 0.5px solid black;
        }
        .border-thin-t {
            border-top: 0.5px solid black;
        }
        .product-card:hover .product-info {
            opacity: 1;
        }
        .cart-sidebar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body class="antialiased">
    <nav class="fixed top-0 w-full z-50 bg-white/95 border-thin-b">
        <div class="max-w-[1800px] mx-auto px-12 h-16 flex items-center justify-between">

            <div class="flex items-center space-x-12 text-sm font-serif-luxury tracking-[0.3em] uppercase">
                <a href="<?= base_url('/') ?>">MONO</a>
            </div>
            <div class="flex items-center space-x-12">
                <a class="nav-link" href="<?= base_url('collection') ?>">Shop</a>
                <button class="nav-link" onclick="toggleCart()" id="cartToggle">Cart (<span id="cartCount"><?= count_cart() ?></span>)</button>
                <?php if (session()->get('logged_in')): ?>
                    <div class="relative group inline-block">
                        <button class="nav-link flex items-center gap-2">
                            <span><?= session()->get('name') ?></span>
                            <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
                        </button>

                        <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-black 
                opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                transition-all duration-200 z-50">

                            <?php if (session()->get('role') == 'admin'): ?>
                                <a href="<?= base_url('admin/dashboard') ?>"
                                    class="block px-4 py-2 text-[10px] uppercase tracking-widest hover:bg-black hover:text-white">
                                    Dashboard
                                </a>
                            <?php endif; ?>

                            <a href="<?= base_url('logout') ?>"
                                class="block px-4 py-2 text-[10px] uppercase tracking-widest hover:bg-black hover:text-white">
                                Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?= $this->include('cart/sidebar') ?>

    <?= $this->renderSection('content') ?>

    <footer class="bg-white px-12 py-24 border-thin-t">
        <div class="max-w-[1800px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-24">
            <div class="space-y-4">
                <span class="nav-link block">Studio</span>
                <p class="text-[9px] uppercase tracking-[0.3em] font-light text-black/40 leading-relaxed">
                    A01, Avenue de l'Esprit<br />Paris, France
                </p>
            </div>
            <div class="space-y-4">
                <span class="nav-link block">Follow</span>
                <div class="flex space-x-8">
                    <a class="nav-link" href="#">Instagram</a>
                    <a class="nav-link" href="#">Journal</a>
                </div>
            </div>
            <div class="space-y-4 md:text-right">
                <span class="nav-link block">Legal</span>
                <p class="text-[9px] uppercase tracking-[0.3em] font-light text-black/40">
                    © 2024 MONO. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

<script>

    function toggleCart() {
        document.getElementById('cartSidebar').classList.toggle('translate-x-full');
    }


    async function addToCart(productId, quantity, size) {
        const response = await fetch('<?= base_url('cart/add') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ product_id: productId, quantity: quantity, size: size })
        });
        const data = await response.json();
        if (data.success) {
            updateCartCount(data.cart_count);
            loadCartItems();
            toggleCart();
        }
    }

  
    async function loadCartItems() {
        const response = await fetch('<?= base_url('cart/get') ?>');
        const data = await response.json();
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');

        if (data.items && data.items.length > 0) {
            cartItems.innerHTML = data.items.map(item => `
                <div class="flex gap-4 border-b border-black/10 pb-4">
                    <div class="w-20 h-24 bg-gray-100">
                        <img src="<?= base_url('uploads/') ?>${item.image}" class="w-full h-full object-cover grayscale">
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[10px] uppercase tracking-widest font-bold">${item.name}</h4>
                        <p class="text-[9px] text-black/60 mt-1 uppercase">Size: ${item.size}</p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-[9px]">${item.quantity} x Rp ${item.price.toLocaleString()}</span>
                        </div>
                        <button onclick="removeFromCart('${item.id}', '${item.size}')" 
                                class="text-[8px] uppercase tracking-widest text-red-500 mt-2 cursor-pointer hover:underline">
                            Remove
                        </button>
                    </div>
                </div>
            `).join('');
            if(cartTotal) cartTotal.textContent = `Rp ${data.total.toLocaleString()}`;
        } else {
            cartItems.innerHTML = '<p class="text-center text-[10px] uppercase tracking-widest text-black/40 py-8">Your cart is empty</p>';
            if(cartTotal) cartTotal.textContent = 'Rp 0';
        }
    }


    async function removeFromCart(id, size) {
        if (!confirm('Remove this item?')) return;
        const response = await fetch('<?= base_url('cart/remove') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ product_id: id, size: size })
        });
        const data = await response.json();
        if (data.success) {
            updateCartCount(data.cart_count);
            loadCartItems();
        } else {
            alert("Gagal: " + (data.message || "Error"));
        }
    }

    function updateCartCount(count) {
        const elem = document.getElementById('cartCount');
        if(elem) elem.textContent = count;
    }

    document.addEventListener('DOMContentLoaded', loadCartItems);
</script>
</body>

</html>