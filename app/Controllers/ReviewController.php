<?php
require_once ROOT_PATH . '/app/Models/Review.php';

class ReviewController {
    
    public function submit() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'];
            $rating = $_POST['rating'];
            $comment = htmlspecialchars($_POST['comment']);

            $db = (new Database())->getConnection();
            $model = new Review($db);

            if ($model->create($_SESSION['user_id'], $productId, $rating, $comment)) {
                // Notifikasi Sukses
                $_SESSION['flash_success'] = "Terima kasih! Review berhasil dikirim.";
            }

            // Kembali ke halaman produk
            header("Location: /product?id=" . $productId);
            exit;
        }
    }
}
?>