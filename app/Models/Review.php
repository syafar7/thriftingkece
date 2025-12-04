<?php
class Review {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    // Simpan Review Baru
    public function create($userId, $productId, $rating, $comment) {
        $stmt = $this->conn->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $productId, $rating, $comment]);
    }

    // Ambil Review per Produk (Untuk ditampilkan di Detail)
    public function getByProduct($productId) {
        $stmt = $this->conn->prepare("SELECT reviews.*, users.name 
                                      FROM reviews 
                                      JOIN users ON reviews.user_id = users.id 
                                      WHERE product_id = ? 
                                      ORDER BY created_at DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hitung Rata-rata Bintang
    public function getAverageRating($productId) {
        $stmt = $this->conn->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>