<?php
class Product {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function getAll($keyword = null, $category = null, $minPrice = null, $maxPrice = null, $size = null) {
        $sql = "SELECT * FROM products WHERE 1=1"; 
        $params = [];
        if (!empty($keyword)) { $sql .= " AND name LIKE ?"; $params[] = "%$keyword%"; }
        if (!empty($category)) { $sql .= " AND category = ?"; $params[] = $category; }
        if (is_numeric($minPrice) && $minPrice > 0) { $sql .= " AND price >= ?"; $params[] = $minPrice; }
        if (is_numeric($maxPrice) && $maxPrice > 0) { $sql .= " AND price <= ?"; $params[] = $maxPrice; }
        if (!empty($size)) { $sql .= " AND size LIKE ?"; $params[] = "%$size%"; }
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO products (name, description, price, discount_price, category, size, stock, image) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$data['name'], $data['description'], $data['price'], $data['discount_price'], $data['category'], $data['size'], $data['stock'], $data['image']]);
    }

    public function update($id, $data) {
        if ($data['image']) {
            $sql = "UPDATE products SET name=?, description=?, price=?, discount_price=?, category=?, size=?, stock=?, image=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$data['name'], $data['description'], $data['price'], $data['discount_price'], $data['category'], $data['size'], $data['stock'], $data['image'], $id]);
        } else {
            $sql = "UPDATE products SET name=?, description=?, price=?, discount_price=?, category=?, size=?, stock=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$data['name'], $data['description'], $data['price'], $data['discount_price'], $data['category'], $data['size'], $data['stock'], $id]);
        }
    }
    
    // === PERBAIKAN UTAMA: HAPUS BERSIH (CASCADE MANUAL) ===
    public function delete($id) {
        try {
            // 1. Cek apakah ada PESANAN AKTIF? (Hanya order_items yang kita cek ketat)
            // Jika produk ada di order yang statusnya BUKAN cancelled, tolak hapus.
            $checkOrder = $this->conn->prepare("
                SELECT oi.id FROM order_items oi 
                JOIN orders o ON oi.order_id = o.id 
                WHERE oi.product_id = ? AND o.status != 'cancelled'
            ");
            $checkOrder->execute([$id]);
            
            if ($checkOrder->rowCount() > 0) {
                return false; // Gagal karena masih ada transaksi aktif
            }

            // 2. BERSIHKAN TABEL LAIN (Cart, Wishlist, Chat, Review)
            // Kita hapus paksa datanya di tabel pendukung agar produk bisa dihapus
            $this->conn->prepare("DELETE FROM carts WHERE product_id = ?")->execute([$id]);
            $this->conn->prepare("DELETE FROM wishlists WHERE product_id = ?")->execute([$id]);
            $this->conn->prepare("DELETE FROM discussions WHERE product_id = ?")->execute([$id]);
            $this->conn->prepare("DELETE FROM reviews WHERE product_id = ?")->execute([$id]);
            
            // Hapus history order items yang sudah cancelled/selesai (Opsional, agar benar-benar bersih)
            // $this->conn->prepare("DELETE FROM order_items WHERE product_id = ?")->execute([$id]); 
            
            // 3. BARU HAPUS PRODUK UTAMA
            $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
            return $stmt->execute([$id]);

        } catch(PDOException $e) {
            return false;
        }
    }
}
?>
