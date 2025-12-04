<?php
require_once ROOT_PATH . '/app/Models/User.php';

class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = (new Database())->getConnection();
            $userModel = new User($db);
            $user = $userModel->login($_POST['email'], $_POST['password']);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name']; 
                
                if ($user['role'] == 'admin') header("Location: /admin");
                else header("Location: /");
                exit;
            } else {
                $error = "Email atau Password salah!";
                require_once ROOT_PATH . '/views/auth/login.php';
            }
        } else {
            require_once ROOT_PATH . '/views/auth/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = (new Database())->getConnection();
            $userModel = new User($db);
            
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
                $error = "Semua kolom wajib diisi!";
                require_once ROOT_PATH . '/views/auth/register.php';
                return;
            }

            if ($userModel->register($_POST['name'], $_POST['email'], $_POST['password'])) {
                $_SESSION['flash_success'] = "Akun berhasil dibuat! Silakan login.";
                header("Location: /login");
            } else {
                $error = "Gagal mendaftar. Email mungkin sudah dipakai.";
                require_once ROOT_PATH . '/views/auth/register.php';
            }
        } else {
            require_once ROOT_PATH . '/views/auth/register.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /");
    }

    public function account() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        $db = (new Database())->getConnection();
        $stmtUser = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmtUser->execute([$_SESSION['user_id']]);
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/auth/account.php';
    }

    public function orders() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        $db = (new Database())->getConnection();
        $stmtOrder = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmtOrder->execute([$_SESSION['user_id']]);
        $myOrders = $stmtOrder->fetchAll(PDO::FETCH_ASSOC);
        require_once ROOT_PATH . '/views/auth/orders.php';
    }

    // === TAMPILKAN FORM EDIT (Tangkap parameter ?redirect=checkout) ===
    public function editProfile() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }
        
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Kirim variabel $redirect ke View
        $redirect = $_GET['redirect'] ?? ''; // default kosong
        
        require_once ROOT_PATH . '/views/auth/edit_profile.php';
    }

    // === PROSES UPDATE (Cek mau balik kemana) ===
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) { header("Location: /login"); exit; }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $password = $_POST['password'];
            
            // Ambil parameter redirect dari input hidden
            $redirectTarget = $_POST['redirect_target'] ?? ''; 

            $db = (new Database())->getConnection();
            
            // Logika Update (Password vs Non-Password)
            if (!empty($password)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET name=?, phone=?, address=?, password=? WHERE id=?");
                $stmt->execute([$name, $phone, $address, $hash, $_SESSION['user_id']]);
            } else {
                $stmt = $db->prepare("UPDATE users SET name=?, phone=?, address=? WHERE id=?");
                $stmt->execute([$name, $phone, $address, $_SESSION['user_id']]);
            }

            $_SESSION['name'] = $name;
            $_SESSION['flash_success'] = "Profil diperbarui!";

            // === LOGIKA REDIRECT PINTAR ===
            if ($redirectTarget == 'checkout') {
                header("Location: /checkout"); // Balik ke checkout
            } else {
                header("Location: /account");  // Balik ke akun biasa
            }
            exit;
        }
    }
}
?>