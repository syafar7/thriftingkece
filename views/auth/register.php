<?php include ROOT_PATH . '/views/layouts/header.php'; ?>

<div class="flex justify-center items-center min-h-[80vh] bg-gray-50 fade-in py-10">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-indigo-600 mb-2">Buat Akun Baru</h1>
            <p class="text-gray-500 text-sm">Gabung komunitas thrifting terbesar.</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST">
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" name="name" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500 transition" placeholder="Nama Kamu" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500 transition" placeholder="nama@email.com" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    
                    <input type="password" name="password" id="regPass" class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-indigo-500 transition" placeholder="Minimal 8 karakter" required minlength="8">
                    
                    <button type="button" onclick="togglePassword('regPass', 'regEye')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-600 cursor-pointer focus:outline-none">
                        <i class="fas fa-eye" id="regEye"></i>
                    </button>
                </div>
            </div>

            <button class="w-full bg-black text-white py-3 rounded-xl font-bold hover:bg-gray-800 transition shadow-lg transform active:scale-95">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500">
            Sudah punya akun? 
            <a href="/login" class="text-indigo-600 font-bold hover:underline">Login disini</a>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

<?php include ROOT_PATH . '/views/layouts/footer.php'; ?>