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
            $error = 'Invalid email address or password.';
        } else {
            header('Location: ' . admin_home_url());
            exit;
        }
    } catch (Throwable $e) {
        $error = 'Unable to sign in right now. Please check the database connection.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | TechBound Admin</title>
    <meta name="description" content="Sign in to TechBound Innovations Admin.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="<?= e(asset('assets/favicon.png')) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= e(asset('assets/favicon.png')) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= e(asset('assets/apple-touch-icon.png')) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#1b8c43',
                        brandHover: '#157336',
                    },
                    fontFamily: {
                        sans: ['Lato', 'sans-serif'],
                        heading: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#f6f7f6] text-gray-900 font-sans antialiased min-h-screen flex flex-col justify-between px-4 py-8">

    <div class="w-full max-w-sm mx-auto">
        <a href="<?= e(url('index.php')) ?>" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-900 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Back to website</span>
        </a>
    </div>

    <main class="w-full max-w-sm mx-auto my-auto py-8">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 sm:p-8">

            <div class="mb-6">
                <a href="<?= e(url('index.php')) ?>" class="inline-block mb-5">
                    <img src="<?= e(url('assets/logo_techbound.png')) ?>" alt="TechBound" class="h-8 w-auto object-contain">
                </a>
                <h1 class="text-xl font-heading font-semibold text-gray-900">Sign in</h1>
                <p class="text-sm text-gray-500 mt-1">Enter your admin credentials to continue.</p>
            </div>

            <?php if ($error): ?>
            <div class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm flex items-start gap-2">
                <span class="material-symbols-outlined text-[18px] text-red-600 shrink-0 mt-0.5">error</span>
                <span><?= e($error) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4" novalidate>
                <div>
                    <label for="admin-email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input
                        type="email"
                        id="admin-email"
                        name="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="you@techbound.in"
                        value="<?= e($_POST['email'] ?? '') ?>"
                        class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm placeholder:text-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 transition-colors"
                    >
                </div>

                <div>
                    <label for="admin-password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative flex items-center">
                        <input
                            type="password"
                            id="admin-password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-900 text-sm placeholder:text-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 transition-colors"
                        >
                        <button
                            type="button"
                            id="togglePassword"
                            aria-label="Toggle password visibility"
                            class="absolute right-2.5 p-1 text-gray-400 hover:text-gray-700 transition-colors"
                        >
                            <span id="pwdIcon" class="material-symbols-outlined text-[19px]">visibility</span>
                        </button>
                    </div>
                </div>

                <div class="pt-1">
                    <button
                        type="submit"
                        class="w-full py-2.5 px-4 bg-brand hover:bg-brandHover text-white font-heading font-medium text-sm rounded-lg transition-colors"
                    >
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="w-full max-w-sm mx-auto text-center text-xs text-gray-400">
        <p>&copy; <?= date('Y') ?> TechBound Innovations</p>
    </footer>

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
