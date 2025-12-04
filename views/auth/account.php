<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-10 fade-in">
    <div class="container mx-auto px-6 max-w-2xl">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Akun Saya</h1>
        <p class="text-gray-500 mb-8">Kelola informasi profil dan alamat pengiriman.</p>

        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            
            <div class="flex items-center gap-6 mb-8">
                <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-3xl">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800"><?= $user['name'] ?></h2>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Member Aktif</span>
                </div>
            </div>

            <div class="space-y-6">
                <div class="border-b pb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Email</label>
                    <p class="text-gray-800 font-medium"><?= $user['email'] ?></p>
                </div>
                
                <div class="border-b pb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">No. Handphone</label>
                    <p class="text-gray-800 font-medium">
                        <?= !empty($user['phone']) ? $user['phone'] : '<span class="text-red-400 italic">Belum diisi</span>' ?>
                    </p>
                </div>

                <div class="border-b pb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Alamat Pengiriman</label>
                    <p class="text-gray-800 font-medium leading-relaxed">
                        <?= !empty($user['address']) ? $user['address'] : '<span class="text-red-400 italic">Belum diisi (Wajib untuk pengiriman)</span>' ?>
                    </p>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <a href="/profile/edit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
                <a href="/logout" class="bg-gray-100 text-gray-600 px-6 py-3 rounded-lg font-bold hover:bg-red-100 hover:text-red-600 transition">
                    Logout
                </a>
            </div>

        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>