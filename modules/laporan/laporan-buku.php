<?php
include_once '../../config/database.php';

// Ambil data buku
$sql = "SELECT * FROM buku ORDER BY judul_buku";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin-bottom: 5px;
        }
        .header p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA BUKU</h2>
        <p>Perpustakaan Digital Sekolah</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$no++."</td>
                            <td>".$row['kode_buku']."</td>
                            <td>".$row['judul_buku']."</td>
                            <td>".$row['pengarang']."</td>
                            <td>".$row['penerbit']."</td>
                            <td>".$row['tahun_terbit']."</td>
                            <td>".$row['isbn']."</td>
                            <td>".$row['jumlah']."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data buku</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Tanggal Cetak: <?php echo date('d F Y'); ?></p>
    </div>
    
    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-primary">Cetak</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>
</body>
</html>