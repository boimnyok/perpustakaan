<?php
include_once '../../config/database.php';

$id = $_GET['id'];
$sql = "SELECT a.*, k.nama_kelas, k.tingkat 
        FROM anggota a 
        JOIN kelas k ON a.id_kelas = k.id 
        WHERE a.id = $id";
$result = $conn->query($sql);
$anggota = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota - <?php echo $anggota['nama']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .kartu {
            width: 85mm;
            height: 54mm;
            border: 1px solid #000;
            padding: 5mm;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 3mm;
        }
        .photo {
            width: 20mm;
            height: 25mm;
            border: 1px solid #000;
            float: left;
            margin-right: 3mm;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }
        .info {
            font-size: 10px;
        }
        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 3mm;
            clear: both;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="kartu">
        <div class="header">KARTU ANGGOTA PERPUSTAKAAN</div>
        <div class="photo">FOTO 3x4</div>
        <div class="info">
            <strong>NIS:</strong> <?php echo $anggota['nis']; ?><br>
            <strong>Nama:</strong> <?php echo $anggota['nama']; ?><br>
            <strong>Kelas:</strong> <?php echo $anggota['tingkat'] . ' ' . $anggota['nama_kelas']; ?><br>
            <strong>Jenis Kelamin:</strong> <?php echo $anggota['jenis_kelamin']; ?><br>
        </div>
        <div class="footer">
            Kartu Ini Berlaku Selama Menjadi Siswa di Sekolah Ini
        </div>
    </div>
    
    <div class="no-print" style="margin-top: 20px;">
        <button onclick="window.print()" class="btn btn-primary">Cetak Kartu</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>
</body>
</html>