<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-10 fade-in">
    <div class="container mx-auto px-6 max-w-4xl">
        
        <div class="mb-6">
            <a href="/cart" class="text-gray-500 font-bold hover:text-indigo-600 flex items-center gap-2 transition w-fit">
                <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-6 text-gray-800">Konfirmasi Pesanan (Checkout)</h1>

        <form action="/checkout/process" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-indigo-600"></i> Alamat Pengiriman
                            </h3>
                            <p class="text-gray-900 font-bold text-lg"><?= $user['name'] ?> <span class="text-gray-500 font-normal text-sm ml-2">(<?= $user['phone'] ?>)</span></p>
                            <p class="text-gray-600 text-sm mt-1 leading-relaxed"><?= $user['address'] ?></p>
                        </div>
                        <a href="/profile/edit?redirect=checkout" class="text-xs font-bold text-indigo-600 border border-indigo-200 px-3 py-1 rounded-full hover:bg-indigo-50 transition">
                            Ubah
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Rincian Barang</h3>
                    
                    <?php 
                        $total = 0; 
                        // Loop barang menggunakan variabel $cartItems dari Controller
                        foreach($cartItems as $item): 
                            $subtotal = $item['price'] * $item['qty']; 
                            $total += $subtotal; 
                    ?>
                    <div class="flex gap-4 mb-4 border-b pb-4 last:border-0 last:pb-0 items-start">
                        <div class="w-16 h-16 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
                            <img src="<?= $item['image'] ?>" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 text-sm"><?= $item['name'] ?></h4>
                            <p class="text-xs text-gray-500 mt-1">
                                Size: <span class="font-bold text-gray-700 bg-gray-100 px-1 rounded"><?= $item['size'] ?></span>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                <?= $item['qty'] ?> x Rp <?= number_format($item['price']) ?>
                            </p>
                        </div>

                        <div class="text-right flex flex-col items-end justify-between h-full">
                            <div class="font-bold text-indigo-600 text-sm">Rp <?= number_format($subtotal) ?></div>
                            
                            <a href="/cart/remove?id=<?= $item['cart_id'] ?>" 
                               class="text-gray-400 hover:text-red-500 transition text-xs mt-2 p-1" 
                               title="Hapus Item"
                               data-confirm="Hapus barang ini dari pesanan?">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>

            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-indigo-100 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-4">Pilih Pembayaran</h3>
                    
                    <div class="space-y-3 mb-6 max-h-80 overflow-y-auto custom-scroll pr-1">
                        
                        <?php foreach($paymentMethods as $index => $pm): ?>
                        <label class="flex items-center gap-3 border p-3 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition relative overflow-hidden group bg-white">
                            <input type="radio" name="payment_method" value="<?= $pm['bank_name'] ?>" <?= $index === 0 ? 'checked' : '' ?> class="text-indigo-600 focus:ring-indigo-500 h-4 w-4 accent-indigo-600">
                            
                            <div class="flex items-center gap-3 w-full">
                                <?php if(!empty($pm['logo_url'])): ?>
                                    <div class="w-10 h-8 flex items-center justify-center bg-white rounded border p-1">
                                        <img src="<?= $pm['logo_url'] ?>" class="max-w-full max-h-full object-contain">
                                    </div>
                                <?php else: ?>
                                    <div class="w-10 h-8 flex items-center justify-center bg-white rounded border text-gray-400">
                                        <i class="fas fa-university"></i>
                                    </div>
                                <?php endif; ?>

                                <div>
                                    <span class="font-bold block text-sm text-gray-700 group-hover:text-indigo-700 transition"><?= $pm['bank_name'] ?></span>
                                    <span class="text-[10px] text-gray-400">Transfer / Scan</span>
                                </div>
                            </div>
                        </label>
                        <?php endforeach; ?>

                        <label class="flex items-center gap-3 border p-3 rounded-lg cursor-pointer hover:bg-orange-50 hover:border-orange-200 transition group bg-white">
                            <input type="radio" name="payment_method" value="COD" class="text-indigo-600 focus:ring-indigo-500 h-4 w-4 accent-orange-600">
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-8 flex items-center justify-center bg-white rounded border text-orange-500">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div>
                                    <span class="font-bold block text-sm text-gray-700 group-hover:text-orange-800 transition">Bayar di Tempat (COD)</span>
                                    <span class="text-[10px] text-gray-400">Cash saat sampai</span>
                                </div>
                            </div>
                        </label>

                    </div>

                    <div class="border-t border-dashed border-gray-300 pt-4 mb-6">
                        <div class="flex justify-between items-center mb-2 text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-bold text-gray-700">Rp <?= number_format($total) ?></span>
                        </div>
                        <div class="flex justify-between items-center mb-2 text-sm">
                            <span class="text-gray-500">Ongkir</span>
                            <span class="font-bold text-green-600">Gratis</span>
                        </div>
                        <div class="flex justify-between items-center text-xl mt-4 pt-2 border-t border-gray-100">
                            <span class="font-bold text-gray-800">Total Tagihan</span>
                            <span class="font-extrabold text-indigo-600">Rp <?= number_format($total) ?></span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-300 flex justify-center items-center gap-2 transform active:scale-95">
                        <span>Buat Pesanan</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <div class="mt-4 flex items-center justify-center gap-2 text-[10px] text-gray-400 bg-gray-50 py-2 rounded-lg border border-gray-200">
                        <i class="fas fa-shield-alt text-green-500"></i> Pembayaran Aman & Terenkripsi
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>