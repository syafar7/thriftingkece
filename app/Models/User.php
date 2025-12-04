<?php
class User {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['password'])) return $user;
        return false;
    }

    public function register($name, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $hash]);
    }

    // === PERBAIKAN: FUNGSI UPDATE PROFIL YANG BENAR ===
    public function update($id, $name, $phone, $address, $password = null) {
        if ($password) {
            // Jika ganti password
            $sql = "UPDATE users SET name = ?, phone = ?, address = ?, password = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$name, $phone, $address, $password, $id]);
        } else {
            // Jika TIDAK ganti password (Hanya data diri)
            $sql = "UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$name, $phone, $address, $id]);
        }
    }
}
?>