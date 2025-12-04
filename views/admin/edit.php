<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        <main class="flex-1 p-8 fade-in flex justify-center pb-24">
            
            <div class="w-full max-w-3xl bg-white p-8 rounded-xl shadow-sm border border-gray-100 h-fit">
                <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Produk</h1>
                
                <form action="/admin/update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    
                    <div class="mb-4">
                        <label class="block font-bold text-sm mb-2">Nama Produk</label>
                        <input type="text" name="name" value="<?= $product['name'] ?>" class="w-full border p-2 rounded focus:outline-none focus:border-indigo-500" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold text-sm">Harga (Rp)</label>
                            <input type="number" name="price" value="<?= $product['price'] ?>" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block font-bold text-sm">Harga Promo (Opsional)</label>
                            <input type="number" name="discount_price" value="<?= $product['discount_price'] ?>" class="w-full border p-2 rounded" placeholder="0">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold text-sm">Kategori</label>
                            <select name="category" class="w-full border p-2 rounded bg-white">
                                <?php $cats = ['Kaos', 'Jaket', 'Celana', 'Aksesoris', 'Topi', 'Sepatu']; ?>
                                <?php foreach($cats as $c): ?>
                                    <option value="<?= $c ?>" <?= $product['category'] == $c ? 'selected' : '' ?>><?= $c ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-sm">Stok</label>
                            <input type="number" name="stock" value="<?= $product['stock'] ?>" class="w-full border p-2 rounded">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-sm mb-2">Pilih Ukuran Tersedia</label>
                        <div class="grid grid-cols-4 gap-2 border p-4 rounded-lg bg-gray-50">
                            <?php 
                                // Ambil string ukuran dari DB (misal "S, M, L") dan pecah jadi array
                                $currentSizes = explode(',', $product['size']); 
                                // Bersihkan spasi jika ada
                                $currentSizes = array_map('trim', $currentSizes);
                                $availableSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'All Size', '28', '29', '30', '31', '32']; 
                            ?>
                            <?php foreach($availableSizes as $s): ?>
                            <label class="flex items-center space-x-2 cursor-pointer p-1 hover:bg-white rounded transition">
                                <input type="checkbox" name="sizes[]" value="<?= $s ?>" 
                                       class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                       <?= in_array($s, $currentSizes) ? 'checked' : '' ?>>
                                <span class="text-sm font-medium text-gray-700"><?= $s ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold text-sm">Deskripsi</label>
                        <textarea name="description" class="w-full border p-2 rounded h-24"><?= $product['description'] ?></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold text-sm mb-2">Ganti Foto (Opsional)</label>
                        <div class="flex items-center gap-4 bg-gray-50 p-3 rounded border border-dashed">
                            <img src="<?= $product['image'] ?>" class="w-16 h-16 object-cover rounded border bg-white">
                            <input type="file" name="image" class="w-full text-sm">
                        </div>
                        <small class="text-gray-400 text-xs">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>

                    <div class="flex gap-3">
                        <a href="/admin/products" class="w-1/3 bg-gray-100 text-gray-700 font-bold py-3 rounded text-center text-sm hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="w-2/3 bg-indigo-600 text-white font-bold py-3 rounded hover:bg-indigo-700 transition shadow-lg">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

        </main>
        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>