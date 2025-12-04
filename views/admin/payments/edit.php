<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<?php
    // Logika deteksi tipe awal (Bank atau QRIS)
    // Jika ada logo_url, kemungkinan besar QRIS/E-Wallet. Jika kosong, Bank.
    $currentType = (!empty($payment['logo_url'])) ? 'qris' : 'bank';
?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        
        <main class="flex-1 p-8 fade-in flex justify-center pb-24">
            
            <div class="w-full max-w-lg bg-white p-8 rounded-xl shadow-lg border border-gray-100 h-fit">
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Metode Pembayaran</h1>
                
                <form action="/admin/payments/update" method="POST" enctype="multipart/form-data" class="space-y-5">
                    <input type="hidden" name="id" value="<?= $payment['id'] ?>">

                    <div>
                        <label class="block font-bold text-gray-700 mb-2 text-sm">Tipe Pembayaran</label>
                        <select name="type" id="paymentType" class="w-full border-2 border-indigo-100 p-2 rounded focus:outline-none focus:border-indigo-600 bg-white font-bold text-gray-700" onchange="toggleForm()">
                            <option value="bank" <?= $currentType == 'bank' ? 'selected' : '' ?>>Transfer Bank (Pakai Nomor)</option>
                            <option value="qris" <?= $currentType == 'qris' ? 'selected' : '' ?>>QRIS / E-Wallet (Pakai Gambar)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-sm">Nama Bank / E-Wallet</label>
                        <input type="text" name="bank_name" value="<?= $payment['bank_name'] ?>" class="w-full border p-2 rounded focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-sm">Atas Nama</label>
                        <input type="text" name="account_holder" value="<?= $payment['account_holder'] ?>" class="w-full border p-2 rounded focus:outline-none focus:border-indigo-500" required>
                    </div>

                    <div id="fieldBank" class="<?= $currentType == 'qris' ? 'hidden' : '' ?>">
                        <label class="block font-bold text-gray-700 mb-1 text-sm">Nomor Rekening</label>
                        <input type="text" name="account_number" value="<?= $payment['account_number'] == '-' ? '' : $payment['account_number'] ?>" class="w-full border p-2 rounded font-mono focus:outline-none focus:border-indigo-500">
                    </div>
                    
                    <div id="fieldQRIS" class="<?= $currentType == 'bank' ? 'hidden' : '' ?>">
                        <label class="block font-bold text-gray-700 mb-1 text-sm">Foto QR Code / Logo</label>
                        
                        <?php if(!empty($payment['logo_url'])): ?>
                            <div class="mb-3 text-center bg-gray-50 p-3 rounded border border-dashed">
                                <p class="text-xs text-gray-400 mb-2">Gambar Saat Ini:</p>
                                <img src="<?= $payment['logo_url'] ?>" class="h-32 mx-auto object-contain border bg-white p-1 rounded">
                            </div>
                        <?php endif; ?>

                        <div class="border-2 border-dashed border-gray-300 p-4 rounded text-center bg-gray-50 hover:bg-white transition">
                            <input type="file" name="logo_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <small class="text-gray-400 block mt-2 text-xs">Upload file baru jika ingin mengganti gambar.</small>
                        </div>
                    </div>
                    
                    <div class="pt-6 flex gap-3">
                        <a href="/admin/payments" class="w-1/3 bg-gray-100 text-gray-700 font-bold py-3 rounded-lg text-center hover:bg-gray-200 transition text-sm">Batal</a>
                        <button class="w-2/3 bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg text-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

        </main>

        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>

<script>
    function toggleForm() {
        const type = document.getElementById('paymentType').value;
        const fieldBank = document.getElementById('fieldBank');
        const fieldQRIS = document.getElementById('fieldQRIS');

        if (type === 'bank') {
            fieldBank.classList.remove('hidden');
            fieldQRIS.classList.add('hidden');
        } else {
            fieldBank.classList.add('hidden');
            fieldQRIS.classList.remove('hidden');
        }
    }
</script>