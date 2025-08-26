<?php
include_once '../../config/database.php';

// Ambil data anggota dengan join kelas
$sql = "SELECT a.*, k.nama_kelas, k.tingkat 
        FROM anggota a 
        JOIN kelas k ON a.id_kelas = k.id 
        ORDER BY a.nama";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Anggota</title>
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
        <h2>LAPORAN DATA ANGGOTA</h2>
        <p>Perpustakaan Digital Sekolah</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$no++."</td>
                            <td>".$row['nis']."</td>
                            <td>".$row['nama']."</td>
                            <td>".$row['tingkat']." ".$row['nama_kelas']."</td>
                            <td>".$row['jenis_kelamin']."</td>
                            <td>".$row['alamat']."</td>
                            <td>".$row['no_telepon']."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data anggota</td></tr>";
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