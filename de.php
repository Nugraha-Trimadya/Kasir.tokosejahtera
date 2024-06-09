<?php
session_start();

if (!isset($_SESSION['barang'])) {
    $_SESSION['barang'] = array();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    if ($_POST['nama_barang'] != "" && $_POST['harga'] != "" && $_POST['jumlah'] != "") {
        $nama_barang = $_POST['nama_barang'];
        $harga = $_POST['harga'];
        $jumlah = $_POST['jumlah'];
        $total = $harga * $jumlah;


        $item_exists = false;
        foreach ($_SESSION['barang'] as &$item) {
            if ($item['nama'] == $nama_barang) {
                $item['jumlah'] += $jumlah;
                $item['total'] = $item['harga'] * $item['jumlah'];
                $item_exists = true;
                break;
            }
        }
        unset($item);


        if (!$item_exists) {
            $barang = array(
                'nama' => $nama_barang,
                'harga' => $harga,
                'jumlah' => $jumlah,
                'total' => $total
            );
            array_push($_SESSION['barang'], $barang);
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['hapus'])) {
    $key = $_GET['hapus'];
    unset($_SESSION['barang'][$key]);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$total_barang = count($_SESSION['barang']);
$total_harga = array_sum(array_column($_SESSION['barang'], 'total'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Data Barang</title>
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-control {
            margin-right: 10px;
        }
        .btn-primary, .btn-success {
            margin-right: 10px;
        }
        .table-container {
            margin-top: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Masukan Data Barang</h1>
        <form action="" method="POST" class="d-flex justify-content-center mb-4">
            <input type="text" name="nama_barang" placeholder="Nama barang" class="form-control w-25">
            <input type="number" name="harga" placeholder="Harga" class="form-control w-25">
            <input type="number" name="jumlah" placeholder="Jumlah" class="form-control w-25">
            <button type="submit" name="tambah" class="btn btn-primary">
                <i class="bi bi-cart-plus"></i> Tambah
            </button>
            <div class="d-flex justify-content-end">
            <a href="bayar.php" class="btn btn-success">Bayar</a>
        </div>
        </form>

        <div class="table-container">
            <h3>List Barang</h3>
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['barang'])) {
                        foreach ($_SESSION['barang'] as $key => $barang) {
                            echo "<tr>";
                            echo "<td>" . ($key + 1) . "</td>";
                            echo "<td>" . $barang['nama'] . "</td>";
                            echo "<td>" . $barang['harga'] . "</td>";
                            echo "<td>" . $barang['jumlah'] . "</td>";
                            echo "<td>Rp " . number_format($barang['total'], 0, ',', '.') . "</td>";
                            echo "<td><a href='?hapus=" . $key . "' class='btn btn-danger'>Hapus</a></td>";
                            echo "</tr>";
                        }
                        echo "<tr><td colspan='5' class='text-end'>Total Barang</td><td>$total_barang</td></tr>";
                        echo "<tr><td colspan='5' class='text-end'>Total Harga</td><td>Rp " . number_format($total_harga, 0, ',', '.') . "</td></tr>";
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-danger'>Tidak ada data</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
