<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data anggota untuk filter
$sql_anggota = "SELECT * FROM anggota ORDER BY nama";
$result_anggota = $conn->query($sql_anggota);

$filter_anggota = isset($_GET['anggota']) ? $_GET['anggota'] : '';
$filter_tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$filter_tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

// Query riwayat peminjaman dengan filter
$sql = "SELECT p.*, a.nama, b.judul_buku 
        FROM peminjaman p 
        JOIN anggota a ON p.id_anggota = a.id 
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
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Peminjaman</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="anggota" class="form-label">Filter Anggota</label>
                        <select class="form-select" id="anggota" name="anggota">
                            <option value="">Semua Anggota</option>
                            <?php
                            if ($result_anggota->num_rows > 0) {
                                while($row = $result_anggota->fetch_assoc()) {
                                    $selected = $filter_anggota == $row['id'] ? 'selected' : '';
                                    echo "<option value='".$row['id']."' $selected>".$row['nis']." - ".$row['nama']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="<?php echo $filter_tanggal_awal; ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo $filter_tanggal_akhir; ?>">
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5>Data Riwayat Peminjaman</h5>
                <a href="cetak.php?anggota=<?php echo $filter_anggota; ?>&tanggal_awal=<?php echo $filter_tanggal_awal; ?>&tanggal_akhir=<?php echo $filter_tanggal_akhir; ?>" class="btn btn-sm btn-primary" target="_blank"><i class="bi bi-printer"></i> Cetak</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
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
                                $status_badge = $row['status'] == 'Dipinjam' ? 
                                    '<span class="badge bg-warning">Dipinjam</span>' : 
                                    '<span class="badge bg-success">Dikembalikan</span>';
                                
                                echo "<tr>
                                        <td>".$no++."</td>
                                        <td>".$row['nama']."</td>
                                        <td>".$row['judul_buku']."</td>
                                        <td>".date('d M Y', strtotime($row['tanggal_pinjam']))."</td>
                                        <td>".($row['tanggal_kembali'] ? date('d M Y', strtotime($row['tanggal_kembali'])) : '-')."</td>
                                        <td>".$status_badge."</td>
                                        <td>Rp ".number_format($row['denda'], 0, ',', '.')."</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada data riwayat peminjaman</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?>