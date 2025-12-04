<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        <main class="flex-1 p-8 fade-in">
            
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Diskusi Masuk</h1>
                <p class="text-gray-500 text-sm mt-1">Pertanyaan pembeli yang perlu dijawab.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs font-bold tracking-wider">
                        <tr>
                            <th class="p-5">Produk</th>
                            <th class="p-5">Total Chat</th>
                            <th class="p-5">Aktivitas Terakhir</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($chatList)): ?>
                            <tr><td colspan="4" class="p-10 text-center text-gray-400 italic">Belum ada diskusi masuk.</td></tr>
                        <?php else: ?>
                            <?php foreach($chatList as $chat): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-5 flex items-center gap-4">
                                    <img src="<?= $chat['image'] ?>" class="w-10 h-10 rounded object-cover border">
                                    <span class="font-bold text-slate-700"><?= $chat['name'] ?></span>
                                </td>
                                <td class="p-5">
                                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold border border-indigo-100">
                                        <?= $chat['total_chat'] ?> Pesan
                                    </span>
                                </td>
                                <td class="p-5 text-slate-500">
                                    <?= date('d M Y, H:i', strtotime($chat['last_activity'])) ?> WIB
                                </td>
                                <td class="p-5 text-center">
                                    <a href="/admin/reply?product_id=<?= $chat['id'] ?>" class="bg-white border border-indigo-600 text-indigo-600 px-4 py-2 rounded-lg font-bold text-xs hover:bg-indigo-600 hover:text-white transition shadow-sm inline-flex items-center gap-2">
                                        <i class="fas fa-reply"></i> Balas
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