<?php
session_start();

// Inisialisasi array barang jika belum ada
if (!isset($_SESSION['barang'])) {
    $_SESSION['barang'] = [];
}

// Tambah barang ke sesi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $namaBarang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    // Validasi input
    if ($namaBarang != "" && $harga != "" && $jumlah != "") {
        $total = $harga * $jumlah;
        $item = [
            'nama_barang' => $namaBarang,
            'harga' => $harga,
            'jumlah' => $jumlah,
            'total' => $total,
        ];

        $_SESSION['barang'][] = $item;
    }
}

// Hapus barang dari sesi
if (isset($_GET['hapus'])) {
    $index = $_GET['hapus'];
    unset($_SESSION['barang'][$index]);
    // Reset array keys
    $_SESSION['barang'] = array_values($_SESSION['barang']);

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO BOYSCOUT STORE</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #007bff, #ffffff);
            background-attachment: fixed;
            color: #000;
        }


        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 20px;
            border-radius: 10px 10px 0 0;
        }

        .btn-primary,
        .btn-success {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }

            .table th,
            .table td {
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <i class="fas fa-store"></i> BOYSCOUT STORE
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" name="nama_barang" class="form-control" placeholder="Nama barang" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="harga" class="form-control" placeholder="Harga" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" required>
                    </div>
                    <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-plus"></i>
                        Tambah</button>
                    <a href="bayar.php" class="btn btn-success"><i class="fas fa-cash-register"></i> Bayar</a>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header text-center">
                <i class="fas fa-list"></i> List Barang
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
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
                            <?php if (empty($_SESSION['barang'])): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($_SESSION['barang'] as $index => $barang): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($barang['nama_barang']); ?></td>
                                        <td>Rp <?php echo number_format($barang['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($barang['jumlah']); ?></td>
                                        <td>Rp <?php echo number_format($barang['total'], 0, ',', '.'); ?></td>
                                        <td>
                                            <a href="?hapus=<?php echo $index; ?>" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash-alt"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>