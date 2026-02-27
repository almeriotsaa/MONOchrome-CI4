<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed | Fashion Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body class="bg-white text-black font-sans">
    <div class="max-w-2xl mx-auto p-8 lg:p-20 text-center">
        <div class="mb-12">
            <span class="material-symbols-outlined text-6xl font-extralight text-black">done_all</span>
            <h1 class="text-[14px] uppercase tracking-[0.6em] font-bold mt-6">Order Received</h1>
            <p class="text-[9px] text-gray-400 mt-3 uppercase tracking-[0.3em]">Reference Number: #<?= $order['order_id'] ?></p>
        </div>

        <div class="border border-black p-10 space-y-8 text-left mb-12 bg-[#fafafa]">
            <div class="flex justify-between border-b border-black pb-6">
                <span class="text-[10px] uppercase tracking-widest font-semibold text-gray-500">Total Amount</span>
                <span class="text-[16px] font-bold">Rp <?= number_format($order['total'], 0, ',', '.') ?></span>
            </div>

            <div class="space-y-4">
                <span class="text-[9px] uppercase tracking-[0.2em] text-gray-500 block">Bank Transfer Instructions</span>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 border border-dashed border-black/20 bg-white">
                    <div>
                        <span class="text-[12px] font-bold uppercase tracking-widest block mb-1"><?= $order['provider'] ?></span>
                        <span id="accNumber" class="text-[20px] font-mono font-bold tracking-tighter text-black"><?= $order['account_number'] ?></span>
                    </div>
                    
                    <button onclick="copyToClipboard()" class="flex items-center justify-center gap-2 px-6 py-3 border border-black text-[9px] uppercase tracking-widest hover:bg-black hover:text-white transition-all active:scale-95">
                        <span class="material-symbols-outlined text-sm">content_copy</span> Copy Number
                    </button>
                </div>
            </div>

            <div class="pt-2 text-[10px] leading-relaxed text-gray-400 italic font-light text-center">
                *Please complete your payment within 24 hours. Orders not settled within this timeframe will be automatically cancelled.
            </div>
        </div>

        <div class="space-y-4">
            <a href="<?= base_url('checkout/confirm-payment/' . $order['order_id']) ?>" class="inline-block w-full md:w-auto px-16 py-5 bg-black text-white text-[9px] uppercase tracking-[0.4em] hover:bg-gray-800 transition-all shadow-lg shadow-black/10">
                Confirm Payment
            </a>
        </div>
    </div>

    <script>
// --- SCRIPT PENGUNCI HALAMAN (STUCK MODE) ---
    (function (global) {
        if (typeof (global) === "undefined") {
            throw new Error("window is undefined");
        }

        var _hash = "!";
        var noBackPlease = function () {
            global.location.href += "#";

            // Membuat delay kecil untuk mendorong history state
            global.setTimeout(function () {
                global.location.href += "!";
            }, 50);
        };

        // Menjebak perubahan hash URL
        global.onhashchange = function () {
            if (global.location.hash !== _hash) {
                global.location.hash = _hash;
            }
        };

        global.onload = function () {
            noBackPlease();

            // Mencegah back menggunakan PushState
            history.pushState(null, null, document.URL);
            window.addEventListener('popstate', function () {
                // Saat tombol back ditekan, paksa balik ke halaman ini lagi
                history.pushState(null, null, document.URL);
            });
        };
    })(window);

        // --- 2. SCRIPT COPY (Lama) ---
        function copyToClipboard() {
            const textToCopy = "<?= $order['account_number'] ?>";
            navigator.clipboard.writeText(textToCopy).then(() => {
                alert("Account number copied to clipboard.");
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</body>
</html>