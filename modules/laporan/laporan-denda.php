<?php
include_once '../../config/database.php';

// Ambil data denda
$sql = "SELECT p.*, a.nama, a.nis, k.nama_kelas, k.tingkat, b.judul_buku 
        FROM peminjaman p 
        JOIN anggota a ON p.id_anggota = a.id 
        JOIN kelas k ON a.id_kelas = k.id
        JOIN buku b ON p.id_buku = b.id 
        WHERE p.denda > 0 
        ORDER BY p.tanggal_kembali DESC";
$result = $conn->query($sql);

// Hitung total denda
$sql_total = "SELECT SUM(denda) as total FROM peminjaman WHERE denda > 0";
$result_total = $conn->query($sql_total);
$total_denda = $result_total->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Denda</title>
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
        .total-denda {
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 16px;
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
        <h2>LAPORAN DATA DENDA</h2>
        <p>Perpustakaan Digital Sekolah</p>
    </div>

    <div class="total-denda">
        Total Denda Terkumpul: Rp <?php echo number_format($total_denda, 0, ',', '.'); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Kelas</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$no++."</td>
                            <td>".$row['nis']." - ".$row['nama']."</td>
                            <td>".$row['tingkat']." ".$row['nama_kelas']."</td>
                            <td>".$row['judul_buku']."</td>
                            <td>".date('d M Y', strtotime($row['tanggal_pinjam']))."</td>
                            <td>".date('d M Y', strtotime($row['tanggal_kembali']))."</td>
                            <td>Rp ".number_format($row['denda'], 0, ',', '.')."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data denda</td></tr>";
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