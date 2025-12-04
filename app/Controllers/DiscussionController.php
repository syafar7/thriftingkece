<?php
class DiscussionController {
    
    public function send() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['product_id'];
            $message = trim(htmlspecialchars($_POST['message']));

            if (!empty($message)) {
                $db = (new Database())->getConnection();
                $stmt = $db->prepare("INSERT INTO discussions (product_id, user_id, message) VALUES (?, ?, ?)");
                $stmt->execute([$productId, $_SESSION['user_id'], $message]);
            }

            if (isset($_POST['redirect_admin']) && $_POST['redirect_admin'] == 'true') {
                header("Location: /admin/reply?product_id=" . $productId);
            } else {
                header("Location: /product?id=" . $productId . "#chat-area");
            }
            exit;
        }
    }

    // FUNGSI HAPUS
    public function delete() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }

        $id = $_GET['id'] ?? null;
        $productId = $_GET['product_id'] ?? null;
        
        if ($id && $productId) {
            $db = (new Database())->getConnection();
            
            // Jika Admin: Hapus langsung
            if ($_SESSION['role'] == 'admin') {
                $stmt = $db->prepare("DELETE FROM discussions WHERE id = ?");
                $stmt->execute([$id]);
            } else {
                // Jika User: Hapus hanya punya sendiri
                $stmt = $db->prepare("DELETE FROM discussions WHERE id = ? AND user_id = ?");
                $stmt->execute([$id, $_SESSION['user_id']]);
            }
        }

        // REDIRECT BALIK KE HALAMAN YANG BENAR
        if ($_SESSION['role'] == 'admin') {
            header("Location: /admin/reply?product_id=" . $productId);
        } else {
            header("Location: /product?id=" . $productId . "#chat-area");
        }
        exit;
    }
}
?>
