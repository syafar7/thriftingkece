<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-10 fade-in">
    <div class="container mx-auto px-6 max-w-5xl">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Saya</h1>
        <p class="text-gray-500 mb-8">Lacak status pengiriman dan riwayat belanja.</p>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            
            <?php if(empty($myOrders)): ?>
                <div class="text-center py-20">
                    <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-box-open text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700">Belum ada pesanan</h3>
                    <p class="text-gray-500 mb-6">Kamu belum pernah melakukan transaksi.</p>
                    <a href="/" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700">Mulai Belanja</a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-sm border-b">
                            <tr>
                                <th class="p-5 font-bold">Order ID</th>
                                <th class="p-5 font-bold">Tanggal</th>
                                <th class="p-5 font-bold">Total</th>
                                <th class="p-5 font-bold">Status</th>
                                <th class="p-5 font-bold">Resi Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php foreach($myOrders as $order): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-5 font-mono font-bold text-indigo-600">
                                    #ORD-<?= str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td class="p-5 text-gray-600">
                                    <?= date('d M Y', strtotime($order['created_at'])) ?>
                                </td>
                                <td class="p-5 font-bold text-gray-800">
                                    Rp <?= number_format($order['total_price']) ?>
                                </td>
                                <td class="p-5">
                                    <?php 
                                        // LOGIKA STATUS (YANG KAMU CARI)
                                        $bg = 'bg-gray-100 text-gray-600';
                                        $label = 'Menunggu';
                                        
                                        if($order['status']=='pending') { $bg = 'bg-yellow-100 text-yellow-700'; $label='Belum Bayar'; }
                                        
                                        // STATUS BARU
                                        if($order['status']=='waiting_confirmation') { $bg = 'bg-orange-100 text-orange-700'; $label='Menunggu Konfirmasi Penjual'; }
                                        
                                        if($order['status']=='packed') { $bg = 'bg-blue-50 text-blue-600'; $label='Sedang Dikemas'; }
                                        if($order['status']=='sent') { $bg = 'bg-blue-100 text-blue-700'; $label='Dikirim'; }
                                        if($order['status']=='completed') { $bg = 'bg-green-100 text-green-700'; $label='Selesai'; }
                                        if($order['status']=='cancelled') { $bg = 'bg-red-100 text-red-700'; $label='Batal'; }
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= $bg ?>">
                                        <?= $label ?>
                                    </span>
                                </td>
                                <td class="p-5">
                                    <?php if(!empty($order['tracking_number']) && ($order['status']=='sent' || $order['status']=='completed')): ?>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] uppercase font-bold text-gray-400">JNE/J&T</span>
                                            <span class="font-mono font-bold text-gray-800 tracking-wide bg-gray-100 px-2 py-1 rounded w-fit mt-1">
                                                <?= $order['tracking_number'] ?>
                                            </span>
                                        </div>
                                    <?php elseif($order['status'] == 'packed'): ?>
                                        <span class="text-orange-500 text-xs font-bold italic">Sedang dikemas...</span>
                                    <?php elseif($order['status'] == 'waiting_confirmation'): ?>
                                        <span class="text-orange-500 text-xs font-bold italic">Menunggu Admin...</span>
                                    <?php elseif($order['status'] == 'pending'): ?>
                                        <a href="/payment?id=<?= $order['id'] ?>" class="text-indigo-600 font-bold underline text-xs">Bayar Sekarang</a>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>