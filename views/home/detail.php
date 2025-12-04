<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<?php 
    // Cek Role
    $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'); 
?>

<?php if($isAdmin): ?>
    <div class="flex h-screen pt-16 bg-gray-50 overflow-hidden">
        <?php include ROOT_PATH . '/views/layouts/admin_sidebar.php'; ?>
        
        <div class="flex-1 flex flex-col lg:ml-64 h-full relative w-full overflow-y-auto custom-scroll">
            <main class="flex-1 p-8 fade-in pb-24">
                <div class="mb-6">
                    <a href="/admin/discussions" class="text-gray-500 hover:text-indigo-600 font-bold flex items-center gap-2 w-fit px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Diskusi
                    </a>
                </div>

<?php else: ?>
    <div class="container mx-auto px-6 py-10 fade-in">
        <div class="text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-indigo-600">Home</a> / <span class="text-gray-800 font-bold"><?= $product['name'] ?></span>
        </div>
<?php endif; ?>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-10">
        <div class="md:flex">
            
            <div class="md:w-1/2 bg-gray-100 relative h-[500px] img-zoom-container flex items-center justify-center">
                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="max-w-full max-h-full object-contain p-4">
                
                <?php if($product['discount_price'] > 0): ?>
                    <div class="absolute top-4 left-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg animate-pulse">
                        <p class="text-xs font-bold uppercase">Promo</p>
                        <p class="font-bold text-lg">HEMAT Rp <?= number_format($product['price'] - $product['discount_price']) ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <p class="text-indigo-600 font-bold uppercase tracking-wider text-sm mb-2"><?= $product['category'] ?></p>
                
                <div class="flex justify-between items-start mb-4">
                    <h1 class="text-4xl font-bold text-gray-900 leading-tight"><?= $product['name'] ?></h1>
                    
                    <?php if(!$isAdmin): ?>
                        <a href="/wishlist/toggle?id=<?= $product['id'] ?>" 
                           class="p-3 rounded-full shadow-sm transition transform hover:scale-110 <?= $isWishlisted ? 'bg-indigo-50 text-indigo-600' : 'bg-gray-100 text-gray-400 hover:text-indigo-600' ?>" 
                           title="Simpan">
                            <i class="<?= $isWishlisted ? 'fas' : 'far' ?> fa-bookmark text-2xl"></i>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-2 mb-6">
                    <div class="flex text-yellow-400 text-sm">
                        <?php $rating = round($ratingStats['avg_rating'] ?? 0); for($i=1; $i<=5; $i++) echo ($i<=$rating)?'<i class="fas fa-star"></i>':'<i class="far fa-star text-gray-300"></i>'; ?>
                    </div>
                    <span class="text-sm text-gray-500">(<?= $ratingStats['total'] ?? 0 ?> Ulasan)</span>
                </div>

                <div class="mb-6 border-b pb-6">
                    <?php $finalPrice = ($product['discount_price'] > 0) ? $product['discount_price'] : $product['price']; ?>
                    <?php if($product['discount_price'] > 0): ?>
                        <div class="flex items-end gap-3">
                            <span class="text-gray-400 line-through text-xl">Rp <?= number_format($product['price']) ?></span>
                            <span class="text-4xl font-bold text-red-600">Rp <?= number_format($product['discount_price']) ?></span>
                        </div>
                    <?php else: ?>
                        <span class="text-4xl font-bold text-indigo-600">Rp <?= number_format($product['price']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="space-y-4 mb-8">
                    <?php if(!$isAdmin): ?>
                        <div>
                            <span class="font-bold text-gray-700 block mb-2">Pilih Ukuran:</span>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach(explode(',', $product['size']) as $s): $s=trim($s); ?>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="selected_size" value="<?= $s ?>" class="hidden peer" required>
                                        <span class="px-4 py-2 border-2 border-gray-200 rounded-lg text-sm font-bold text-gray-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:border-indigo-300 transition select-none"><?= $s ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" id="chosen_size" value="">
                        </div>
                    <?php else: ?>
                        <div class="bg-indigo-50 p-3 rounded border border-indigo-100">
                            <span class="text-xs font-bold text-indigo-800 uppercase">Varian Ukuran:</span>
                            <p class="font-mono text-indigo-600 font-bold"><?= $product['size'] ?></p>
                        </div>
                    <?php endif; ?>

                    <div>
                        <span class="font-bold text-gray-700 block mb-1">Deskripsi:</span>
                        <p class="text-gray-600 leading-relaxed"><?= $product['description'] ?></p>
                    </div>
                    <div>
                        <span class="font-bold text-gray-700">Stok:</span>
                        <span class="<?= $product['stock']>0?'text-green-600':'text-red-600' ?> font-bold"><?= $product['stock'] ?> pcs</span>
                    </div>
                </div>

                <?php if(!$isAdmin): ?>
                    <?php if($product['stock'] > 0): ?>
                        <div class="grid grid-cols-2 gap-4">
                            
                            <form action="/cart/add" method="POST" onsubmit="return validateSize()">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="name" value="<?= $product['name'] ?>">
                                <input type="hidden" name="price" value="<?= $finalPrice ?>">
                                <input type="hidden" name="image" value="<?= $product['image'] ?>">
                                <input type="hidden" name="size" id="form_size_cart">
                                
                                <button class="w-full py-4 rounded-xl border-2 border-indigo-600 text-indigo-600 font-bold hover:bg-indigo-50 transition flex justify-center items-center gap-2">
                                    <i class="fas fa-cart-plus"></i> Keranjang
                                </button>
                            </form>

                            <form action="/cart/buy-now" method="POST" onsubmit="return validateSize()">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="name" value="<?= $product['name'] ?>">
                                <input type="hidden" name="price" value="<?= $finalPrice ?>">
                                <input type="hidden" name="image" value="<?= $product['image'] ?>">
                                <input type="hidden" name="size" id="form_size_buy">

                                <button class="w-full py-4 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition shadow-lg flex justify-center items-center gap-2">
                                    <i class="fas fa-bolt"></i> Beli Sekarang
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <button disabled class="w-full bg-gray-300 text-gray-500 py-4 rounded-xl font-bold cursor-not-allowed">Stok Habis</button>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
            <h3 class="font-bold text-lg mb-6 flex items-center text-gray-800">
                <i class="fas fa-star text-yellow-400 mr-2"></i> Ulasan Pembeli (<?= count($reviews) ?>)
            </h3>

            <div class="space-y-4 mb-8 max-h-80 overflow-y-auto custom-scroll pr-2">
                <?php if(empty($reviews)): ?>
                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed">
                        <p class="text-gray-400 italic text-sm">Belum ada ulasan. Jadilah yang pertama!</p>
                    </div>
                <?php else: ?>
                    <?php foreach($reviews as $rev): ?>
                    <div class="border-b border-gray-100 pb-4 last:border-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-sm text-gray-800"><?= htmlspecialchars($rev['name']) ?></span>
                            <span class="text-[10px] text-gray-400"><?= date('d/m/Y', strtotime($rev['created_at'])) ?></span>
                        </div>
                        <div class="flex text-yellow-400 text-xs mb-2">
                            <?php for($i=1; $i<=5; $i++) echo ($i <= $rev['rating']) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star text-gray-300"></i>'; ?>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">"<?= htmlspecialchars($rev['comment']) ?>"</p>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if(!$isAdmin && isset($_SESSION['user_id'])): ?>
                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                    <h4 class="font-bold text-sm text-gray-700 mb-3">Tulis Ulasanmu</h4>
                    <form action="/review/submit" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        
                        <div class="flex items-center gap-3 mb-3">
                            <label class="text-xs font-bold text-gray-500 uppercase">Beri Nilai:</label>
                            <select name="rating" class="border-2 border-gray-200 rounded-lg p-1.5 text-sm focus:border-indigo-500 outline-none bg-white font-bold text-yellow-500">
                                <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                                <option value="4">⭐⭐⭐⭐ (4)</option>
                                <option value="3">⭐⭐⭐ (3)</option>
                                <option value="2">⭐⭐ (2)</option>
                                <option value="1">⭐ (1)</option>
                            </select>
                        </div>

                        <textarea name="comment" required class="w-full border-2 border-gray-200 p-3 rounded-xl text-sm mb-3 focus:border-indigo-500 outline-none transition" rows="3" placeholder="Ceritakan pengalamanmu tentang produk ini..."></textarea>
                        
                        <button class="w-full bg-slate-800 text-white py-2.5 rounded-lg text-sm font-bold hover:bg-black transition shadow-md">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            <?php elseif(!$isAdmin): ?>
                <p class="text-center text-sm text-gray-500 mt-4">
                    <a href="/login" class="text-indigo-600 font-bold underline">Login</a> untuk menulis ulasan.
                </p>
            <?php endif; ?>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit" id="chat-area">
            <h3 class="font-bold text-lg mb-6 flex items-center text-gray-800">
                <i class="far fa-comments text-indigo-600 mr-2"></i> Diskusi & Negosiasi
            </h3>
            
            <div class="bg-slate-50 p-4 rounded-xl h-80 overflow-y-auto mb-4 border border-gray-200 space-y-4 custom-scroll" id="chatContainer">
                <?php if(empty($chats)): ?>
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 italic">
                        <i class="far fa-comment-dots text-3xl mb-2 opacity-50"></i>
                        <p>Belum ada diskusi.</p>
                        <?php if(!$isAdmin): ?><p class="text-xs">Jadilah yang pertama menawar!</p><?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php foreach($chats as $chat): ?>
                        <?php 
                            // Cek Identitas
                            $isMe = (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $chat['user_id']);
                            $isMsgAdmin = ($chat['role'] == 'admin');
                            
                            // Cek Hak Hapus: Admin boleh hapus semua, User cuma boleh hapus punya sendiri
                            $canDelete = ($isMe || (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'));
                        ?>
                        <div class="flex flex-col <?= $isMe ? 'items-end' : 'items-start' ?>">
                            <div class="max-w-[85%] px-4 py-3 rounded-2xl shadow-sm relative <?= $isMe ? 'bg-indigo-600 text-white rounded-br-none' : ($isMsgAdmin ? 'bg-red-50 text-red-900 border border-red-100 rounded-bl-none' : 'bg-white text-gray-700 border border-gray-200 rounded-bl-none') ?>">
                                
                                <div class="flex justify-between items-center gap-3 border-b border-black/5 pb-1 mb-1">
                                    <span class="text-[10px] font-bold opacity-80 uppercase tracking-wider flex items-center gap-1">
                                        <?php if($isMsgAdmin): ?>
                                            <i class="fas fa-shield-alt"></i> ADMIN
                                        <?php else: ?>
                                            <?= htmlspecialchars($chat['name']) ?>
                                        <?php endif; ?>
                                    </span>

                                    <?php if($canDelete): ?>
                                        <a href="/discussion/delete?id=<?= $chat['id'] ?>&product_id=<?= $product['id'] ?>" 
                                           class="text-[10px] hover:text-red-400 transition opacity-60 hover:opacity-100" 
                                           data-confirm="Hapus pesan ini?"
                                           title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="text-sm leading-relaxed"><?= htmlspecialchars($chat['message']) ?></p>
                                
                                <span class="text-[9px] block text-right mt-2 opacity-60">
                                    <?= date('d/m H:i', strtotime($chat['created_at'])) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if(isset($_SESSION['user_id'])): ?>
                <form action="/discussion/send" method="POST" class="relative">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <?php if($isAdmin): ?><input type="hidden" name="redirect_admin" value="true"><?php endif; ?>

                    <input type="text" name="message" required 
                           class="w-full border-2 border-gray-200 pl-4 pr-14 py-3 rounded-xl focus:border-indigo-600 focus:outline-none transition shadow-sm bg-white" 
                           placeholder="<?= $isAdmin ? 'Balas pesan pembeli...' : 'Tawar harga / tanya stok...' ?>">
                    
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-indigo-600 text-white px-4 rounded-lg font-bold hover:bg-indigo-700 transition flex items-center justify-center shadow-md">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            <?php else: ?>
                <div class="text-center bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                    <a href="/login" class="text-indigo-600 font-bold underline">Login</a> untuk mulai chat.
                </div>
            <?php endif; ?>
        </div>

    </div>

<?php if($isAdmin): ?>
    </main>
            <div class="p-6 text-center text-xs text-gray-400">Admin Panel &copy; 2025</div>
        </div>
    </div>
<?php else: ?>
    </div> 

    <script>
        const radios = document.querySelectorAll('input[name="selected_size"]');
        radios.forEach(r => r.addEventListener('change', function() {
            document.getElementById('form_size_cart').value = this.value;
            document.getElementById('form_size_buy').value = this.value;
        }));
        function validateSize() {
            if (!document.getElementById('form_size_cart').value) {
                Swal.fire({icon:'warning',title:'Pilih Ukuran',text:'Harap pilih varian produk terlebih dahulu!',confirmButtonColor:'#4f46e5'});
                return false;
            } return true;
        }
    </script>
<?php endif; ?>

<script>
    var chatBox = document.getElementById("chatContainer");
    if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>
