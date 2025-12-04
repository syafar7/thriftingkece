<?php
session_start();

// 1. Setup Root Path & Autoload
define('ROOT_PATH', dirname(__DIR__)); 

require_once ROOT_PATH . '/app/Config/Database.php';
require_once ROOT_PATH . '/app/Core/Router.php';

// 2. Load Semua Controller
require_once ROOT_PATH . '/app/Controllers/HomeController.php';
require_once ROOT_PATH . '/app/Controllers/AuthController.php';
require_once ROOT_PATH . '/app/Controllers/ProductController.php';
require_once ROOT_PATH . '/app/Controllers/CartController.php';
require_once ROOT_PATH . '/app/Controllers/AdminController.php';
require_once ROOT_PATH . '/app/Controllers/WishlistController.php';
require_once ROOT_PATH . '/app/Controllers/DiscussionController.php';
require_once ROOT_PATH . '/app/Controllers/ReviewController.php';

$router = new Router();

// === A. HALAMAN UTAMA (USER) ===
$router->add('/', 'HomeController', 'index');
$router->add('/product', 'ProductController', 'detail');

// === B. AUTENTIKASI ===
$router->add('/login', 'AuthController', 'login');
$router->add('/register', 'AuthController', 'register');
$router->add('/logout', 'AuthController', 'logout');

// === C. AKUN PENGGUNA ===
$router->add('/account', 'AuthController', 'account');       // Biodata
$router->add('/orders', 'AuthController', 'orders');         // Riwayat Pesanan
$router->add('/profile/edit', 'AuthController', 'editProfile');
$router->add('/profile/update', 'AuthController', 'updateProfile');

// === D. KERANJANG & CHECKOUT ===
// ...
$router->add('/cart', 'CartController', 'index');
$router->add('/cart/add', 'CartController', 'add');
$router->add('/cart/remove', 'CartController', 'remove');
$router->add('/cart/clear', 'CartController', 'clear'); // <-- TAMBAHAN BARU
$router->add('/cart/buy-now', 'CartController', 'buyNow');
// ...
$router->add('/checkout', 'CartController', 'checkout');           // Halaman Konfirmasi
$router->add('/checkout/process', 'CartController', 'processCheckout'); // Proses Simpan
$router->add('/payment', 'CartController', 'payment');             // Halaman Bayar
$router->add('/order/confirm-payment', 'CartController', 'confirmPayment'); // User Konfirmasi Bayar

// === E. FITUR TAMBAHAN (Wishlist, Chat, Review) ===
$router->add('/wishlist', 'WishlistController', 'index');
$router->add('/wishlist/toggle', 'WishlistController', 'toggle');
$router->add('/discussion/send', 'DiscussionController', 'send');
$router->add('/review/submit', 'ReviewController', 'submit');

// === F. ADMIN PANEL (FULL FITUR) ===

// 1. Dashboard Utama
$router->add('/admin', 'AdminController', 'index');

// 2. Manajemen Produk
$router->add('/admin/products', 'AdminController', 'products');
$router->add('/admin/create', 'AdminController', 'create');
$router->add('/admin/store', 'AdminController', 'store');
$router->add('/admin/edit', 'AdminController', 'edit');
$router->add('/admin/update', 'AdminController', 'update');
$router->add('/admin/delete', 'AdminController', 'delete');

// 3. Manajemen Pesanan
$router->add('/admin/orders', 'AdminController', 'orders');
$router->add('/admin/order-detail', 'AdminController', 'orderDetail');
$router->add('/admin/order-update', 'AdminController', 'updateOrder');
$router->add('/admin/delete-order', 'AdminController', 'deleteOrder');
$router->add('/admin/order/accept', 'AdminController', 'acceptPayment'); // Admin Terima Uang

// 4. Manajemen Pembayaran (Bank/QRIS)
$router->add('/admin/payments', 'AdminController', 'payments');
$router->add('/admin/payments/create', 'AdminController', 'createPayment');
$router->add('/admin/payments/store', 'AdminController', 'storePayment');
$router->add('/admin/payments/edit', 'AdminController', 'editPayment');
$router->add('/admin/payments/update', 'AdminController', 'updatePayment');
$router->add('/admin/payments/delete', 'AdminController', 'deletePayment');

// 5. Manajemen Diskusi
$router->add('/admin/discussions', 'AdminController', 'discussions');
$router->add('/admin/reply', 'AdminController', 'replyChat'); // <--- RUTE BARU INI

// === JALANKAN ROUTER ===
$router->dispatch($_SERVER['REQUEST_URI']);
?>