<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: sans-serif; }
        .table th, .table td { vertical-align: middle; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container mt-5">
        <h2 class="text-center mb-0">LAPORAN PEMINJAMAN BUKU</h2>
        <h4 class="text-center mb-4 text-uppercase">PERPUSTAKAAN DIGITAL</h4>
        <hr>
        
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->nama_lengkap }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</td>
                    <td>{{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') : '-' }}</td>
                    <td>{{ ucfirst($item->status_peminjaman) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-5 d-flex justify-content-end">
            <div class="text-center" style="width: 200px;">
                <p>Dicetak pada: {{ date('d M Y') }}</p>
                <br><br><br>
                <p><strong>( ________________ )</strong></p>
                <p>Petugas Perpustakaan</p>
            </div>
        </div>
    </div>
</body>
</html>