<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Alat</title>
    <style>
        /* Pengaturan dasar kertas & font (DomPDF mendukung CSS standar, hindari flex/grid) */
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        /* Bagian Kop Laporan */
        .header {
            text-align: center;
            border-bottom: 2px solid #334155;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }

        .header h1 {
            margin: 0 0 4px 0;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
            color: #475569;
        }

        /* Tabel Data Utama */
        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #94a3b8;
            padding: 7px 8px;
            text-align: left;
            vertical-align: middle;
        }

        table.data th {
            background-color: #f1f5f9;
            font-size: 10px;
            text-transform: uppercase;
            color: #0f172a;
        }

        .text-center {
            text-align: center;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        /* Area Tanda Tangan */
        table.ttd {
            width: 100%;
            margin-top: 32px;
            border: none;
        }

        table.ttd td {
            border: none;
            padding: 0;
        }
    </style>
</head>

<body>

    {{-- Kop Laporan --}}
    <div class="header">
        <h1>Laporan Peminjaman Alat</h1>
        <p>Sistem Informasi Inventory &amp; Peminjaman Alat</p>
        <p>
            Periode:
            <strong>
                @if ($tgl_mulai && $tgl_selesai)
                    {{ \Carbon\Carbon::parse($tgl_mulai)->locale('id')->isoFormat('D MMMM YYYY') }} -
                    {{ \Carbon\Carbon::parse($tgl_selesai)->locale('id')->isoFormat('D MMMM YYYY') }}
                @elseif ($tgl_mulai)
                    Mulai {{ \Carbon\Carbon::parse($tgl_mulai)->locale('id')->isoFormat('D MMMM YYYY') }}
                @elseif ($tgl_selesai)
                    Sampai {{ \Carbon\Carbon::parse($tgl_selesai)->locale('id')->isoFormat('D MMMM YYYY') }}
                @else
                    Semua Data
                @endif
            </strong>
        </p>
    </div>

    {{-- Tabel Data Peminjaman --}}
    <table class="data">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="18%">Nama Peminjam</th>
                <th width="25%">Nama Barang / Alat</th>
                <th width="19%">Tgl Pinjam</th>
                <th width="19%">Tgl Kembali</th>
                <th class="text-center" width="14%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $index => $item)
                <tr>
                    {{-- Wajib pakai $index + 1 (bukan firstItem()) karena di PDF pakai ->get(), bukan ->paginate() --}}
                    <td class="text-center">{{ $index + 1 }}</td>

                    <td><strong>{{ $item->username ?? ($item->user->username ?? '-') }}</strong></td>

                    <td>{{ $item->nama_alat ?? ($item->alat->nama_alat ?? '-') }} ({{ $item->jumlah }} Unit)</td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->locale('id')->isoFormat('D MMM YYYY') }}

                    </td>

                    <td>
                        {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->locale('id')->isoFormat('D MMM YYYY') : '-' }}
                    </td>

                    <td class="text-center status">
                        {{ str_replace('_', ' ', $item->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 16px; color: #64748b;">
                        Data laporan tidak ditemukan pada rentang tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Kolom Tanda Tangan Petugas --}}
    <table class="ttd">
        <tr>
            <td width="70%"></td>
            <td width="30%" class="text-center">
                <p style="margin-bottom: 55px;">Petugas Penanggung Jawab,</p>
                <p><strong><u>( {{ auth()->user()->username ?? 'Nama Petugas' }} )</u></strong></p>
            </td>
        </tr>
    </table>

</body>

</html>
