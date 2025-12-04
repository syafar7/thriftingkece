<?php
class Wishlist {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    // Cek status
    public function isWishlisted($userId, $productId) {
        $stmt = $this->conn->prepare("SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        return $stmt->rowCount() > 0;
    }

    // Toggle (Tambah/Hapus)
    public function toggle($userId, $productId) {
        if ($this->isWishlisted($userId, $productId)) {
            $stmt = $this->conn->prepare("DELETE FROM wishlists WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            return "removed"; // Mengembalikan status 'dihapus'
        } else {
            $stmt = $this->conn->prepare("INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)");
            $stmt->execute([$userId, $productId]);
            return "added"; // Mengembalikan status 'ditambah'
        }
    }

    // Ambil list produk
    public function getByUser($userId) {
        $query = "SELECT products.* FROM wishlists 
                  JOIN products ON wishlists.product_id = products.id 
                  WHERE wishlists.user_id = ? ORDER BY wishlists.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // === TAMBAHAN BARU: HITUNG JUMLAH WISHLIST UNTUK HEADER ===
    public function countByUser($userId) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM wishlists WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
}
?>