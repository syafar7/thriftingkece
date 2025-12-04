<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-10 fade-in">
    <div class="container mx-auto px-6 max-w-2xl">
        
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600 text-4xl shadow-sm animate-bounce">
                <i class="fas fa-check"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan Berhasil Dibuat!</h1>
            <p class="text-gray-500">Selesaikan pembayaranmu agar pesanan segera diproses.</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 text-center bg-white">
                <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Total Pembayaran</p>
                <p class="text-4xl font-bold text-indigo-600 mt-2">Rp <?= number_format($order['total_price']) ?></p>
                <div class="mt-3 inline-block bg-orange-50 text-orange-700 px-4 py-1 rounded-full text-xs font-bold border border-orange-100">
                    <i class="far fa-clock mr-1"></i> Bayar sebelum <?= date('H:i', strtotime('+24 hours')) ?> WIB
                </div>
            </div>

            <div class="p-8 bg-gray-50 text-center">
                
                <?php if($order['payment_method'] == 'COD'): ?>
                    <div class="bg-white border-2 border-orange-100 p-6 rounded-xl shadow-sm">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3 text-orange-500 text-2xl">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Bayar di Tempat</h3>
                        <p class="text-gray-600 text-sm mt-2 leading-relaxed">
                            Siapkan uang tunai pas sebesar <strong>Rp <?= number_format($order['total_price']) ?></strong>. 
                            <br>Kurir akan menagih saat paket sampai di alamatmu.
                        </p>
                    </div>

                <?php elseif ($bankInfo): ?>
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center justify-center gap-2">
                        Silakan Transfer ke:
                    </h3>
                    
                    <div class="bg-white border-2 border-indigo-100 p-6 rounded-xl shadow-sm inline-block w-full md:w-auto min-w-[300px]">
                        
                        <p class="text-xl font-bold text-indigo-700 mb-3 border-b pb-3 border-dashed">
                            <?= $bankInfo['bank_name'] ?>
                        </p>
                        
                        <?php if(!empty($bankInfo['logo_url'])): ?>
                            <p class="text-sm text-gray-500 mb-3 font-medium">Scan Kode QR Berikut:</p>
                            <div class="bg-white p-2 rounded-lg border border-gray-200 inline-block shadow-sm">
                                <img src="<?= $bankInfo['logo_url'] ?>" class="w-48 h-48 mx-auto object-contain">
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Gunakan aplikasi E-Wallet / Mobile Banking</p>

                        <?php else: ?>
                            <p class="text-sm text-gray-500 mb-1">Nomor Rekening</p>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 mb-3 relative group cursor-pointer hover:bg-gray-100 transition" onclick="navigator.clipboard.writeText('<?= $bankInfo['account_number'] ?>'); alert('Nomor disalin!');">
                                <p class="text-3xl font-mono font-bold text-gray-800 tracking-wider">
                                    <?= $bankInfo['account_number'] ?>
                                </p>
                                <span class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-400 opacity-0 group-hover:opacity-100 transition text-xs">
                                    <i class="far fa-copy"></i> Salin
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="mt-4 pt-3 border-t border-dashed">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wide">Atas Nama</p>
                            <p class="font-bold text-gray-700 text-lg"><?= $bankInfo['account_holder'] ?></p>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg border border-red-200">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Metode pembayaran tidak ditemukan atau telah dihapus. Silakan hubungi Admin.
                    </div>
                <?php endif; ?>

            </div>

            <div class="p-6 bg-white">
                <a href="/order/confirm-payment?id=<?= $order['id'] ?>" 
                    class="block w-full bg-indigo-600 text-white text-center py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg mb-3 flex items-center justify-center gap-2 transform hover:-translate-y-0.5"
                    data-confirm="Pastikan kamu sudah mentransfer dana sesuai nominal. Lanjutkan?">
                    <i class="fas fa-check-circle"></i> Saya Sudah Membayar
                </a>
                <a href="/" class="block w-full text-center text-gray-500 font-bold text-sm hover:text-indigo-600 transition p-2">
                    Belanja Lagi
                </a>
            </div>

        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>