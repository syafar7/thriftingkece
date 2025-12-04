<?php
require_once ROOT_PATH . '/app/Models/Product.php';

class ProductController {
    
    // 1. HALAMAN KATALOG (INDEX)
    public function index() {
        $db = (new Database())->getConnection();
        $model = new Product($db);
        
        $keyword = $_GET['q'] ?? '';
        $category = $_GET['cat'] ?? '';

        $products = $model->getAll($keyword, $category);
        
        require_once ROOT_PATH . '/views/home/index.php';
    }

    // 2. HALAMAN DETAIL PRODUK
    public function detail() {
        $id = $_GET['id'] ?? null;
        if($id) {
            $db = (new Database())->getConnection();
            
            // 1. Produk
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$product) { header("Location: /"); exit; }

            // 2. Chat
            $stmtChat = $db->prepare("SELECT discussions.*, users.name, users.role 
                                      FROM discussions JOIN users ON discussions.user_id = users.id 
                                      WHERE product_id = ? ORDER BY created_at ASC");
            $stmtChat->execute([$id]);
            $chats = $stmtChat->fetchAll(PDO::FETCH_ASSOC);

            // 3. Wishlist
            $isWishlisted = false;
            if (isset($_SESSION['user_id'])) {
                $stmtWish = $db->prepare("SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?");
                $stmtWish->execute([$_SESSION['user_id'], $id]);
                if ($stmtWish->rowCount() > 0) $isWishlisted = true;
            }

            // 4. === TAMBAHAN: REVIEW & RATING ===
            // Kita panggil model Review manual disini (teknik cepat)
            require_once ROOT_PATH . '/app/Models/Review.php';
            $reviewModel = new Review($db);
            $reviews = $reviewModel->getByProduct($id);
            $ratingStats = $reviewModel->getAverageRating($id); // Dapat avg_rating & total

            require_once ROOT_PATH . '/views/home/detail.php';
        } else {
            header("Location: /");
        }
    }
}
?>