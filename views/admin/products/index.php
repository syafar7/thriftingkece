<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        <main class="flex-1 px-4 md:px-8 pb-24 fade-in">
            
            <?php if(isset($_SESSION['flash_success'])): ?>
                <div class="mt-6 bg-green-100 text-green-700 p-3 rounded font-bold text-sm shadow-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['flash_error'])): ?>
                <div class="mt-6 bg-red-100 text-red-700 p-3 rounded font-bold text-sm shadow-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
                </div>
            <?php endif; ?>

            <div class="sticky top-0 z-30 bg-gray-50 py-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200 mb-4">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Kelola Produk</h1>
                    <p class="text-gray-500 text-sm mt-1">Manajemen stok dan katalog.</p>
                </div>
                
                <a href="/admin/create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 md:px-6 rounded-lg shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2 text-sm">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold border-b">
                            <tr>
                                <th class="p-4">Produk</th>
                                <th class="p-4">Harga</th>
                                <th class="p-4">Stok</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            <?php foreach($products as $p): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 flex items-center gap-4">
                                    <img src="<?= $p['image'] ?>" class="w-12 h-12 rounded border object-cover flex-shrink-0 bg-white">
                                    <div>
                                        <p class="font-bold text-gray-800"><?= $p['name'] ?></p>
                                        <span class="text-xs text-gray-500"><?= $p['category'] ?></span>
                                        <?php if($p['discount_price']>0):?><span class="text-[10px] bg-red-100 text-red-600 px-1 rounded font-bold ml-1">PROMO</span><?php endif;?>
                                    </div>
                                </td>
                                <td class="p-4 font-bold text-indigo-600">
                                    <?php if($p['discount_price'] > 0): ?>
                                        <div class="flex flex-col">
                                            <span class="line-through text-gray-400 text-xs font-normal">Rp <?= number_format($p['price']) ?></span>
                                            <span>Rp <?= number_format($p['discount_price']) ?></span>
                                        </div>
                                    <?php else: ?>
                                        Rp <?= number_format($p['price']) ?>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4">
                                    <span class="<?= $p['stock']>0?'text-green-600 bg-green-50':'text-red-600 bg-red-50' ?> font-bold px-2 py-1 rounded text-xs whitespace-nowrap">
                                        <?= $p['stock'] ?> pcs
                                    </span>
                                </td>
                                <td class="p-4 text-center flex justify-center gap-2">
                                    <a href="/admin/edit?id=<?= $p['id'] ?>" class="text-blue-600 bg-blue-50 p-2 rounded hover:bg-blue-100 transition"><i class="fas fa-pen"></i></a>
                                    <a href="/admin/delete?id=<?= $p['id'] ?>" class="text-red-600 bg-red-50 p-2 rounded hover:bg-red-100 transition" data-confirm="Hapus?"><i class="fas fa-trash"></i></a>
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