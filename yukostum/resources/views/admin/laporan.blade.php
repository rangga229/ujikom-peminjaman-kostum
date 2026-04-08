<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemasukan Yukostum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk merapikan hasil Print di kertas */
        @media print {
            @page { margin: 1cm; }
            body { font-size: 12pt; color: black; background: white; }
            .btn-print { display: none; } /* Sembunyikan tombol print saat dicetak */
        }
    </style>
</head>
<body class="bg-white p-4">

    <div class="container-fluid">
        <div class="text-center border-bottom border-dark pb-3 mb-4">
            <h2 class="fw-bold mb-1">🎭 YUKOSTUM</h2>
            <p class="mb-0">Jl. Contoh Alamat No. 123, Kota Semarang</p>
            <h4 class="mt-3 fw-bold text-uppercase">Laporan Rekapitulasi Pendapatan</h4>
            <small>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} | Oleh: {{ Auth::user()->name }}</small>
        </div>

        <table class="table table-bordered border-dark text-center align-middle">
            <thead class="table-light border-dark">
                <tr>
                    <th>No.</th>
                    <th>ID Order</th>
                    <th>Pelanggan</th>
                    <th>Kostum</th>
                    <th>Tgl Selesai</th>
                    <th>Biaya Sewa</th>
                    <th>Biaya Denda</th>
                    <th>Total Masuk</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rentals as $index => $sewa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>#ORD-00{{ $sewa->id }}</td>
                    <td class="text-start">{{ $sewa->user->name ?? 'User Dihapus' }}</td>
                    <td class="text-start">{{ $sewa->costume->name ?? 'Kostum Dihapus' }}</td>
                    <td>{{ \Carbon\Carbon::parse($sewa->updated_at)->format('d/m/Y') }}</td>
                    <td class="text-end">Rp {{ number_format($sewa->total_price, 0, ',', '.') }}</td>
                    <td class="text-end text-danger">Rp {{ number_format($sewa->denda, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($sewa->total_price + $sewa->denda, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-3">Belum ada transaksi yang selesai.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="table-light border-dark fw-bold">
                <tr>
                    <td colspan="5" class="text-end fs-5">TOTAL KESELURUHAN:</td>
                    <td class="text-end text-primary fs-5">Rp {{ number_format($totalSewa, 0, ',', '.') }}</td>
                    <td class="text-end text-danger fs-5">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
                    <td class="text-end text-success fs-5">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="text-center mt-5 btn-print">
            <button onclick="window.print()" class="btn btn-primary btn-lg fw-bold shadow-sm px-5">🖨️ Cetak Laporan Sekarang</button>
            <a href="/admin/sewa" class="btn btn-outline-secondary btn-lg ms-2">Kembali</a>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>