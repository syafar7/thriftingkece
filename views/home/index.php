<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen py-10 bg-gray-50">
    <div class="container mx-auto px-4 md:px-6">
        
        <div class="flex justify-between items-center mb-6 lg:hidden">
            <h2 class="text-xl font-bold">Katalog Produk</h2>
            <button onclick="document.getElementById('filterSidebar').classList.toggle('hidden')" class="bg-white border px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 shadow-sm">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 relative">
            
            <aside id="filterSidebar" class="hidden lg:block w-full lg:w-1/4 h-fit sticky top-24 z-30">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2"><i class="fas fa-sliders-h"></i> Filter</h3>
                        <a href="/" class="text-xs text-red-500 font-bold hover:underline">Reset</a>
                    </div>

                    <form action="/" method="GET" class="space-y-6">
                        
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Pencarian</label>
                            <div class="relative">
                                <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" class="w-full bg-gray-50 border border-gray-200 rounded-lg py-2 pl-9 pr-3 text-sm focus:outline-none focus:border-indigo-500" placeholder="Cari nama...">
                                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Kategori</label>
                            <div class="space-y-2">
                                <?php $cats = ['Kaos', 'Jaket', 'Celana', 'Aksesoris', 'Sepatu', 'Topi']; ?>
                                <?php foreach($cats as $c): ?>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="cat" value="<?= $c ?>" <?= (isset($_GET['cat']) && $_GET['cat'] == $c) ? 'checked' : '' ?> class="accent-indigo-600">
                                    <span class="text-sm text-gray-600 group-hover:text-indigo-600 transition"><?= $c ?></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Rentang Harga</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" value="<?= $_GET['min_price'] ?? '' ?>" class="w-1/2 bg-gray-50 border rounded px-2 py-1 text-sm" placeholder="Min">
                                <span class="text-gray-400">-</span>
                                <input type="number" name="max_price" value="<?= $_GET['max_price'] ?? '' ?>" class="w-1/2 bg-gray-50 border rounded px-2 py-1 text-sm" placeholder="Max">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Ukuran</label>
                            <div class="flex flex-wrap gap-2">
                                <?php 
                                    // DAFTAR UKURAN LENGKAP
                                    $allSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'All Size', '28', '29', '30', '31', '32', '33', '34']; 
                                ?>
                                <?php foreach($allSizes as $s): ?>
                                <label class="cursor-pointer">
                                    <input type="radio" name="size" value="<?= $s ?>" class="hidden peer" <?= (isset($_GET['size']) && $_GET['size'] == $s) ? 'checked' : '' ?>>
                                    <span class="px-2 py-1 rounded border text-[10px] font-bold text-gray-500 bg-white peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition hover:border-indigo-300 select-none">
                                        <?= $s ?>
                                    </span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-bold text-sm hover:bg-indigo-700 transition shadow-md">Terapkan Filter</button>
                    </form>
                </div>
            </aside>

            <main class="w-full lg:w-3/4">
                <?php if(empty($products)): ?>
                    <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100 text-center">
                        <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mb-4"><i class="fas fa-search text-3xl text-gray-300"></i></div>
                        <h3 class="text-lg font-bold text-gray-700">Produk Tidak Ditemukan</h3>
                        <p class="text-gray-500 text-sm mt-1">Coba ubah filter pencarianmu.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach($products as $p): ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition group relative h-full flex flex-col">
                            <div class="relative h-72 bg-gray-100 overflow-hidden">
                                <img src="<?= $p['image'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                <?php if($p['discount_price'] > 0): ?>
                                    <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md">PROMO</span>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <a href="/product?id=<?= $p['id'] ?>" class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold text-sm hover:bg-indigo-600 hover:text-white transition transform scale-95 group-hover:scale-100 shadow-xl">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-1"><?= $p['category'] ?></p>
                                <h3 class="font-bold text-gray-800 text-base mb-1 leading-tight line-clamp-2"><?= $p['name'] ?></h3>
                                <div class="mt-auto pt-3 flex items-center justify-between">
                                    <div>
                                        <?php if($p['discount_price'] > 0): ?>
                                            <span class="text-xs text-gray-400 line-through">Rp <?= number_format($p['price']) ?></span>
                                            <span class="block text-lg font-bold text-red-600">Rp <?= number_format($p['discount_price']) ?></span>
                                        <?php else: ?>
                                            <span class="text-lg font-bold text-indigo-600">Rp <?= number_format($p['price']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded"><?= explode(',', $p['size'])[0] ?>..</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </main>

        </div>
    </div>
</div>

<script>
    function toggleFilter() {
        const sidebar = document.getElementById('filterSidebar');
        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('fixed', 'inset-0', 'bg-white', 'p-6', 'z-50', 'overflow-y-auto');
            sidebar.classList.remove('sticky', 'top-24');
        } else {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('fixed', 'inset-0', 'bg-white', 'p-6', 'z-50', 'overflow-y-auto');
            sidebar.classList.add('sticky', 'top-24');
        }
    }
</script>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>