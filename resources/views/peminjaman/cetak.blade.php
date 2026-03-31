<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 30px;
        }

        .struk {
            background: white;
            width: 380px;
            padding: 30px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .header p {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #888;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .row .label {
            color: #555;
            flex: 1;
        }

        .row .value {
            font-weight: bold;
            flex: 1.2;
            text-align: right;
        }

        .divider {
            border: none;
            border-top: 1px dashed #aaa;
            margin: 15px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending    { background: #fff3cd; color: #856404; }
        .status-dipinjam   { background: #cfe2ff; color: #084298; }
        .status-dikembalikan { background: #d1ecf1; color: #0c5460; }
        .status-selesai    { background: #d1e7dd; color: #0f5132; }

        .footer {
            text-align: center;
            margin-top: 20px;
            border-top: 2px dashed #333;
            padding-top: 15px;
            font-size: 11px;
            color: #777;
        }

        .footer p {
            margin-bottom: 3px;
        }

        .btn-print {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            letter-spacing: 1px;
        }

        .btn-print:hover {
            background: #0b5ed7;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .struk {
                box-shadow: none;
                border-radius: 0;
                width: 100%;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="struk">

    {{-- Header --}}
    <div class="header">
        <h2>📚 PERPUSTAKAAN</h2>
        <p>Struk Peminjaman Buku</p>
        <p>{{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    {{-- Info Peminjam --}}
    <div class="section-title">Data Peminjam</div>
    <div class="row">
        <span class="label">Nama</span>
        <span class="value">{{ $pinjam->user->name }}</span>
    </div>
    <div class="row">
        <span class="label">Email</span>
        <span class="value">{{ $pinjam->user->email }}</span>
    </div>

    <hr class="divider">

    {{-- Info Buku --}}
    <div class="section-title">Data Buku</div>
    <div class="row">
        <span class="label">Judul</span>
        <span class="value">{{ $pinjam->buku->judul }}</span>
    </div>
    <div class="row">
        <span class="label">Pengarang</span>
        <span class="value">{{ $pinjam->buku->pengarang ?? '-' }}</span>
    </div>

    <hr class="divider">

    {{-- Info Peminjaman --}}
    <div class="section-title">Detail Peminjaman</div>
    <div class="row">
        <span class="label">ID Peminjaman</span>
        <span class="value">#{{ str_pad($pinjam->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="row">
        <span class="label">Tgl Pinjam</span>
        <span class="value">
            {{ \Carbon\Carbon::parse($pinjam->tanggal_peminjaman)->format('d/m/Y') }}
        </span>
    </div>
    <div class="row">
        <span class="label">Tgl Kembali</span>
        <span class="value">
            {{ $pinjam->tanggal_pengembalian 
                ? \Carbon\Carbon::parse($pinjam->tanggal_pengembalian)->format('d/m/Y') 
                : '-' }}
        </span>
    </div>
    <div class="row">
        <span class="label">Status</span>
        <span class="value">
            @if($pinjam->status_peminjaman == 'pending')
                <span class="status-badge status-pending">Menunggu Konfirmasi</span>
            @elseif($pinjam->status_peminjaman == 'dipinjam')
                <span class="status-badge status-dipinjam">Sedang Dipinjam</span>
            @elseif($pinjam->status_peminjaman == 'dikembalikan')
                <span class="status-badge status-dikembalikan">Menunggu Konfirmasi</span>
            @elseif($pinjam->status_peminjaman == 'selesai')
                <span class="status-badge status-selesai">Selesai</span>
            @endif
        </span>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami.</p>
        <p>Harap kembalikan buku tepat waktu.</p>
    </div>

    <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>

</div>

</body>
</html>