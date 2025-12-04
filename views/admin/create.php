<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        <main class="flex-1 p-8 fade-in flex justify-center pb-24">
            <div class="w-full max-w-3xl bg-white p-8 rounded-xl shadow-sm border border-gray-100 h-fit">
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Produk Baru</h1>
                
                <form action="/admin/store" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block font-bold text-sm mb-2">Nama Produk</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div><label class="block font-bold text-sm">Harga</label><input type="number" name="price" class="w-full border p-2 rounded" required></div>
                        <div><label class="block font-bold text-sm">Promo</label><input type="number" name="discount_price" class="w-full border p-2 rounded"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold text-sm">Kategori</label>
                            <select name="category" class="w-full border p-2 rounded bg-white">
                                <option>Kaos</option><option>Jaket</option><option>Celana</option><option>Aksesoris</option><option>Sepatu</option>
                            </select>
                        </div>
                        <div><label class="block font-bold text-sm">Stok</label><input type="number" name="stock" class="w-full border p-2 rounded" value="1"></div>
                    </div>

                    <div class="mb-4">
                         <label class="block font-bold text-sm mb-2">Ukuran</label>
                         <div class="grid grid-cols-4 gap-2 border p-4 rounded bg-gray-50">
                            <?php foreach(['S','M','L','XL','XXL','All Size','28', '29', '30', '31', '32'] as $s): ?>
                                <label class="flex items-center gap-2"><input type="checkbox" name="sizes[]" value="<?= $s ?>"> <?= $s ?></label>
                            <?php endforeach; ?>
                         </div>
                    </div>

                    <div class="mb-4"><label class="block font-bold text-sm">Deskripsi</label><textarea name="description" class="w-full border p-2 rounded h-24"></textarea></div>
                    <div class="mb-6"><label class="block font-bold text-sm">Foto</label><input type="file" name="image" class="w-full border p-2 rounded text-sm" required></div>

                    <div class="flex gap-3">
                        <a href="/admin/products" class="w-1/3 bg-gray-100 text-center py-3 rounded font-bold text-sm">Batal</a>
                        <button class="w-2/3 bg-indigo-600 text-white py-3 rounded font-bold hover:bg-indigo-700">Simpan</button>
                    </div>
                </form>
            </div>
        </main>
        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>