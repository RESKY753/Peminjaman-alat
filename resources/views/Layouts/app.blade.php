<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinjamAlat - Sistem Peminjaman Alat Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/alert.css') }}">
    {{-- <script src="{{ asset('js/alert.js') }}"></script> --}}

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- Panggil Layout Sidebar & Konten Utama -->
    @include('Layouts.sidebar')
    
    <!-- Script JS Custom Alert -->

    
    <!-- Auto Trigger Notifikasi dari Session Controller -->
    {{-- @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof window.showAlertSuccess === 'function') {
                    window.showAlertSuccess('Berhasil!', "{{ session('success') }}");
                } else {
                    console.error('Fungsi showAlertSuccess belum dimuat. Cek file public/js/alert.js!');
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof window.showAlertConfirm === 'function') {
                    window.showAlertConfirm('Gagal!', "{{ session('error') }}");
                }
            });
        </script>
    @endif --}}

</body>

</html>
