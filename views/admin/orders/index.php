<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        <main class="flex-1 p-4 md:p-8 fade-in pb-24">
            
            <?php if(isset($_SESSION['flash_success'])): ?>
                <div class="bg-green-100 text-green-700 p-3 mb-4 rounded font-bold text-sm shadow-sm"><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
            <?php endif; ?>

            <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Kelola Pesanan</h1>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold border-b">
                            <tr><th class="p-4">ID</th><th class="p-4">Pembeli</th><th class="p-4">Total</th><th class="p-4">Status</th><th class="p-4 text-center">Aksi</th></tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-100">
                            <?php foreach($orders as $o): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 font-mono text-indigo-600 font-bold">#<?= $o['id'] ?></td>
                                <td class="p-4 font-bold text-gray-700"><?= $o['user_name'] ?? 'User' ?></td>
                                <td class="p-4 font-bold text-slate-700">Rp <?= number_format($o['total_price']) ?></td>
                                <td class="p-4">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold uppercase border"><?= $o['status'] ?></span>
                                </td>
                                <td class="p-4 text-center flex justify-center gap-2">
                                    <a href="/admin/order-detail?id=<?= $o['id'] ?>" class="bg-indigo-600 text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-indigo-700">Kelola</a>
                                    <a href="/admin/delete-order?id=<?= $o['id'] ?>" class="text-red-500 bg-red-50 p-1.5 rounded hover:bg-red-100" data-confirm="Hapus?"><i class="fas fa-trash"></i></a>
                                </td>
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