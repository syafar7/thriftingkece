<?php
require_once ROOT_PATH . '/app/Models/Cart.php';

class CartController {

    public function index() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        $db = (new Database())->getConnection();
        $cart = (new Cart($db))->getUserCart($_SESSION['user_id']);
        require_once ROOT_PATH . '/views/cart/index.php';
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = (new Database())->getConnection();
            (new Cart($db))->add($_SESSION['user_id'], $_POST['product_id'], $_POST['size'], 1);
            $_SESSION['flash_success'] = "Masuk keranjang!";
            header("Location: /cart");
        }
    }

    public function buyNow() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = (new Database())->getConnection();
            (new Cart($db))->add($_SESSION['user_id'], $_POST['product_id'], $_POST['size'], 1);
            header("Location: /checkout");
        }
    }

    // === 1. FUNGSI HAPUS SATU ITEM ===
    public function remove() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        
        $cartId = $_GET['id'] ?? null; // Tangkap ID Keranjang
        
        if ($cartId) {
            $db = (new Database())->getConnection();
            $model = new Cart($db);
            $model->remove($cartId, $_SESSION['user_id']); // Hapus cuma ID itu
            $_SESSION['flash_success'] = "Item dihapus.";
        }
        header("Location: /cart");
    }

    // === 2. FUNGSI HAPUS SEMUA ===
    public function clear() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        
        $db = (new Database())->getConnection();
        $model = new Cart($db);
        $model->clear($_SESSION['user_id']); // Hapus semua milik user
        
        $_SESSION['flash_success'] = "Keranjang dikosongkan.";
        header("Location: /cart");
    }

    public function checkout() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        $db = (new Database())->getConnection();
        $cartModel = new Cart($db);
        $cartItems = $cartModel->getUserCart($_SESSION['user_id']);

        if (empty($cartItems)) { header("Location: /"); exit; }
        
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($user['address'])) {
            $_SESSION['flash_error'] = "Lengkapi alamat dulu!";
            header("Location: /profile/edit?redirect=checkout");
            exit;
        }

        $stmtPayment = $db->query("SELECT * FROM payment_methods"); 
        $paymentMethods = $stmtPayment->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/cart/checkout.php';
    }

    public function processCheckout() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        
        $paymentMethod = $_POST['payment_method']; 
        $db = (new Database())->getConnection();
        $cartModel = new Cart($db);
        $cartItems = $cartModel->getUserCart($_SESSION['user_id']);
        if (empty($cartItems)) { header("Location: /"); exit; }
        
        $total = 0;
        foreach($cartItems as $item) $total += ($item['price'] * $item['qty']);

        try {
            $stmt = $db->prepare("INSERT INTO orders (user_id, total_price, status, payment_method, shipping_address, created_at) VALUES (?, ?, 'pending', ?, ?, NOW())");
            $stmtUser = $db->prepare("SELECT address FROM users WHERE id = ?");
            $stmtUser->execute([$_SESSION['user_id']]);
            $userAddr = $stmtUser->fetchColumn();
            $stmt->execute([$_SESSION['user_id'], $total, $paymentMethod, $userAddr]);
            $orderId = $db->lastInsertId();

            $stmtItem = $db->prepare("INSERT INTO order_items (order_id, product_id, qty, price, size) VALUES (?, ?, ?, ?, ?)");
            $stmtStock = $db->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");

            foreach($cartItems as $item) {
                $stmtItem->execute([$orderId, $item['product_id'], $item['qty'], $item['price'], $item['size']]);
                $stmtStock->execute([$item['qty'], $item['product_id']]);
            }

            $cartModel->clear($_SESSION['user_id']); // Kosongkan keranjang stlh checkout
            header("Location: /payment?id=" . $orderId);
            exit;

        } catch (PDOException $e) { echo "Error: " . $e->getMessage(); }
    }

    public function payment() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        $orderId = $_GET['id'];
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
        $stmt->execute([$orderId, $_SESSION['user_id']]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$order) { header("Location: /"); exit; }
        $stmtBank = $db->prepare("SELECT * FROM payment_methods WHERE bank_name = ? LIMIT 1");
        $stmtBank->execute([$order['payment_method']]);
        $bankInfo = $stmtBank->fetch(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/cart/payment.php';
    }

    public function confirmPayment() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        $orderId = $_GET['id'];
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("UPDATE orders SET status = 'waiting_confirmation' WHERE id = ? AND user_id = ?");
        $stmt->execute([$orderId, $_SESSION['user_id']]);
        header("Location: /orders");
        exit;
    }
}
?>