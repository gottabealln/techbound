<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config/site.php';
require_once __DIR__ . '/lib/auth.php';

admin_session_start();
if (admin_current()) {
    header('Location: ' . admin_home_url());
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $pass  = (string)($_POST['password'] ?? '');
    try {
        if (!admin_login($email, $pass)) {
            $error = 'Invalid email address or password. Please try again.';
        } else {
            header('Location: ' . admin_home_url());
            exit;
        }
    } catch (Throwable $e) {
        $error = 'Authentication service error: ' . $e->getMessage();
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TechBound Innovations</title>
    <meta name="description" content="Secure administrative login for TechBound Innovations management.">
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#00e599',
                        brandHover: '#00f0a0',
                        darkNavy: '#06121e',
                        surfaceCard: '#0d1e30',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #06121e;
            background-image: 
                radial-gradient(at 0% 0%, rgba(0, 229, 153, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(29, 78, 216, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(6, 18, 30, 0.95) 0%, #040c14 100%);
            min-height: 100vh;
        }
        .glow-pulse {
            animation: pulseGlow 3s infinite ease-in-out;
        }
        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.3); opacity: 1; }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-between min-h-screen p-4 sm:p-6 text-slate-200 font-sans antialiased">

    <!-- Top spacer / back link -->
    <header class="w-full max-w-md pt-2 flex items-center justify-between">
        <a href="<?= e(url('index.php')) ?>" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-brand transition-colors group">
            <span class="material-symbols-outlined text-[16px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
            <span>Back to TechBound Website</span>
        </a>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-brand text-[11px] font-semibold uppercase tracking-wider">
            <span class="w-1.5 h-1.5 rounded-full bg-brand glow-pulse"></span>
            CMS Portal
        </span>
    </header>

    <!-- Main Login Card Container -->
    <main class="w-full max-w-md my-auto py-6">
        <div class="bg-surfaceCard/90 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-6 sm:p-8 relative overflow-hidden">
            
            <!-- Subtle top accent bar -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-400 via-brand to-blue-500"></div>

            <!-- Card Header -->
            <div class="flex flex-col items-center text-center mb-6">
                <a href="<?= e(url('index.php')) ?>" class="inline-block mb-3 hover:opacity-90 transition-opacity">
                    <img src="<?= e(url('assets/logo_techbound.png')) ?>" alt="TechBound Logo" class="h-9 w-auto object-contain">
                </a>
                <h1 class="text-xl sm:text-2xl font-bold font-heading text-white tracking-tight">Admin Authentication</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Sign in to manage inbound leads, content, and agency settings</p>
            </div>

            <!-- Error Banner -->
            <?php if ($error): ?>
            <div class="mb-5 p-3.5 rounded-xl bg-red-500/15 border border-red-500/30 text-red-300 text-xs sm:text-sm flex items-start gap-2.5 animate-shake">
                <span class="material-symbols-outlined text-[18px] text-red-400 shrink-0 mt-0.5">error</span>
                <span><?= e($error) ?></span>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="" class="space-y-4" novalidate>

                <!-- Email Field -->
                <div>
                    <label for="admin-email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                        Email Address
                    </label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-[20px] pointer-events-none">mail</span>
                        <input 
                            type="email" 
                            id="admin-email" 
                            name="email" 
                            required 
                            autofocus
                            autocomplete="email"
                            placeholder="admin@techbound.in" 
                            value="<?= e($_POST['email'] ?? '') ?>"
                            class="w-full pl-11 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder:text-slate-500 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all"
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="admin-password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                            Password
                        </label>
                    </div>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-[20px] pointer-events-none">lock</span>
                        <input 
                            type="password" 
                            id="admin-password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••••••" 
                            class="w-full pl-11 pr-11 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder:text-slate-500 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all"
                        >
                        <!-- Password Toggle Button -->
                        <button 
                            type="button" 
                            id="togglePassword" 
                            aria-label="Toggle password visibility" 
                            class="absolute right-3 p-1 text-slate-400 hover:text-white transition-colors"
                        >
                            <span id="pwdIcon" class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-3.5 px-4 bg-brand hover:bg-brandHover text-darkNavy font-heading font-bold text-sm sm:text-base rounded-xl shadow-lg shadow-brand/20 hover:shadow-brand/30 active:scale-[0.99] transition-all flex items-center justify-center gap-2"
                    >
                        <span>Sign In to Dashboard</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>

            </form>

            <!-- Card Bottom Note -->
            <div class="mt-6 pt-5 border-t border-white/10 flex items-center justify-between text-[11px] text-slate-500">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px] text-emerald-400">lock</span>
                    
                </span>
                <span>Trivandrum, Kerala</span>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-md pb-2 text-center text-xs text-slate-500">
        <p>&copy; <?= date('Y') ?> TechBound Innovations. Internal Administrative System.</p>
    </footer>

    <!-- Password visibility toggle script -->
    <script>
        const pwdInput = document.getElementById('admin-password');
        const pwdToggle = document.getElementById('togglePassword');
        const pwdIcon = document.getElementById('pwdIcon');

        if (pwdInput && pwdToggle && pwdIcon) {
            pwdToggle.addEventListener('click', function() {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                pwdIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
            });
        }
    </script>

</body>
</html>
