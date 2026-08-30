<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PinjamAlat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-900 text-slate-800 min-h-screen flex items-center justify-center p-4">

    <!-- Card Login Container -->
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-800">

        <!-- Header Card -->
        <div class="bg-slate-900 p-8 text-center relative border-b border-slate-800">
            <!-- Decorative Accent -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
            </div>

            <div
                class="w-14 h-14 bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-500 text-white font-extrabold text-2xl rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-indigo-500/30 tracking-wider ring-4 ring-slate-800">
                P
            </div>
            <h1 class="text-2xl font-bold text-white tracking-wide">PinjamAlat</h1>
            <p class="text-slate-400 text-xs mt-1">Sistem Peminjaman Inventaris Alat</p>
        </div>

        <!-- Form Login -->
        <form action="{{ route('login.proses')}}" method="POST" class="p-8 space-y-5">
            @csrf

            <!-- Pesan Error / Alert Global -->
            @if(session('error'))
                <div
                    class="p-3 bg-rose-50 border border-rose-200 text-rose-600 rounded-lg text-xs font-semibold flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Input Username / Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email / Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </span>
                    <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="masukkan@email.com"
                        class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                </div>
                @error('email')
                    <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Password</label>
                <div class="relative" x-data="{ show: false }">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required
                        placeholder="••••••••"
                        class="w-full pl-9 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">

                    <!-- Toggle Show/Hide Password -->
                    <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="remember"
                        class="w-3.5 h-3.5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                    <span class="text-slate-600 font-medium">Ingat Saya</span>
                </label>
            </div>

            <!-- Button Submit -->
            <button type="submit"
                class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition duration-200 flex items-center justify-center space-x-2 shadow-lg shadow-indigo-600/20">
                <span>Masuk Ke Akun</span>
                <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
            </button>
        </form>

        <!-- Footer Card -->
        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 text-center">
            <p class="text-[11px] text-slate-400">
                &copy; {{ date('Y') }} PinjamAlat. Hak Cipta Dilindungi.
            </p>
        </div>

    </div>

    <!-- Script AlpineJS untuk Toggle Intip Password -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>