<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinjamAlat - Sistem Peminjaman Alat Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- 1. CSS MyAlert -->
    <link rel="stylesheet" href="{{ asset('Css/MyAlert.css') }}">

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

    @include('Layouts.sidebar')
  

    
    <!-- 2. JS MyAlert (Ditaruh sebelum partial alert agar ter-load duluan) -->
    <script src="{{ asset('Js/MyAlert.js') }}"></script>

    <!-- 3. Partial Alert (Menangkap flash message & konfirmasi) -->
    @include('Layouts.alert')

</body>

</html>