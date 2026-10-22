<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>

    <!-- Panggil file CSS/Tailwind bawaan Laravel Anda -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome (Opsional, sesuaikan jika Anda pakai icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-slate-50 antialiased flex items-center justify-center min-h-screen">

    <div class="flex flex-col items-center justify-center text-center px-6">
        <div class="relative flex justify-center items-center">
            <h1 class="text-9xl font-extrabold text-slate-200 tracking-widest">
                404
            </h1>
            <div class="bg-rose-500 px-2 py-0.5 text-sm rounded rotate-12 absolute text-white shadow-sm">
                Halaman Tidak Ditemukan
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <h3 class="text-xl font-bold text-slate-800">Waduh, Anda sepertinya tersesat.</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto">
                Halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau Anda salah memasukkan alamat URL.
            </p>

            <div class="pt-4">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    <i class="fa-solid fa-house mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>

</html>