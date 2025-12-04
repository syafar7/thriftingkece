<?php
$db = (new Database())->getConnection();
$adminId = $_SESSION['user_id'];
$sqlBadge = "SELECT COUNT(*) FROM (SELECT product_id FROM discussions d1 WHERE id = (SELECT MAX(id) FROM discussions d2 WHERE d2.product_id = d1.product_id) AND user_id != ?) as t";
$stmtBadge = $db->prepare($sqlBadge);
$stmtBadge->execute([$adminId]);
$badge = $stmtBadge->fetchColumn();
?>

<div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity duration-300"></div>

<aside id="adminSidebar" class="fixed left-0 top-16 h-[calc(100vh-4rem)] w-64 bg-slate-900 text-white border-r border-slate-800 z-50 flex flex-col transform transition-transform duration-300 -translate-x-full lg:translate-x-0 shadow-2xl lg:shadow-none overflow-hidden">
    
    <div class="p-6 bg-gradient-to-r from-indigo-700 to-indigo-600 flex-shrink-0">
        <h2 class="text-sm font-bold text-white tracking-widest flex items-center gap-2">
            <i class="fas fa-shield-alt"></i> ADMIN MENU
        </h2>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scroll">
        <?php $uri = $_SERVER['REQUEST_URI']; ?>

        <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-2">Utama</p>
        <a href="/admin" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-bold transition <?= $uri=='/admin'?'bg-indigo-600 text-white shadow-lg':'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <i class="fas fa-home w-5 text-center"></i> Dashboard
        </a>

        <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Manajemen</p>
        <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition <?= strpos($uri,'/products')?'bg-indigo-600 text-white shadow-lg':'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <i class="fas fa-box w-5 text-center"></i> Produk
        </a>
        <a href="/admin/orders" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition <?= strpos($uri,'/orders')?'bg-indigo-600 text-white shadow-lg':'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <i class="fas fa-dolly w-5 text-center"></i> Pesanan
        </a>

        <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Aktivitas</p>
        <a href="/admin/payments" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition <?= strpos($uri,'/payments')?'bg-indigo-600 text-white shadow-lg':'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <i class="fas fa-credit-card w-5 text-center"></i> Pembayaran
        </a>
        <a href="/admin/discussions" class="flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium transition <?= strpos($uri,'/discussions')?'bg-indigo-600 text-white shadow-lg':'text-slate-400 hover:bg-slate-800 hover:text-white' ?>">
            <div class="flex items-center gap-3"><i class="fas fa-comments w-5 text-center"></i> Diskusi</div>
            <?php if($badge > 0): ?><span class="bg-red-500 text-[10px] font-bold px-2 rounded-full animate-pulse"><?= $badge ?></span><?php endif; ?>
        </a>
    </div>

    <div class="p-4 bg-slate-950 border-t border-slate-800 flex-shrink-0">
        <a href="/logout" class="block w-full py-2.5 bg-slate-800 hover:bg-red-600 text-slate-400 hover:text-white text-center rounded-lg text-xs font-bold transition shadow-sm border border-slate-700 hover:border-red-500">
            <i class="fas fa-power-off mr-2"></i> KELUAR
        </a>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        // Logika: Jika ada class '-translate-x-full' (artinya sembunyi), hapus biar muncul
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full'); // Geser Masuk
            overlay.classList.remove('hidden');            // Tampilkan Overlay
        } else {
            sidebar.classList.add('-translate-x-full');    // Geser Keluar
            overlay.classList.add('hidden');               // Sembunyikan Overlay
        }
    }
</script>