<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-10 fade-in">
    <div class="container mx-auto px-6 max-w-xl">
        
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Edit Profil</h1>
            <p class="text-gray-500 text-sm">Perbarui informasi akun dan pengirimanmu.</p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            
            <form action="/profile/update" method="POST">
                
                <input type="hidden" name="redirect_target" value="<?= $redirect ?? '' ?>">

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="<?= $user['name'] ?>" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-indigo-500 transition" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="text" value="<?= $user['email'] ?>" class="w-full border border-gray-200 px-4 py-2 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed" disabled>
                    <small class="text-gray-400">Email tidak dapat diubah.</small>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">No. Handphone</label>
                    <input type="text" name="phone" value="<?= $user['phone'] ?? '' ?>" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-indigo-500 transition" placeholder="Contoh: 08123456789">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" class="w-full border border-gray-300 px-4 py-2 rounded-lg h-28 focus:outline-none focus:border-indigo-500 transition" placeholder="Jalan, Nomor Rumah, RT/RW, Kota, Kode Pos"><?= $user['address'] ?? '' ?></textarea>
                </div>

                <hr class="my-6 border-gray-100">

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:border-indigo-500 transition" placeholder="Biarkan kosong jika tidak ingin mengganti">
                </div>

                <div class="flex gap-4">
                    <a href="<?= (!empty($redirect) && $redirect == 'checkout') ? '/checkout' : '/account' ?>" 
                       class="w-1/3 text-center py-3 rounded-lg bg-gray-100 text-gray-600 font-bold hover:bg-gray-200 transition">
                       Batal
                    </a>
                    
                    <button type="submit" class="w-2/3 bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 shadow-lg transition">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>