<?php
// Panggil koneksi database
require_once '../app/Config/Database.php';

echo "<h1>Proses Reset Admin...</h1>";

try {
    $database = new Database();
    $db = $database->getConnection();

    // 1. Data Admin Baru
    $name = "Super Admin";
    $email = "admin@thrifting.com";
    $passwordRaw = "admin123"; // Password yang kita mau
    $passwordHash = password_hash($passwordRaw, PASSWORD_DEFAULT); // Enkripsi otomatis
    $role = "admin";

    // 2. Cek apakah email sudah ada?
    $check = $db->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    
    if($check->rowCount() > 0) {
        // UPDATE jika sudah ada
        $sql = "UPDATE users SET password = ?, role = 'admin' WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$passwordHash, $email]);
        echo "<p style='color:green'>✅ Akun <b>$email</b> sudah ada. Password di-reset menjadi: <b>$passwordRaw</b></p>";
    } else {
        // INSERT jika belum ada
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$name, $email, $passwordHash, $role]);
        echo "<p style='color:green'>✅ Akun <b>$email</b> berhasil DIBUAT BARU. Password: <b>$passwordRaw</b></p>";
    }

    echo "<hr><a href='/thriftingapp/login'>KLIK DISINI UNTUK LOGIN</a>";

} catch (Exception $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}
?>