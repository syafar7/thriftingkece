<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        <main class="flex-1 p-8 fade-in pb-24">
            
            <?php if(isset($_SESSION['flash_success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm font-bold flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Metode Pembayaran</h1>
                <a href="/admin/payments/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 shadow-lg flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-500 border-b border-slate-200 uppercase text-xs font-bold tracking-wider">
                        <tr>
                            <th class="p-5">Logo</th>
                            <th class="p-5">Bank/Wallet</th>
                            <th class="p-5">Info Akun</th>
                            <th class="p-5">Pemilik</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($payments)): ?>
                            <tr><td colspan="5" class="p-8 text-center text-gray-400 italic">Belum ada metode pembayaran.</td></tr>
                        <?php else: ?>
                            <?php foreach($payments as $pay): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-5">
                                    <?php if(!empty($pay['logo_url'])): ?>
                                        <img src="<?= $pay['logo_url'] ?>" class="h-8 object-contain bg-white rounded border p-1">
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400 italic">No Logo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-5 font-bold text-slate-700"><?= $pay['bank_name'] ?></td>
                                <td class="p-5 font-mono text-blue-600 font-bold">
                                    <?= $pay['account_number'] == '-' ? 'QRIS / SCAN' : $pay['account_number'] ?>
                                </td>
                                <td class="p-5 text-slate-600"><?= $pay['account_holder'] ?></td>
                                <td class="p-5 text-center flex justify-center gap-2">
                                    <a href="/admin/payments/edit?id=<?= $pay['id'] ?>" class="text-blue-500 hover:bg-blue-50 p-2 rounded-full transition" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="/admin/payments/delete?id=<?= $pay['id'] ?>" class="text-red-500 hover:bg-red-50 p-2 rounded-full transition" data-confirm="Hapus metode ini?" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>