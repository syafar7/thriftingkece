<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        <main class="flex-1 p-4 md:p-8 fade-in pb-24">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Dashboard Overview</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-indigo-500 flex justify-between items-center">
                    <div><p class="text-xs font-bold text-gray-500 uppercase">Produk</p><p class="text-2xl font-bold text-indigo-600"><?= $totalProduk ?></p></div>
                    <i class="fas fa-box text-3xl text-indigo-100"></i>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex justify-between items-center">
                    <div><p class="text-xs font-bold text-gray-500 uppercase">Pesanan</p><p class="text-2xl font-bold text-green-600"><?= $totalOrder ?></p></div>
                    <i class="fas fa-shopping-bag text-3xl text-green-100"></i>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 flex justify-between items-center">
                    <div><p class="text-xs font-bold text-gray-500 uppercase">Pendapatan</p><p class="text-2xl font-bold text-yellow-600">Rp <?= number_format($pendapatan) ?></p></div>
                    <i class="fas fa-wallet text-3xl text-yellow-100"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 font-bold text-gray-700 text-sm">Pesanan Terbaru</div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm min-w-[600px]">
                        <thead class="bg-white text-gray-500 border-b">
                            <tr><th class="p-4">ID</th><th class="p-4">Pembeli</th><th class="p-4">Total</th><th class="p-4">Status</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($recentOrders as $o): ?>
                            <tr class="hover:bg-gray-50 border-b last:border-0">
                                <td class="p-4 font-mono text-indigo-600">#<?= $o['id'] ?></td>
                                <td class="p-4"><?= $o['user_name'] ?></td>
                                <td class="p-4 font-bold">Rp <?= number_format($o['total_price']) ?></td>
                                <td class="p-4"><span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold uppercase"><?= $o['status'] ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>