<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
    
    <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>

    <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
        
        <main class="flex-1 p-8 fade-in pb-24">
            
            <div class="mb-6">
                <a href="/admin/discussions" class="text-gray-500 hover:text-indigo-600 font-bold flex items-center gap-2 w-fit px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Diskusi
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 sticky top-6">
                        <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Info Produk</h3>
                        <div class="relative h-64 mb-4 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                            <img src="<?= $product['image'] ?>" class="w-full h-full object-contain p-2">
                            <?php if($product['discount_price'] > 0): ?>
                                <div class="absolute top-2 left-2 bg-red-600 text-white px-3 py-1 rounded-full shadow-md">
                                    <p class="text-[10px] font-bold uppercase">PROMO</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 mb-1"><?= $product['name'] ?></h2>
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-3"><?= $product['category'] ?></p>
                        <div class="mb-4">
                            <?php if($product['discount_price'] > 0): ?>
                                <span class="text-gray-400 line-through text-sm">Rp <?= number_format($product['price']) ?></span>
                                <span class="text-2xl font-bold text-red-600">Rp <?= number_format($product['discount_price']) ?></span>
                            <?php else: ?>
                                <span class="text-2xl font-bold text-indigo-600">Rp <?= number_format($product['price']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden flex flex-col h-[600px]">
                        
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fas fa-comments text-indigo-600"></i> Ruang Diskusi</h3>
                            <span class="text-xs text-gray-400 bg-white px-2 py-1 rounded border">Admin Mode</span>
                        </div>

                        <div class="flex-1 p-6 overflow-y-auto custom-scroll space-y-4 bg-slate-50" id="chatContainer">
                            <?php if(empty($chats)): ?>
                                <div class="h-full flex flex-col items-center justify-center text-gray-400 italic">
                                    <p>Belum ada diskusi.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach($chats as $chat): ?>
                                    <?php 
                                        $isMe = ($chat['user_id'] == $_SESSION['user_id']); // Admin yg login
                                    ?>
                                    <div class="flex flex-col <?= $isMe ? 'items-end' : 'items-start' ?>">
                                        <div class="max-w-[80%] px-4 py-3 rounded-2xl shadow-sm relative <?= $isMe ? 'bg-indigo-600 text-white' : 'bg-white text-gray-800 border border-gray-200' ?>">
                                            
                                            <div class="flex justify-between items-center gap-3 mb-1 border-b border-white/20 pb-1">
                                                <span class="text-[10px] font-bold uppercase tracking-wider">
                                                    <?= $isMe ? 'ANDA (ADMIN)' : htmlspecialchars($chat['name']) ?>
                                                </span>
                                                
                                                <a href="/discussion/delete?id=<?= $chat['id'] ?>&product_id=<?= $product['id'] ?>" 
                                                   class="text-xs hover:text-red-500 transition p-1 rounded hover:bg-black/10" 
                                                   data-confirm="Hapus pesan ini?" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                            
                                            <p class="text-sm leading-relaxed"><?= htmlspecialchars($chat['message']) ?></p>
                                            <span class="text-[9px] block text-right mt-1 opacity-60"><?= date('d M H:i', strtotime($chat['created_at'])) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="p-4 bg-white border-t border-gray-200">
                            <form action="/discussion/send" method="POST" class="flex gap-3">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="redirect_admin" value="true">
                                <input type="text" name="message" required class="flex-1 border-2 border-gray-200 px-4 py-3 rounded-xl focus:border-indigo-600 focus:outline-none transition" placeholder="Ketik balasan sebagai Admin...">
                                <button type="submit" class="bg-indigo-600 text-white px-6 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                                    <i class="fas fa-paper-plane"></i> Kirim
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </main>

        <?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
    </div>
</div>

<script>
    var chatContainer = document.getElementById("chatContainer");
    if(chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
</script>
