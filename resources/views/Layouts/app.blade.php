<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PinjamAlat - Sistem Peminjaman Alat Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/alert.css') }}">
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

    <!-- STRUKTUR HTML MODAL ALERT (WAJIB ADA BIAR JS BISA BACA ELEMEN) -->
    <div id="customAlertOverlay" class="custom-alert-overlay">
        <div class="custom-alert-box">
            <div id="customAlertIcon" class="custom-alert-icon danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 id="customAlertTitle" class="custom-alert-title">Judul Alert</h3>
            <p id="customAlertMessage" class="custom-alert-message">Pesan penjelasan alert disini...</p>

            <div class="custom-alert-buttons">
                <button type="button" id="customAlertBtnCancel" class="custom-alert-btn cancel">Batal</button>
                <button type="button" id="customAlertBtnConfirm" class="custom-alert-btn confirm-danger">Ya,
                    Yakin</button>
            </div>
        </div>
    </div>

    <!-- Script JS Custom Alert -->
    <script src="{{ asset('js/alert.js') }}"></script>

    <!-- Auto Trigger Notifikasi dari Session Controller -->
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showAlertSuccess('Berhasil!', "{{ session('success') }}");
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showAlertConfirm('Gagal!', "{{ session('error') }}");
            });
        </script>
    @endif

</body>

</html>
