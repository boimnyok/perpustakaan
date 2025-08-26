<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Hitung jumlah data
$sql_kelas = "SELECT COUNT(*) as total FROM kelas";
$result_kelas = $conn->query($sql_kelas);
$total_kelas = $result_kelas->fetch_assoc()['total'];

$sql_buku = "SELECT COUNT(*) as total FROM buku";
$result_buku = $conn->query($sql_buku);
$total_buku = $result_buku->fetch_assoc()['total'];

$sql_anggota = "SELECT COUNT(*) as total FROM anggota";
$result_anggota = $conn->query($sql_anggota);
$total_anggota = $result_anggota->fetch_assoc()['total'];

$sql_peminjaman = "SELECT COUNT(*) as total FROM peminjaman WHERE status = 'Dipinjam'";
$result_peminjaman = $conn->query($sql_peminjaman);
$total_peminjaman = $result_peminjaman->fetch_assoc()['total'];
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Dashboard</h1>
        <span class="badge bg-primary"><?php echo date('d F Y'); ?></span>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Kelas Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kelas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_kelas; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-house-door fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buku Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Buku</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_buku; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anggota Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Anggota</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_anggota; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peminjaman Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Buku Dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_peminjaman; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-left-right fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Peminjaman Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Anggota</th>
                                    <th>Buku</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT p.*, a.nama, b.judul_buku 
                                        FROM peminjaman p 
                                        JOIN anggota a ON p.id_anggota = a.id 
                                        JOIN buku b ON p.id_buku = b.id 
                                        ORDER BY p.created_at DESC LIMIT 5";
                                $result = $conn->query($sql);
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row['nama']."</td>
                                                <td>".$row['judul_buku']."</td>
                                                <td>".date('d M Y', strtotime($row['tanggal_pinjam']))."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Tidak ada data peminjaman</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Buku Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buku Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Pengarang</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM buku ORDER BY created_at DESC LIMIT 5";
                                $result = $conn->query($sql);
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row['judul_buku']."</td>
                                                <td>".$row['pengarang']."</td>
                                                <td>".$row['tahun_terbit']."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Tidak ada data buku</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?>