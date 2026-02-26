<!-- Cart Sidebar -->
<div id="cartSidebar" class="fixed top-0 right-0 w-full max-w-md h-full bg-white z-[60] border-l border-black transform translate-x-full transition-transform duration-300 cart-sidebar">
    <div class="flex flex-col h-full">
        <div class="p-8 border-b border-black flex justify-between items-center">
            <h2 class="text-[10px] uppercase tracking-[0.4em] font-bold">Shopping Cart</h2>
            <button onclick="closeCart()" class="material-symbols-outlined text-lg font-bold">X</button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-8 space-y-6" id="cartItems">
            <!-- Cart items will be loaded here dynamically -->
            <p class="text-center text-[10px] uppercase tracking-widest text-black/40 py-8">Loading cart...</p>
        </div>
        
        <div class="p-8 border-t border-black">
            <div class="flex justify-between items-center mb-6">
                <span class="text-[9px] uppercase tracking-widest">Subtotal</span>
                <span class="text-[11px] font-medium" id="cartTotal">Rp 0</span>
            </div>
            <button 
                onclick="window.location.href='<?= base_url('checkout') ?>'" 
                class="w-full py-4 bg-black text-white text-[9px] uppercase tracking-[0.4em] hover:bg-gray-900 transition-colors">
                Checkout
            </button>
            <button onclick="closeCart()" class="w-full py-4 mt-3 border border-black text-[9px] uppercase tracking-[0.4em] hover:bg-gray-100 transition-colors">
                Continue Shopping
            </button>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="cartOverlay" onclick="closeCart()" class="fixed inset-0 bg-black/20 z-[55] hidden"></div>

<script>
    function closeCart() {
        document.getElementById('cartSidebar').classList.add('translate-x-full');
        document.getElementById('cartOverlay').classList.add('hidden');
    }

    function toggleCart() {
        const sidebar = document.getElementById('cartSidebar');
        const overlay = document.getElementById('cartOverlay');
        sidebar.classList.toggle('translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>