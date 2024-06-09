<?php
session_start();

// Ambil informasi pembayaran dari sesi
$jumlahUang = isset($_SESSION['jumlah_uang']) ? $_SESSION['jumlah_uang'] : 0;
$totalBayar = isset($_SESSION['total_bayar']) ? $_SESSION['total_bayar'] : 0;
$kembali = isset($_SESSION['kembali']) ? $_SESSION['kembali'] : 0;
$barang = isset($_SESSION['barang']) ? $_SESSION['barang'] : [];

// Hapus informasi pembayaran dari sesi setelah diambil
unset($_SESSION['jumlah_uang']);
unset($_SESSION['total_bayar']);
unset($_SESSION['kembali']);
unset($_SESSION['barang']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Bukti Pembayaran</title>
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
        }
        .table {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .summary {
            margin-top: 20px;
        }
        .summary p {
            font-size: 1.1rem;
            font-weight: bold;
        }
        .btn-primary {
            margin-right: 10px;
        }
        .btn-info {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bukti Pembayaran</h1>
        <p class="text-center"><strong>No. Transaksi:</strong> #<?php echo rand(1000000, 9999999); ?></p>
        <p class="text-center"><strong>Tanggal:</strong> <?php echo date("F d, Y"); ?></p>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nama']); ?></td>
                        <td>Rp <?php echo number_format($item['harga'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($item['jumlah']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="summary text-center">
            <p>Uang Yang Dibayarkan: Rp <?php echo number_format($jumlahUang, 2, ',', '.'); ?></p>
            <p>Total: Rp <?php echo number_format($totalBayar, 2, ',', '.'); ?></p>
            <p>Kembalian: Rp <?php echo number_format($kembali, 2, ',', '.'); ?></p>
        </div>
        <p class="text-center">Terimakasih telah berbelanja di <strong>TOKO SEJAHTERA</strong></p>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">← Kembali</a>
            <button onclick="window.print()" class="btn btn-info">Cetak</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
