<?php 
    // Cek apakah sedang di halaman admin untuk menentukan penutup wrapper
    $isInAdminPath = strpos($_SERVER['REQUEST_URI'], '/admin') !== false;
    $isAdminRole = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin');
?>

</main> 

<?php if (!$isAdminRole || !$isInAdminPath): ?>
    <footer class="bg-slate-900 text-white py-12 mt-20 border-t border-slate-800">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0 text-center md:text-left">
                    <h3 class="text-2xl font-extrabold text-white tracking-tight flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-bolt text-indigo-500"></i> Thrift.
                    </h3>
                    <p class="text-slate-400 text-sm mt-2">Gaya Sultan, Harga Teman.</p>
                </div>
                <div class="flex space-x-6 text-sm font-medium text-slate-400">
                    <a href="#" class="hover:text-white transition">Tentang Kami</a>
                    <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-white transition">Bantuan</a>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-10 pt-6 text-center text-xs text-slate-500">
                &copy; <?= date('Y') ?> ThriftingKece Apps. All rights reserved.
            </div>
        </div>
    </footer>
<?php else: ?>
    <div class="py-6 text-center text-xs text-gray-400">
        Admin Panel &copy; <?= date('Y') ?>
    </div>
    </div> </div> <?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. VALIDASI FORM CANTIK (Mencegah "Please fill out this field")
        const forms = document.querySelectorAll('form');

        forms.forEach(form => {
            // Matikan validasi bawaan browser
            form.setAttribute('novalidate', true);

            form.addEventListener('submit', function(e) {
                let isValid = true;
                let firstErrorInput = null;

                // Cari semua input/textarea/select yang wajib diisi (required)
                const requiredInputs = form.querySelectorAll('[required]');

                requiredInputs.forEach(input => {
                    // Jika kosong
                    if (!input.value.trim()) {
                        isValid = false;
                        
                        // Beri border merah
                        input.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                        
                        // Hilangkan merah saat user mulai mengetik
                        input.addEventListener('input', function() {
                            this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                        }, {once: true});

                        if (!firstErrorInput) firstErrorInput = input;
                    }
                });

                // Jika ada yang kosong, stop submit & munculkan SweetAlert
                if (!isValid) {
                    e.preventDefault(); // Stop kirim data
                    e.stopPropagation();
                    
                    // Fokus ke input pertama yang salah
                    if (firstErrorInput) firstErrorInput.focus();

                    Swal.fire({
                        icon: 'warning',
                        title: 'Belum Lengkap!',
                        text: 'Mohon isi kolom pesan atau data yang masih kosong.',
                        confirmButtonColor: '#4f46e5',
                        confirmButtonText: 'Oke, Saya Isi'
                    });
                }
            });
        });

        // 2. ALERT KONFIRMASI (Hapus/Bayar/Logout)
        document.addEventListener('click', function(e) {
            const trigger = e.target.closest('[data-confirm]');
            if (trigger) {
                e.preventDefault(); 
                const message = trigger.getAttribute('data-confirm');
                const href = trigger.getAttribute('href');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            }
        });

        // 3. NOTIFIKASI SUKSES (PHP Session)
        <?php if(isset($_SESSION['flash_success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= $_SESSION['flash_success'] ?>',
                timer: 3000,
                showConfirmButton: false,
                position: 'center'
            });
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        
        // 4. NOTIFIKASI ERROR (PHP Session)
        <?php if(isset($_SESSION['flash_error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $_SESSION['flash_error'] ?>',
                confirmButtonColor: '#ef4444'
            });
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

    });
</script>

</body>
</html>