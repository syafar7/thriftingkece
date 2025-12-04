# ⚡ ThriftingKece - Sistem E-Commerce Pakaian Thrift

## Kelompok & Anggota

* **Nama Kelompok**: (Kelompok 5_backlogagile)
* **Anggota**:

  * (SYAFARUDIN (701230101))
  * (RIZKI SURYA RAMADHAN(701230210))
  * (ANDHIKA PUTRA PRATAMA(701230303))

### Deskripsi Singkat
**ThriftingKece** adalah aplikasi berbasis web yang dirancang untuk memfasilitasi transaksi jual-beli pakaian bekas layak pakai (thrifting) secara digital. Aplikasi ini mentransformasi proses jual beli manual menjadi sistem terintegrasi yang mencakup manajemen stok, transaksi online, tawar-menawar (negosiasi), hingga pelacakan pengiriman.

### Tujuan & Permasalahan yang Diselesaikan
Sistem ini dibangun untuk menyelesaikan beberapa permasalahan utama dalam bisnis thrifting konvensional:
1.  **Manajemen Stok:** Menggantikan pencatatan manual dengan sistem database yang akurat dan *real-time*.
2.  **Negosiasi Terpusat:** Menyediakan fitur *chat* langsung di halaman produk, sehingga riwayat tawar-menawar tersimpan rapi dan tidak beralih ke aplikasi pesan luar.
3.  **Transparansi Transaksi:** Memberikan kejelasan status pesanan (Menunggu Bayar, Dikemas, Dikirim) dan pelacakan nomor resi bagi pembeli.
4.  **Keamanan:** Mencegah penipuan bukti transfer dengan adanya fitur verifikasi pembayaran manual oleh Admin sebelum barang dikirim.

## 🛠️ Teknologi yang Digunakan (Tech Stack)

Aplikasi ini dibangun menggunakan arsitektur **MVC (Model-View-Controller)** 3-Tier untuk memastikan kode yang bersih, aman, dan mudah dikembangkan.

* **Bahasa Pemrograman:** PHP 8.2 (Native)
* **Database:** MySQL 
* **Frontend Framework:** Tailwind CSS (via CDN)
* **Web Server:** Apache (XAMPP Bundle)
* **Fitur Tambahan:**
    * **SweetAlert2:** Untuk notifikasi popup interaktif (Alerts).
    * **FontAwesome:** Untuk ikon antarmuka.
    * **Google Fonts:** Tipografi (Outfit & Urbanist).
    * **PHP Session:** Manajemen autentikasi pengguna.

---
## 🚀 Fitur Utama (User Stories Implemented)

### 👤 Modul Pengguna (Pembeli)
* **Registrasi & Login:** Pendaftaran akun baru dan login aman dengan enkripsi password.
* **Katalog & Pencarian:** Mencari baju berdasarkan nama, kategori, rentang harga, dan ukuran.
* **Keranjang Belanja (Persistent):** Menyimpan barang yang ingin dibeli (tersimpan di database, tidak hilang saat ganti perangkat).
* **Wishlist:** Menyimpan produk favorit untuk dibeli nanti.
* **Checkout & Pembayaran:** Pilihan metode bayar dinamis (Transfer Bank, E-Wallet, COD) dan konfirmasi pembayaran.
* **Diskusi/Chat:** Fitur tawar-menawar langsung dengan penjual di halaman produk.
* **Lacak Pesanan:** Memantau status pesanan dan melihat nomor resi pengiriman.
* **Review Produk:** Memberikan rating bintang dan ulasan setelah barang diterima.

### 🛡️ Modul Admin (Penjual)
* **Dashboard:** Ringkasan statistik penjualan, total produk, dan pendapatan bersih.
* **Manajemen Produk:** Tambah, Edit, Hapus produk lengkap dengan upload gambar dan variasi ukuran.
* **Manajemen Pesanan:** Verifikasi bukti bayar, ubah status pesanan, dan input nomor resi.
* **Manajemen Pembayaran:** Menambah atau menghapus rekening bank/QRIS toko secara dinamis.
* **Manajemen Diskusi:** Melihat pesan masuk dari pembeli dan membalasnya.
* **Manajemen User:** Mereset password pengguna yang lupa kata sandi.

---

## Cara Menjalankan Aplikasi

### 1. Instalasi

1. Download atau clone repository ke komputer Anda.
2. Extract folder `thriftingapp` ke dalam direktori `htdocs` (untuk XAMPP) atau `www`/`public` sesuai environment lokal Anda.

### 2. Konfigurasi
### 1. Persiapan Lingkungan (Environment)
* Pastikan **XAMPP** (atau WAMP/MAMP) sudah terinstall.
* Pastikan **PHP versi 8.0** ke atas aktif.

### 2. Setup Database
1.  Buka **XAMPP Control Panel**, nyalakan module **Apache** dan **MySQL**.
2.  Buka browser, akses `http://localhost/phpmyadmin`.
3.  Buat database baru dengan nama: **`db_thrifting`**.
4.  Klik tab **Import**, pilih file **`db_thrifting.sql`** yang disertakan dalam folder proyek ini.
5.  Klik **Go/Kirim**.

### 3. Konfigurasi Koneksi
Buka file `app/Config/Database.php` dan pastikan kredensial sesuai:
```php
private $host = "localhost";
private $db_name = "db_thrifting";
private $username = "root";
private $password = ""; // Kosongkan jika default XAMPP

### 3. Menjalankan Aplikasi

1. Jalankan Apache & MySQL di XAMPP/Laragon.
2. Akses aplikasi melalui browser:

   ```
   http://localhost/thriftingapp
   ```

## Akun Demo 

**Admin**:

* Username: admin@thrifting.com
* Password: admin123

**User**:

* Username: user12@gmail.com
* Password: user123

## Alternatif menjalankan aplikasi
Buka Command Prompt (CMD) atau Terminal.

**Arahkan direktori ke folder project:
***cd C:\xampp\htdocs\thriftingapp
***Jalankan perintah berikut:

**php -S localhost:8000 -t public
**Buka browser dan akses alamat: http://localhost:8000

## Link Deployment / APK / Demo Video

* Demo Video: (isi link YouTube / Drive bila ada)
* Link Deployment: (isi bila aplikasi di-hosting)
* Link APK: (jika ada versi mobile)

## Catatan Tambahan

* Sistem masih dalam tahap pengembangan.
* Beberapa fitur mungkin belum sepenuhnya berjalan atau belum selesai.
* Gunakan akun admin untuk melakukan manajemen data dalam dashboard.
* Pastikan koneksi database sudah benar agar aplikasi berjalan normal.

## Keterangan Tugas

Project **ThriftingApp** ini dibuat untuk memenuhi **Tugas Final Project** mata kuliah **Rekayasa Perangkat Lunak**.

**Dosen Pengampu**: (Dila nurlaila,M.kom)

---

Copyright © 2025 ThriftingKece Development Team