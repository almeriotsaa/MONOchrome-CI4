<aside class="w-20 lg:w-64 border-r border-mono-border h-screen sticky top-0 flex flex-col bg-white">
    <div class="p-8 border-b border-mono-border flex items-center gap-3">
        <div class="h-8 w-8 bg-black flex items-center justify-center text-white font-bold text-xl">M</div>
        <div class="hidden lg:flex flex-col">
            <span class="text-sm font-bold tracking-widest leading-none">MONO</span>
            <span class="text-[10px] text-gray-400 font-medium tracking-tighter uppercase mt-1">Management</span>
        </div>
    </div>
    
    <nav class="flex-1 px-4 py-8 space-y-2">
        <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center gap-4 px-4 py-3 <?= uri_string() == 'admin/dashboard' ? 'bg-black text-white' : 'text-black hover:bg-mono-gray' ?> transition-colors">
            <span class="material-symbols-outlined text-lg">dashboard</span>
            <span class="hidden lg:inline text-[11px] font-bold tracking-widest uppercase">Overview</span>
        </a>
        
        <a href="<?= base_url('admin/orders') ?>" class="flex items-center gap-4 px-4 py-3 <?= strpos(uri_string(), 'admin/orders') === 0 ? 'bg-black text-white' : 'text-black hover:bg-mono-gray' ?> transition-colors">
            <span class="material-symbols-outlined text-lg">shopping_bag</span>
            <span class="hidden lg:inline text-[11px] font-bold tracking-widest uppercase">Orders</span>
        </a>
        
        <a href="<?= base_url('admin/products') ?>" class="flex items-center gap-4 px-4 py-3 <?= strpos(uri_string(), 'admin/products') === 0 ? 'bg-black text-white' : 'text-black hover:bg-mono-gray' ?> transition-colors">
            <span class="material-symbols-outlined text-lg">inventory_2</span>
            <span class="hidden lg:inline text-[11px] font-bold tracking-widest uppercase">Products</span>
        </a>
        
        <a href="<?= base_url('admin/customers') ?>" class="flex items-center gap-4 px-4 py-3 <?= strpos(uri_string(), 'admin/customers') === 0 ? 'bg-black text-white' : 'text-black hover:bg-mono-gray' ?> transition-colors">
            <span class="material-symbols-outlined text-lg">group</span>
            <span class="hidden lg:inline text-[11px] font-bold tracking-widest uppercase">Customers</span>
        </a>
        
        <div class="pt-8 pb-4">
            <span class="hidden lg:block px-4 text-[9px] text-gray-400 font-bold tracking-widest uppercase mb-2">System</span>
        </div>
        
        <a href="#" class="flex items-center gap-4 px-4 py-3 text-black hover:bg-mono-gray transition-colors">
            <span class="material-symbols-outlined text-lg">settings</span>
            <span class="hidden lg:inline text-[11px] font-bold tracking-widest uppercase">Settings</span>
        </a>
    </nav>
    
    <div class="p-6 border-t border-mono-border">
        <div class="flex items-center gap-3">
            <div class="size-10 bg-mono-gray border border-mono-border flex items-center justify-center overflow-hidden">
                <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDu9yYRzPr4SarL46pB-I7T69GDkObY1QNijSW-6Go6qEqya9zsc5Yrf19IOASVlCAINBKDJcwzP3hHC7Ufwo_Z_6ddgXyTxi6a61OHZ67ZCRQBH-reI_md7wXsqllGHmEuCes7QVA_Nz9obF44tIwLCcUw6wdvRXr9K2-ah9wki_QFQrmuzdmS7lf_oiB2uILS63ck_SHCEga0gXWpe3lRqI_zs-uYYfQ1bhkUkfGDPF6QBZLIMRxbW-K4wCuDY8owflHomibE2_c" />
            </div>
            <div class="hidden lg:block">
                <p class="text-[11px] font-bold uppercase tracking-wider"><?= session()->get('name') ?></p>
                <p class="text-[9px] text-gray-500 uppercase">Administrator</p>
            </div>
        </div>
    </div>
</aside>