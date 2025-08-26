<?php
include_once '../../config/database.php';

$filter_anggota = isset($_GET['anggota']) ? $_GET['anggota'] : '';
$filter_tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$filter_tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

// Query riwayat peminjaman dengan filter
$sql = "SELECT p.*, a.nama, a.nis, k.nama_kelas, k.tingkat, b.judul_buku 
        FROM peminjaman p 
        JOIN anggota a ON p.id_anggota = a.id 
        JOIN kelas k ON a.id_kelas = k.id
        JOIN buku b ON p.id_buku = b.id 
        WHERE 1=1";
        
if (!empty($filter_anggota)) {
    $sql .= " AND p.id_anggota = $filter_anggota";
}

if (!empty($filter_tanggal_awal) && !empty($filter_tanggal_akhir)) {
    $sql .= " AND p.tanggal_pinjam BETWEEN '$filter_tanggal_awal' AND '$filter_tanggal_akhir'";
}

$sql .= " ORDER BY p.created_at DESC";

$result = $conn->query($sql);

// Jika filter by anggota, ambil data anggota
$anggota_detail = null;
if (!empty($filter_anggota)) {
    $sql_anggota = "SELECT a.*, k.nama_kelas, k.tingkat 
                    FROM anggota a 
                    JOIN kelas k ON a.id_kelas = k.id 
                    WHERE a.id = $filter_anggota";
    $result_anggota = $conn->query($sql_anggota);
    $anggota_detail = $result_anggota->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Riwayat Peminjaman</title>
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
        .info-anggota {
            margin-bottom: 15px;
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
        <h2>LAPORAN RIWAYAT PEMINJAMAN</h2>
        <p>Perpustakaan Digital Sekolah</p>
        <p>Periode: 
            <?php 
            if (!empty($filter_tanggal_awal) && !empty($filter_tanggal_akhir)) {
                echo date('d M Y', strtotime($filter_tanggal_awal)) . ' - ' . date('d M Y', strtotime($filter_tanggal_akhir));
            } else {
                echo 'Semua Waktu';
            }
            ?>
        </p>
    </div>

    <?php if (!empty($filter_anggota) && $anggota_detail): ?>
    <div class="info-anggota">
        <p><strong>NIS:</strong> <?php echo $anggota_detail['nis']; ?></p>
        <p><strong>Nama:</strong> <?php echo $anggota_detail['nama']; ?></p>
        <p><strong>Kelas:</strong> <?php echo $anggota_detail['tingkat'] . ' ' . $anggota_detail['nama_kelas']; ?></p>
    </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <?php if (empty($filter_anggota)): ?>
                <th>Anggota</th>
                <?php endif; ?>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$no++."</td>";
                    if (empty($filter_anggota)) {
                        echo "<td>".$row['nama']."</td>";
                    }
                    echo "<td>".$row['judul_buku']."</td>
                            <td>".date('d M Y', strtotime($row['tanggal_pinjam']))."</td>
                            <td>".($row['tanggal_kembali'] ? date('d M Y', strtotime($row['tanggal_kembali'])) : '-')."</td>
                            <td>".$row['status']."</td>
                            <td>Rp ".number_format($row['denda'], 0, ',', '.')."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='".(empty($filter_anggota) ? 7 : 6)."' class='text-center'>Tidak ada data riwayat peminjaman</td></tr>";
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