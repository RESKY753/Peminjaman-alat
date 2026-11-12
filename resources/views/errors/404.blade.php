<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        h1 {
            font-size: 8rem;
            margin: 0;
            color: #cbd5e1;
            letter-spacing: 5px;
        }

        .badge {
            background-color: #f43f5e;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 0.9rem;
            transform: rotate(-5deg);
            margin-top: -30px;
            position: relative;
        }

        h3 {
            font-size: 1.5rem;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        p {
            color: #64748b;
            max-width: 400px;
            line-height: 1.5;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        a:hover {
            background-color: #4338ca;
        }
    </style>
</head>

<body>
    <h1>404</h1>
    <div class="badge">Halaman Tidak Ditemukan</div>

    <h3>Waduh, Anda sepertinya tersesat.</h3>
    <p>Halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau Anda salah memasukkan alamat URL.</p>

    <a href="{{ url('/') }}">Kembali ke Beranda</a>
</body>

</html>