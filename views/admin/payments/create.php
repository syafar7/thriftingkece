<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full">
        <main class="flex-1 overflow-y-auto p-6 md:p-8 fade-in custom-scroll flex justify-center">
            
            <div class="w-full max-w-lg bg-white p-8 rounded-xl shadow-sm border border-gray-100 h-fit">
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Pembayaran</h1>
                
                <form action="/admin/payments/store" method="POST" enctype="multipart/form-data" class="space-y-4">
                    
                    <div>
                        <label class="block font-bold text-gray-700 mb-2 text-sm">Tipe</label>
                        <select name="type" id="paymentType" class="w-full border p-2 rounded bg-gray-50 font-bold text-sm" onchange="toggleForm()">
                            <option value="bank">Transfer Bank</option>
                            <option value="qris">E-Wallet / QRIS</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-sm">Nama Bank / Wallet</label>
                        <input type="text" name="bank_name" class="w-full border p-2 rounded text-sm" placeholder="Contoh: BCA atau GoPay" required>
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-sm">Atas Nama</label>
                        <input type="text" name="account_holder" class="w-full border p-2 rounded text-sm" placeholder="Nama Pemilik" required>
                    </div>

                    <div id="fieldBank">
                        <label class="block font-bold text-gray-700 mb-1 text-sm">No. Rekening</label>
                        <input type="text" name="account_number" class="w-full border p-2 rounded font-mono text-sm" placeholder="12345678">
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1 text-sm">Logo Bank / Gambar QR</label>
                        <input type="file" name="logo_image" class="w-full border p-2 rounded bg-gray-50 text-sm">
                        <p class="text-xs text-gray-400 mt-1">Upload logo bank (opsional) atau QR Code (wajib jika QRIS).</p>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <a href="/admin/payments" class="w-1/3 bg-gray-100 text-gray-700 font-bold py-2 rounded text-center text-sm">Batal</a>
                        <button class="w-2/3 bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 text-sm">Simpan</button>
                    </div>
                </form>
            </div>

            <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
        </main>
    </div>
</div>

<script>
    function toggleForm() {
        const type = document.getElementById('paymentType').value;
        const bank = document.getElementById('fieldBank');
        if (type === 'bank') { bank.classList.remove('hidden'); }
        else { bank.classList.add('hidden'); }
    }
</script>