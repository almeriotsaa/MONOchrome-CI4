<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MONO - Register</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&amp;family=Bodoni+Moda:opsz,wght@6..96,400;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .mono-logo {
            font-family: 'Bodoni Moda', serif;
            letter-spacing: 0.15em;
        }
    </style>
</head>
<body class="bg-white text-black">
    <div class="relative flex min-h-screen w-full flex-col items-center justify-center p-6">
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 w-full max-w-[360px] p-4 bg-red-50 border border-red-200">
                <p class="text-[10px] text-red-600 uppercase tracking-widest text-center">
                    <?= session()->getFlashdata('error') ?>
                </p>
            </div>
        <?php endif; ?>
        
        <div class="mb-16 text-center">
            <a href="<?= base_url('/') ?>">
                <h1 class="mono-logo text-5xl md:text-6xl font-bold uppercase tracking-[0.2em] text-black">
                    MONO
                </h1>
            </a>
            <p class="mt-4 text-[10px] uppercase tracking-[0.4em] text-zinc-400 font-medium">
                Create new account
            </p>
        </div>
        
        <div class="w-full max-w-[360px] flex flex-col gap-8">
            <form action="<?= base_url('register') ?>" method="post" class="flex flex-col gap-6">
                <?= csrf_field() ?>
                
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-semibold uppercase tracking-[0.1em] text-zinc-500" for="name">
                        Full Name
                    </label>
                    <input class="w-full bg-transparent border-t-0 border-x-0 border-b border-zinc-200 p-0 py-3 text-sm font-light focus:ring-0 focus:border-black" 
                           id="name" name="name" placeholder="John Doe" type="text" required 
                           value="<?= old('name') ?>" />
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-semibold uppercase tracking-[0.1em] text-zinc-500" for="email">
                        Email Address
                    </label>
                    <input class="w-full bg-transparent border-t-0 border-x-0 border-b border-zinc-200 p-0 py-3 text-sm font-light focus:ring-0 focus:border-black" 
                           id="email" name="email" placeholder="john@example.com" type="email" required 
                           value="<?= old('email') ?>" />
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-semibold uppercase tracking-[0.1em] text-zinc-500" for="password">
                        Password
                    </label>
                    <input class="w-full bg-transparent border-t-0 border-x-0 border-b border-zinc-200 p-0 py-3 text-sm font-light focus:ring-0 focus:border-black" 
                           id="password" name="password" placeholder="••••••••" type="password" required />
                </div>
                
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-semibold uppercase tracking-[0.1em] text-zinc-500" for="confirm_password">
                        Confirm Password
                    </label>
                    <input class="w-full bg-transparent border-t-0 border-x-0 border-b border-zinc-200 p-0 py-3 text-sm font-light focus:ring-0 focus:border-black" 
                           id="confirm_password" name="confirm_password" placeholder="••••••••" type="password" required />
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="w-full h-12 bg-black text-white text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-zinc-800 transition-all duration-300">
                        Register
                    </button>
                </div>
            </form>
            
            <div class="flex flex-col items-center gap-4">
                <p class="text-[9px] text-zinc-400 uppercase tracking-widest">
                    Already have an account? 
                    <a href="<?= base_url('login') ?>" class="text-black hover:underline">Sign In</a>
                </p>
            </div>
        </div>
        
        <div class="fixed top-8 right-8">
            <a href="<?= base_url('/') ?>" class="text-[9px] uppercase tracking-widest hover:underline">
                Back to Site
            </a>
        </div>
    </div>
</body>
</html>