<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-10 fade-in">
    <div class="container mx-auto px-6 max-w-4xl">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Keranjang Belanja</h2>
            
            <?php if(!empty($cart)): ?>
                <a href="/cart/clear" 
                   class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-2 bg-red-50 px-4 py-2 rounded-lg transition hover:bg-red-100"
                   data-confirm="Yakin ingin mengosongkan keranjang?">
                    <i class="fas fa-trash-alt"></i> Hapus Semua
                </a>
            <?php endif; ?>
        </div>

        <?php if(empty($cart)): ?>
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="bg-indigo-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shopping-cart text-4xl text-indigo-300"></i>
                </div>
                <p class="text-gray-500 mb-6 text-lg">Keranjang belanjamu masih kosong.</p>
                <a href="/" class="bg-indigo-600 text-white px-8 py-3 rounded-full font-bold hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-200">
                    Mulai Belanja
                </a>
            </div>
        <?php else: ?>
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                
                <?php 
                    $total = 0; 
                    // Loop Cart
                    foreach($cart as $item): 
                        $subtotal = $item['price'] * $item['qty']; 
                        $total += $subtotal; 
                ?>
                
                <div class="flex items-center justify-between p-6 border-b hover:bg-gray-50 transition">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0">
                            <img src="<?= $item['image'] ?>" class="w-full h-full object-cover">
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-lg text-gray-800"><?= $item['name'] ?></h4>
                            <div class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs font-bold border">
                                    Size: <?= $item['size'] ?? '-' ?>
                                </span>
                                <span>
                                    Rp <?= number_format($item['price']) ?> x <?= $item['qty'] ?> pcs
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="font-bold text-indigo-600 text-lg mb-1">Rp <?= number_format($subtotal) ?></p>
                        
                        <a href="/cart/remove?id=<?= $item['cart_id'] ?>" 
                           class="text-sm text-red-500 hover:text-red-700 font-bold flex items-center justify-end gap-1 transition"
                           data-confirm="Hapus barang ini dari keranjang?">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="p-8 bg-gray-50 text-right flex flex-col items-end">
                    <div class="flex justify-between w-full md:w-1/3 mb-6 border-b border-gray-200 pb-4">
                        <span class="text-gray-500 font-bold">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-indigo-700">Rp <?= number_format($total) ?></span>
                    </div>
                    
                    <a href="/checkout" class="bg-indigo-600 text-white px-10 py-4 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-300 flex items-center gap-2">
                        Checkout Sekarang <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>