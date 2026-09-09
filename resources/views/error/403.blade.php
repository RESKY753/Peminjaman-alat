<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - 403</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm max-w-md w-full text-center space-y-5">
        <!-- Icon Peringatan -->
        <div
            class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto text-2xl border border-rose-100 shadow-inner">
            <i class="fa-solid fa-ban"></i>
        </div>

        <!-- Teks Informasi -->
        <div class="space-y-1">
            <h1 class="text-xl font-bold text-slate-800">Akses Ditolak (403)</h1>
            <p class="text-xs text-slate-500 leading-relaxed">
                Kamu tidak memiliki hak akses untuk membuka halaman ini karena batasan peran (role) akun.
            </p>
        </div>

        <!-- Pesan Hitung Mundur -->
        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs text-slate-600">
            Otomatis kembali ke halaman login dalam <span id="countdown" class="font-bold text-indigo-600">10</span>
            detik...
        </div>

        <!-- Tombol Aksi -->
        <div class="pt-2 flex flex-col sm:flex-row gap-2">
            <a href="{{ url('/force-logout') }}"
                class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition shadow-sm shadow-indigo-100 flex items-center justify-center space-x-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Login Sekarang</span>
            </a>
        </div>
    </div>

    <!-- Script Hitung Mundur 10 Detik -->
    <!-- Script Hitung Mundur 10 Detik & Hapus Session -->
    <script>
        let timeLeft = 10;
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timer);
                // Lempar ke route force-logout agar session terhapus bersih
                window.location.href = "{{ url('/force-logout') }}";
            }
        }, 1000);
    </script>
    </script>
</body>

</html>