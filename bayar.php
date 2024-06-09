<?php
session_start();

// Hitung total yang harus dibayarkan
$totalBayar = 0;
foreach ($_SESSION['barang'] as $barang) {
    $totalBayar += $barang['total'];
}

// Tangani aksi tombol bayar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bayar'])) {
    $jumlahUang = $_POST['jumlah_uang'];
    if ($jumlahUang >= $totalBayar) {
        // Simpan informasi pembayaran ke sesi
        $_SESSION['jumlah_uang'] = $jumlahUang;
        $_SESSION['total_bayar'] = $totalBayar;
        $kembali = $jumlahUang - $totalBayar;
        $_SESSION['kembali'] = $kembali;

        // Redirect ke halaman cetak
        header("Location: cetak.php");
        exit;
    } else {
        $pesan = "Uang tidak cukup untuk membayar!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Bayar Sekarang</title>
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 2rem;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
        }
        .btn-secondary {
            width: 100%;
            padding: 10px;
        }
        .alert {
            margin-top: 20px;
        }
        .total-text {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h1>Bayar Sekarang</h1>
            </div>
            <div class="card-body">
                <?php if (isset($pesan)): ?>
                    <div class="alert alert-danger text-center"><?php echo $pesan; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="jumlah_uang" class="form-label">Jumlah Uang</label>
                        <input type="number" id="jumlah_uang" name="jumlah_uang" class="form-control" placeholder="Masukkan jumlah uang" required>
                    </div>
                    <div class="text-center total-text">
                        <p>Total yang harus dibayarkan: Rp. <?php echo number_format($totalBayar, 2, ',', '.'); ?></p>
                    </div>
                    <button type="submit" name="bayar" class="btn btn-primary mb-2">Bayar</button>
                    <a href="index.php" class="btn btn-secondary">← Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
