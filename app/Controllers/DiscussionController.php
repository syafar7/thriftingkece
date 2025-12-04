<?php
class DiscussionController {
    
    // Fungsi untuk memproses pesan masuk (Dari User maupun Admin)
    public function send() {
        
        // 1. Cek Login (Wajib Login untuk chat)
        if (!isset($_SESSION['user_id'])) { 
            header("Location: /login"); 
            exit; 
        }

        // 2. Proses hanya jika method POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $productId = $_POST['product_id'];
            $message = trim(htmlspecialchars($_POST['message'])); // Bersihkan input dari kode berbahaya

            // Simpan hanya jika pesan tidak kosong
            if (!empty($message)) {
                $db = (new Database())->getConnection();
                
                // Query Simpan Pesan
                $stmt = $db->prepare("INSERT INTO discussions (product_id, user_id, message) VALUES (?, ?, ?)");
                
                // Eksekusi Query
                $stmt->execute([$productId, $_SESSION['user_id'], $message]);
            }

            // 3. LOGIKA REDIRECT (PENTING!)
            // Cek apakah ada input hidden 'redirect_admin' yang dikirim dari form?
            // Input ini hanya ada di file views/admin/products/reply.php
            
            if (isset($_POST['redirect_admin']) && $_POST['redirect_admin'] == 'true') {
                // JIKA ADMIN: Balik ke halaman Admin Reply
                header("Location: /admin/reply?product_id=" . $productId);
            } else {
                // JIKA USER: Balik ke halaman Detail Produk (Scroll ke bawah)
                header("Location: /product?id=" . $productId . "#chat-area");
            }
            exit;
        }
    }
}
?>