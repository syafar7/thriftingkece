<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        
        <main class="flex-1 p-4 md:p-8 fade-in pb-24">
            
            <?php if(isset($_SESSION['flash_success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-6 shadow-sm font-bold flex items-center gap-2 text-sm rounded-r-lg">
                    <i class="fas fa-check-circle"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Metode Pembayaran</h1>
                    <p class="text-gray-500 text-xs md:text-sm mt-1">Atur rekening bank atau e-wallet.</p>
                </div>
                <a href="/admin/payments/create" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold shadow flex items-center gap-2 text-sm hover:bg-indigo-700 transition w-full md:w-auto justify-center">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                
                <div class="overflow-x-auto custom-scroll">
                    <table class="w-full text-left text-sm min-w-[700px]">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="p-4 md:p-5">Logo</th>
                                <th class="p-4 md:p-5">Bank/Wallet</th>
                                <th class="p-4 md:p-5">Info Akun</th>
                                <th class="p-4 md:p-5">Pemilik</th>
                                <th class="p-4 md:p-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(empty($payments)): ?>
                                <tr><td colspan="5" class="p-8 text-center text-gray-400 italic">Belum ada data.</td></tr>
                            <?php else: ?>
                                <?php foreach($payments as $pay): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-4 md:p-5">
                                        <?php if(!empty($pay['logo_url'])): ?>
                                            <img src="<?= $pay['logo_url'] ?>" class="h-8 object-contain bg-white rounded border p-1">
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 italic">No Logo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4 md:p-5 font-bold text-slate-700"><?= $pay['bank_name'] ?></td>
                                    <td class="p-4 md:p-5 font-mono text-indigo-600 font-bold whitespace-nowrap">
                                        <?= $pay['account_number'] == '-' ? 'QRIS / SCAN' : $pay['account_number'] ?>
                                    </td>
                                    <td class="p-4 md:p-5 text-slate-600"><?= $pay['account_holder'] ?></td>
                                    <td class="p-4 md:p-5 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="/admin/payments/edit?id=<?= $pay['id'] ?>" class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition">
                                                <i class="fas fa-pen text-xs"></i>
                                            </a>
                                            <a href="/admin/payments/delete?id=<?= $pay['id'] ?>" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-600 rounded-full hover:bg-red-600 hover:text-white transition" data-confirm="Hapus?">
                                                <i class="fas fa-trash text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </main>
        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>
