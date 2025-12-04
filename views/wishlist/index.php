<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-10 fade-in">
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-heart text-red-500"></i> Wishlist Saya
        </h1>

        <?php if(empty($products)): ?>
            <div class="text-center py-20 bg-white rounded-xl shadow-sm">
                <i class="far fa-heart text-6xl text-gray-200 mb-4"></i>
                <p class="text-gray-500">Belum ada produk yang disukai.</p>
                <a href="/" class="text-indigo-600 font-bold mt-2 inline-block">Cari Produk Dulu</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <?php foreach($products as $p): ?>
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden group">
                    <div class="relative h-48">
                        <img src="<?= $p['image'] ?>" class="w-full h-full object-cover">
                        <a href="/wishlist/toggle?id=<?= $p['id'] ?>" class="absolute top-2 right-2 bg-white text-red-500 p-2 rounded-full shadow hover:bg-red-50 transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold truncate"><?= $p['name'] ?></h3>
                        <p class="text-indigo-600 font-bold">Rp <?= number_format($p['price']) ?></p>
                        <a href="/product?id=<?= $p['id'] ?>" class="block mt-3 text-center border border-indigo-600 text-indigo-600 py-1 rounded hover:bg-indigo-600 hover:text-white transition text-sm font-bold">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>