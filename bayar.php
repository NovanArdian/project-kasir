<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Sekarang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #007bff, #ffffff);
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            font-size: 28px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        button[type="submit"], .btn-secondary {
            width: 100%;
            font-size: 18px;
        }
        .alert {
            margin-bottom: 20px;
        }
        .btn-secondary {
            margin-top: 10px;
        }
        p {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .icon {
            display: inline-block;
            margin-right: 10px;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1><i class="fas fa-wallet icon"></i> Bayar Sekarang</h1>
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
                    $message = "Uang tidak cukup untuk membayar!";
                }
            }
            ?>
            <?php if (isset($message)): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <input type="number" name="jumlah_uang" class="form-control" placeholder="Jumlah Uang" required>
                </div>
                <p>Total yang harus dibayarkan: Rp. <?php echo number_format($totalBayar, 2, ',', '.'); ?></p>
                <button type="submit" name="bayar" class="btn btn-primary"><i class="fas fa-money-bill icon"></i> Bayar</button>
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left icon"></i> Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>
