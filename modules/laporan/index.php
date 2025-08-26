<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Hitung statistik
$sql_buku = "SELECT COUNT(*) as total FROM buku";
$result_buku = $conn->query($sql_buku);
$total_buku = $result_buku->fetch_assoc()['total'];

$sql_anggota = "SELECT COUNT(*) as total FROM anggota";
$result_anggota = $conn->query($sql_anggota);
$total_anggota = $result_anggota->fetch_assoc()['total'];

$sql_peminjaman = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'Dipinjam'";
$result_peminjaman = $conn->query($sql_peminjaman);
$total_peminjaman = $result_peminjaman->fetch_assoc()['total'];

$sql_pengembalian = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'Dikembalikan'";
$result_pengembalian = $conn->query($sql_pengembalian);
$total_pengembalian = $result_pengembalian->fetch_assoc()['total'];

$sql_denda = "SELECT SUM(denda) as total FROM peminjaman";
$result_denda = $conn->query($sql_denda);
$total_denda = $result_denda->fetch_assoc()['total'];
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Laporan</h2>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Buku</h5>
                    <h2 class="card-text"><?php echo $total_buku; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Anggota</h5>
                    <h2 class="card-text"><?php echo $total_anggota; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Buku Dipinjam</h5>
                    <h2 class="card-text"><?php echo $total_peminjaman; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-5">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h5 class="card-title">Buku Dikembalikan</h5>
                    <h2 class="card-text"><?php echo $total_pengembalian; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Laporan Buku</h5>
                </div>
                <div class="card-body">
                    <p>Laporan data buku yang tersedia di perpustakaan</p>
                    <a href="laporan-buku.php" class="btn btn-primary" target="_blank">Cetak Laporan Buku</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Laporan Peminjaman</h5>
                </div>
                <div class="card-body">
                    <p>Laporan data peminjaman buku</p>
                    <a href="../riwayat/cetak.php" class="btn btn-primary" target="_blank">Cetak Laporan Peminjaman</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Laporan Denda</h5>
                </div>
                <div class="card-body">
                    <p>Total denda yang terkumpul: <strong>Rp <?php echo number_format($total_denda, 0, ',', '.'); ?></strong></p>
                    <a href="laporan-denda.php" class="btn btn-primary" target="_blank">Cetak Laporan Denda</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Laporan Anggota</h5>
                </div>
                <div class="card-body">
                    <p>Laporan data anggota perpustakaan</p>
                    <a href="laporan-anggota.php" class="btn btn-primary" target="_blank">Cetak Laporan Anggota</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?>