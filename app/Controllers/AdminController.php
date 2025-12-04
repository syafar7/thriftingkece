<?php
require_once ROOT_PATH . '/app/Models/Product.php';

class AdminController {
    
    public function __construct() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header("Location: /login"); exit;
        }
    }

    // --- 1. DASHBOARD ---
    public function index() {
        $db = (new Database())->getConnection();
        $totalProduk = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $totalOrder = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $pendapatan = $db->query("SELECT SUM(total_price) FROM orders WHERE status = 'completed'")->fetchColumn();
        $stmt = $db->query("SELECT orders.*, users.name as user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC LIMIT 5");
        $recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/admin/dashboard.php';
    }

    // --- 2. PRODUK ---
    public function products() {
        $db = (new Database())->getConnection();
        $products = (new Product($db))->getAll();
        require_once ROOT_PATH . '/views/admin/products/index.php';
    }
    public function create() { require_once ROOT_PATH . '/views/admin/create.php'; }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $imageUrl = null;
            if (!empty($_FILES['image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $target = ROOT_PATH . "/public/images/" . $fileName;
                if (!file_exists(ROOT_PATH . "/public/images/")) mkdir(ROOT_PATH . "/public/images/", 0777, true);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) $imageUrl = "/images/" . $fileName;
            }
            $size = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : "";
            $data = [
                'name' => $_POST['name'], 'description' => $_POST['description'], 'price' => $_POST['price'],
                'category' => $_POST['category'], 'size' => $size, 'stock' => $_POST['stock'],
                'discount_price' => $_POST['discount_price'] ?? 0, 'image' => $imageUrl
            ];
            $db = (new Database())->getConnection();
            (new Product($db))->create($data);
            $_SESSION['flash_success'] = "Produk berhasil ditambah!";
            header("Location: /admin/products");
        }
    }
    public function edit() {
        $id = $_GET['id'];
        $db = (new Database())->getConnection();
        $product = (new Product($db))->getById($id);
        require_once ROOT_PATH . '/views/admin/edit.php';
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $db = (new Database())->getConnection();
            $imageUrl = null;
            if (!empty($_FILES['image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $target = ROOT_PATH . "/public/images/" . $fileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) $imageUrl = "/images/" . $fileName;
            }
            $size = isset($_POST['sizes']) ? implode(',', $_POST['sizes']) : "";
            $data = [
                'name' => $_POST['name'], 'description' => $_POST['description'], 'price' => $_POST['price'],
                'category' => $_POST['category'], 'size' => $size, 'stock' => $_POST['stock'],
                'discount_price' => $_POST['discount_price'] ?? 0, 'image' => $imageUrl
            ];
            (new Product($db))->update($id, $data);
            $_SESSION['flash_success'] = "Produk diperbarui!";
            header("Location: /admin/products");
        }
    }
    public function delete() {
        $id = $_GET['id'];
        $db = (new Database())->getConnection();
        if (!(new Product($db))->delete($id)) $_SESSION['flash_error'] = "Gagal! Produk sedang dipesan.";
        else $_SESSION['flash_success'] = "Produk dihapus.";
        header("Location: /admin/products");
    }

    // --- 3. PESANAN ---
    public function orders() {
        $db = (new Database())->getConnection();
        $stmt = $db->query("SELECT orders.*, users.name as user_name FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/admin/orders/index.php';
    }
    public function orderDetail() {
        $id = $_GET['id'];
        $db = (new Database())->getConnection();
        $stmtOrder = $db->prepare("SELECT orders.*, users.name, users.email, users.phone, users.address FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = ?");
        $stmtOrder->execute([$id]);
        $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);
        
        // FIX: Ambil size dari order_items, bukan products
        $stmtItems = $db->prepare("SELECT order_items.qty, order_items.price, order_items.size, products.name, products.image FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = ?");
        $stmtItems->execute([$id]);
        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/admin/order_detail.php';
    }
    public function updateOrder() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];
            $resi = empty($_POST['resi']) ? null : $_POST['resi'];
            $db = (new Database())->getConnection();
            $db->prepare("UPDATE orders SET status=?, tracking_number=? WHERE id=?")->execute([$status, $resi, $id]);
            $_SESSION['flash_success'] = "Pesanan diupdate!";
            header("Location: /admin/order-detail?id=" . $id);
        }
    }
    public function acceptPayment() {
        $id = $_GET['id'];
        $db = (new Database())->getConnection();
        $db->prepare("UPDATE orders SET status='packed' WHERE id=?")->execute([$id]);
        $_SESSION['flash_success'] = "Pembayaran Diterima!";
        header("Location: /admin/order-detail?id=" . $id);
    }
    public function deleteOrder() {
        $id = $_GET['id'];
        $db = (new Database())->getConnection();
        $db->prepare("DELETE FROM order_items WHERE order_id=?")->execute([$id]);
        $db->prepare("DELETE FROM orders WHERE id=?")->execute([$id]);
        $_SESSION['flash_success'] = "Pesanan dihapus.";
        header("Location: /admin/orders");
    }

    // --- 4. PEMBAYARAN ---
    public function payments() {
        $db = (new Database())->getConnection();
        $payments = $db->query("SELECT * FROM payment_methods ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/admin/payments/index.php';
    }
    public function createPayment() { require_once ROOT_PATH . '/views/admin/payments/create.php'; }
    public function storePayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $logoUrl = "";
            if (!empty($_FILES['logo_image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['logo_image']['name']);
                $target = ROOT_PATH . "/public/images/" . $fileName;
                if (move_uploaded_file($_FILES['logo_image']['tmp_name'], $target)) $logoUrl = "/images/" . $fileName;
            }
            $accNum = ($_POST['type'] == 'bank') ? $_POST['account_number'] : '-';
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("INSERT INTO payment_methods (bank_name, account_number, account_holder, logo_url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['bank_name'], $accNum, $_POST['account_holder'], $logoUrl]);
            $_SESSION['flash_success'] = "Metode pembayaran ditambah!";
            header("Location: /admin/payments");
        }
    }
    public function editPayment() {
        $id = $_GET['id'];
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("SELECT * FROM payment_methods WHERE id=?");
        $stmt->execute([$id]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/admin/payments/edit.php';
    }
    public function updatePayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("SELECT logo_url FROM payment_methods WHERE id=?");
            $stmt->execute([$id]);
            $logoUrl = $stmt->fetch(PDO::FETCH_ASSOC)['logo_url'];
            if (!empty($_FILES['logo_image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['logo_image']['name']);
                $target = ROOT_PATH . "/public/images/" . $fileName;
                if (move_uploaded_file($_FILES['logo_image']['tmp_name'], $target)) $logoUrl = "/images/" . $fileName;
            }
            $accNum = ($_POST['type'] == 'bank') ? $_POST['account_number'] : '-';
            $stmt = $db->prepare("UPDATE payment_methods SET bank_name=?, account_number=?, account_holder=?, logo_url=? WHERE id=?");
            $stmt->execute([$_POST['bank_name'], $accNum, $_POST['account_holder'], $logoUrl, $id]);
            $_SESSION['flash_success'] = "Metode pembayaran diupdate!";
            header("Location: /admin/payments");
        }
    }
    public function deletePayment() {
        $id = $_GET['id'];
        $db = (new Database())->getConnection();
        $db->prepare("DELETE FROM payment_methods WHERE id=?")->execute([$id]);
        $_SESSION['flash_success'] = "Dihapus.";
        header("Location: /admin/payments");
    }

    // --- 5. DISKUSI (FIX ALIAS COLUMN) ---
    public function discussions() {
        $db = (new Database())->getConnection();
        // FIX: Tambahkan 'as total_chat' dan 'as last_activity'
        $sql = "SELECT p.id, p.name, p.image, 
                       COUNT(d.id) as total_chat, 
                       MAX(d.created_at) as last_activity 
                FROM discussions d 
                JOIN products p ON d.product_id = p.id 
                GROUP BY p.id 
                ORDER BY last_activity DESC";
        $chatList = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/admin/discussions.php';
    }
    public function replyChat() {
        $productId = $_GET['product_id'];
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmtChat = $db->prepare("SELECT discussions.*, users.name, users.role FROM discussions JOIN users ON discussions.user_id = users.id WHERE product_id = ? ORDER BY created_at ASC");
        $stmtChat->execute([$productId]);
        $chats = $stmtChat->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/admin/products/reply.php';
    }
}
?>