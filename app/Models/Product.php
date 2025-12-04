<?php
class Product {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    // UPDATE LOGIKA FILTER: Lebih Aman & Akurat
    public function getAll($keyword = null, $category = null, $minPrice = null, $maxPrice = null, $size = null) {
        $sql = "SELECT * FROM products WHERE 1=1"; // 1=1 trik agar mudah nambah AND
        $params = [];

        // 1. Filter Keyword (Nama)
        if (!empty($keyword)) {
            $sql .= " AND name LIKE ?";
            $params[] = "%$keyword%";
        }
        
        // 2. Filter Kategori
        if (!empty($category)) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        // 3. Filter Harga (Hanya jika diisi angka valid)
        // Jika user tidak isi, kita abaikan filter harga
        if (is_numeric($minPrice) && $minPrice > 0) {
            $sql .= " AND price >= ?";
            $params[] = $minPrice;
        }
        if (is_numeric($maxPrice) && $maxPrice > 0) {
            $sql .= " AND price <= ?";
            $params[] = $maxPrice;
        }

        // 4. Filter Ukuran (Pencarian Parsial)
        // Misal cari "M", akan ketemu di produk yg sizenya "S, M, L"
        if (!empty($size)) {
            $sql .= " AND size LIKE ?";
            $params[] = "%$size%";
        }

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
    
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
            return $stmt->execute([$id]);
        } catch(PDOException $e) { return false; }
    }
}
?>