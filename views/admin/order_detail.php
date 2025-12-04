<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        
        <main class="flex-1 p-8 fade-in pb-24">

            <?php if(isset($_SESSION['flash_success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm flex items-center gap-2 animate-bounce">
                    <i class="fas fa-check-circle text-xl"></i> 
                    <span class="font-bold"><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></span>
                </div>
            <?php endif; ?>

            <div class="mb-6 flex justify-between items-center">
                <a href="/admin/orders" class="text-gray-500 hover:text-indigo-600 font-bold flex items-center gap-2 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
                </a>
                <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #<?= $order['id'] ?></h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-indigo-600 px-6 py-3 text-white font-bold flex justify-between">
                            <span>Barang Dipesan</span>
                            <span><?= count($items) ?> Item</span>
                        </div>
                        <div class="p-6">
                            <table class="w-full text-sm text-left">
                                <thead class="text-gray-400 border-b"><tr><th>Produk</th><th>Size</th><th>Qty</th><th class="text-right">Harga</th></tr></thead>
                                <tbody class="divide-y">
                                    <?php foreach($items as $item): ?>
                                    <tr>
                                        <td class="py-3 font-bold flex items-center gap-3">
                                            <img src="<?= $item['image'] ?>" class="w-10 h-10 rounded border object-cover">
                                            <?= $item['name'] ?>
                                        </td>
                                        <td><?= $item['size'] ?></td>
                                        <td>x<?= $item['qty'] ?></td>
                                        <td class="text-right text-indigo-600 font-bold">Rp <?= number_format($item['price']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="pt-4 text-right font-bold text-gray-500">Total Pembayaran</td>
                                        <td class="pt-4 text-right font-bold text-2xl text-gray-800">Rp <?= number_format($order['total_price']) ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pengiriman</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">Penerima</p>
                                <p class="font-bold text-lg text-gray-700"><?= $order['name'] ?></p>
                                <p class="text-sm text-gray-500"><?= $order['email'] ?></p>
                                <p class="text-sm text-gray-500"><i class="fas fa-phone-alt mr-1"></i> <?= $order['phone'] ?? '-' ?></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">Alamat</p>
                                <div class="text-sm bg-gray-50 p-3 rounded border border-dashed text-gray-700 leading-relaxed">
                                    <?= $order['address'] ?? '<span class="text-red-500 italic">Alamat kosong</span>' ?>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 border-t pt-4">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Metode Pembayaran</p>
                            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-indigo-700 text-lg"><i class="fas fa-credit-card"></i> <?= $order['payment_method'] ?></span>
                                    <?php if($order['payment_method'] == 'COD'): ?>
                                        <span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded text-xs font-bold">Wajib Tagih</span>
                                    <?php else: ?>
                                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-bold">Cek Mutasi</span>
                                    <?php endif; ?>
                                </div>

                                <?php if($order['status'] == 'waiting_confirmation'): ?>
                                    <div class="flex items-center gap-3 animate-pulse">
                                        <span class="text-xs text-red-500 font-bold">User sudah konfirmasi bayar!</span>
                                        <a href="/admin/order/accept?id=<?= $order['id'] ?>" 
                                           class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-green-700 shadow-lg flex items-center gap-2"
                                           data-confirm="Konfirmasi uang sudah masuk? Status akan berubah jadi DIKEMAS.">
                                            <i class="fas fa-check-double"></i> Terima Pembayaran
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 sticky top-24">
                        <div class="p-4 bg-gray-50 border-b rounded-t-xl font-bold text-gray-700 flex items-center gap-2">
                            <i class="fas fa-tasks text-indigo-500"></i> Kelola Status
                        </div>

                        <form id="orderForm" action="/admin/order-update" method="POST" class="p-6" onsubmit="return validateOrder(event)">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            
                            <div class="mb-5">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status Pesanan</label>
                                <div class="relative">
                                    <select name="status" id="statusSelect" class="w-full border-2 border-gray-200 p-2 rounded-lg focus:outline-none focus:border-indigo-600 font-bold text-gray-700 bg-white appearance-none cursor-pointer">
                                        <option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>🟡 Menunggu Pembayaran</option>
                                        <option value="waiting_confirmation" <?= $order['status']=='waiting_confirmation'?'selected':'' ?>>🟠 Cek Pembayaran</option>
                                        <option value="packed" <?= $order['status']=='packed'?'selected':'' ?>>📦 Sedang Dikemas</option>
                                        <option value="sent" <?= $order['status']=='sent'?'selected':'' ?>>🚚 Sedang Dikirim</option>
                                        <option value="completed" <?= $order['status']=='completed'?'selected':'' ?>>✅ Selesai / Diterima</option>
                                        <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>❌ Dibatalkan</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><i class="fas fa-chevron-down text-xs"></i></div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nomor Resi (Tracking)</label>
                                <input type="text" name="resi" id="resiInput" value="<?= $order['tracking_number'] ?? '' ?>" 
                                       class="w-full border-2 border-gray-200 p-2 rounded-lg focus:outline-none focus:border-indigo-600 font-mono text-sm" 
                                       placeholder="Contoh: JP-12345678">
                                <p class="text-gray-400 text-[10px] mt-1">*Wajib diisi jika status diubah ke 'Dikirim'.</p>
                            </div>

                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg flex justify-center items-center gap-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </form>
                        
                        <div class="bg-gray-50 p-4 text-center text-xs text-gray-400 border-t rounded-b-xl">
                            Dipesan pada: <br>
                            <span class="font-mono font-bold text-gray-600"><?= date('d F Y, H:i', strtotime($order['created_at'])) ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>

<script>
    // Simpan status awal saat halaman dimuat (dari PHP)
    const initialStatus = "<?= $order['status'] ?>";

    function validateOrder(e) {
        const status = document.getElementById('statusSelect').value;
        const resi = document.getElementById('resiInput').value.trim();

        // VALIDASI 1: Jika status diubah jadi 'sent' (Dikirim), RESI WAJIB ISI
        if (status === 'sent' && resi === "") {
            e.preventDefault(); // Stop submit
            Swal.fire({
                icon: 'warning',
                title: 'Resi Kosong!',
                text: 'Anda mengubah status menjadi "Dikirim". Harap masukkan Nomor Resi terlebih dahulu.',
                confirmButtonColor: '#4f46e5'
            });
            return false;
        }

        // VALIDASI 2: Jika status masih 'waiting_confirmation' (User baru bayar),
        // Admin tidak boleh langsung ubah ke 'sent' atau 'packed' lewat dropdown ini.
        // Admin HARUS klik tombol hijau "Terima Pembayaran" dulu untuk verifikasi uang.
        if (initialStatus === 'waiting_confirmation' && (status === 'packed' || status === 'sent')) {
            e.preventDefault(); // Stop submit
            Swal.fire({
                icon: 'error',
                title: 'Prosedur Salah!',
                text: 'Status saat ini adalah "Cek Pembayaran". Harap klik tombol HIJAU "Terima Pembayaran" di atas untuk memverifikasi uang masuk terlebih dahulu.',
                confirmButtonColor: '#d33'
            });
            return false;
        }

        return true; // Lanjut submit
    }
</script>