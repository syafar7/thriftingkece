<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThriftingKece - Admin Panel</title>
    
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234f46e5'%3E%3Cpath d='M13 2L3 14h9l-1 8 10-12h-9l1-8z'/%3E%3C/svg%3E">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700;800&family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    
    <style>
        body { font-family: 'Urbanist', sans-serif; background-color: #f8fafc; }
        .custom-scroll::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
        
        /* ADMIN SCROLL LOCK */
        <?php if (strpos($_SERVER['REQUEST_URI'], '/admin') !== false): ?>
            @media (min-width: 1024px) { body { overflow: hidden; height: 100vh; } }
        <?php endif; ?>
    </style>
</head>
<body class="text-slate-800 antialiased">

<?php 
    $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin');
    $isInAdminPath = strpos($_SERVER['REQUEST_URI'], '/admin') !== false;

    // Logic User (Wishlist/Cart)
    $wishlistCount = 0; $cartCount = 0;
    if (isset($_SESSION['user_id']) && !$isAdmin) {
        require_once ROOT_PATH . '/app/Config/Database.php';
        $db = (new Database())->getConnection();
        if (file_exists(ROOT_PATH . '/app/Models/Wishlist.php')) {
            require_once ROOT_PATH . '/app/Models/Wishlist.php';
            $wishlistCount = (new Wishlist($db))->countByUser($_SESSION['user_id']);
        }
        if (file_exists(ROOT_PATH . '/app/Models/Cart.php')) {
            require_once ROOT_PATH . '/app/Models/Cart.php';
            $cartCount = (new Cart($db))->countItem($_SESSION['user_id']);
        }
    }
?>

<?php if ($isAdmin && $isInAdminPath): ?>
    <nav class="fixed top-0 left-0 w-full h-16 bg-white border-b border-gray-200 z-[60] flex items-center justify-between px-4 lg:px-6 shadow-sm">
        
        <div class="flex items-center gap-4">
            <button id="mobileMenuBtn" onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-indigo-600 p-1 focus:outline-none transition">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <div class="text-xl font-extrabold text-indigo-600 tracking-tight flex items-center gap-2">
                <i class="fas fa-bolt"></i> 
                <span class="hidden md:inline">Thrift<span class="text-slate-800"></span></span>
                <span class="md:hidden">Thrift</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-[10px] text-gray-400 font-bold uppercase">Administrator</p>
                <p class="text-sm font-bold text-gray-700 truncate max-w-[100px] md:max-w-none">
                    Halo, <?= explode(' ', $_SESSION['name'] ?? 'Admin')[0] ?>
                </p>
            </div>
            <div class="w-9 h-9 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold border border-indigo-200 flex-shrink-0">A</div>
        </div>
    </nav>

<?php else: ?>
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100 shadow-sm h-20 flex items-center">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="/" class="text-3xl font-bold text-indigo-600 flex items-center gap-2 hover:scale-105 transition"><i class="fas fa-bolt"></i> Thrift.</a>
            <div class="flex items-center space-x-6">
                <a href="/" class="text-gray-600 font-bold hover:text-indigo-600 transition">Home</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="/wishlist" class="relative text-gray-500 hover:text-indigo-600 transition group">
                        <i class="far fa-bookmark text-2xl group-hover:scale-110 transition-transform duration-200"></i>
                        <?php if($wishlistCount > 0): ?><span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold border-2 border-white badge-animate"><?= $wishlistCount ?></span><?php endif; ?>
                    </a>
                    <a href="/cart" class="relative text-gray-500 hover:text-indigo-600 transition group">
                        <i class="fas fa-shopping-bag text-2xl"></i>
                        <?php if($cartCount > 0): ?><span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold border-2 border-white"><?= $cartCount ?></span><?php endif; ?>
                    </a>
                    <div class="h-6 w-px bg-gray-300 mx-2"></div>
                    <div class="relative group">
                        <button class="font-bold text-gray-700 flex items-center gap-2 py-4"><span>Hi, <?= explode(' ', $_SESSION['name'] ?? 'User')[0] ?></span><i class="fas fa-chevron-down text-xs text-gray-400"></i></button>
                        <div class="absolute right-0 mt-0 w-48 bg-white rounded-xl shadow-xl border border-gray-100 hidden group-hover:block z-50 overflow-hidden">
                            <a href="/account" class="block px-4 py-3 text-sm hover:bg-indigo-50 text-gray-700 flex items-center gap-2"><i class="far fa-user text-indigo-500 w-4"></i> Akun Saya</a>
                            <a href="/orders" class="block px-4 py-3 text-sm hover:bg-indigo-50 text-gray-700 flex items-center gap-2"><i class="fas fa-box-open text-indigo-500 w-4"></i> Pesanan</a>
                            <div class="border-t border-gray-100"></div>
                            <a href="/logout" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"><i class="fas fa-sign-out-alt w-4"></i> Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-gray-600 font-bold hover:text-indigo-600 text-sm">Masuk</a>
                    <a href="/register" class="bg-indigo-600 text-white px-6 py-2.5 rounded-full font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Daftar Sekarang</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
<?php endif; ?>

<main class="fade-in min-h-screen">