<?php
require_once ROOT_PATH . '/app/Models/Wishlist.php';

class WishlistController {
    
    // Tampilkan Halaman Wishlist
    public function index() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }

        $db = (new Database())->getConnection();
        $model = new Wishlist($db);
        $products = $model->getByUser($_SESSION['user_id']);

        require_once ROOT_PATH . '/views/wishlist/index.php';
    }

    // Proses Tambah/Hapus Wishlist (REVISI)
    public function toggle() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }

        $productId = $_GET['id'];
        $db = (new Database())->getConnection();
        $model = new Wishlist($db);
        
        // Simpan hasil toggle (added/removed)
        $status = $model->toggle($_SESSION['user_id'], $productId);
        
        // Set Notifikasi sesuai aksi
        if ($status == 'added') {
            $_SESSION['flash_success'] = "Produk berhasil disimpan ke Wishlist!";
        } else {
            $_SESSION['flash_success'] = "Produk dihapus dari Wishlist.";
        }
        
        // Redirect balik ke halaman sebelumnya
        header("Location: " . $_SERVER['HTTP_REFERER']); 
    }
}
?>