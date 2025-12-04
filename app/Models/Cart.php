<?php
class Cart {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    // 1. TAMBAH ITEM (Cek duplikasi size)
    public function add($userId, $productId, $size, $qty = 1) {
        // Cek apakah barang yang sama (ID Produk & Size SAMA) sudah ada?
        $stmt = $this->conn->prepare("SELECT id, quantity FROM carts WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->execute([$userId, $productId, $size]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Kalau ada, update jumlahnya (tambah qty)
            $newQty = $existing['quantity'] + $qty;
            $update = $this->conn->prepare("UPDATE carts SET quantity = ? WHERE id = ?");
            return $update->execute([$newQty, $existing['id']]);
        } else {
            // Kalau belum, insert baru
            $insert = $this->conn->prepare("INSERT INTO carts (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)");
            return $insert->execute([$userId, $productId, $size, $qty]);
        }
    }

    // 2. AMBIL DATA KERANJANG (JOIN Produk)
    public function getUserCart($userId) {
        // PENTING: Kita ambil 'carts.id' sebagai 'cart_id' agar bisa dihapus per item
        $sql = "SELECT carts.id as cart_id, carts.quantity as qty, carts.size, 
                       products.id as product_id, products.name, products.price, products.image 
                FROM carts 
                JOIN products ON carts.product_id = products.id 
                WHERE carts.user_id = ? 
                ORDER BY carts.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. HAPUS SATU ITEM (Tong Sampah Kecil)
    public function remove($cartId, $userId) {
        // Hapus berdasarkan ID Keranjang (cart_id), bukan Product ID
        $stmt = $this->conn->prepare("DELETE FROM carts WHERE id = ? AND user_id = ?");
        return $stmt->execute([$cartId, $userId]);
    }

    // 4. HAPUS SEMUA (Tombol Hapus Semua / Setelah Checkout)
    public function clear($userId) {
        $stmt = $this->conn->prepare("DELETE FROM carts WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }

    // 5. HITUNG TOTAL ITEM (Untuk Badge Merah di Header)
    public function countItem($userId) {
        $stmt = $this->conn->prepare("SELECT SUM(quantity) FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() ?: 0;
    }
}
?>