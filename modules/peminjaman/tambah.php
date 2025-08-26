<?php
// Error handling pertama
error_reporting(0);
ini_set('display_errors', 0);

// Include config database terlebih dahulu
include_once '../../config/database.php';

// Ambil data anggota dan buku untuk dropdown
$sql_anggota = "SELECT * FROM anggota ORDER BY nama";
$result_anggota = $conn->query($sql_anggota);

$sql_buku = "SELECT * FROM buku WHERE jumlah > 0 ORDER BY judul_buku";
$result_buku = $conn->query($sql_buku);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $status = 'Dipinjam';
    
    // Kurangi stok buku
    $sql_update_buku = "UPDATE buku SET jumlah = jumlah - 1 WHERE id = $id_buku";
    $conn->query($sql_update_buku);
    
    $sql = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status) 
            VALUES ($id_anggota, $id_buku, '$tanggal_pinjam', '$tanggal_kembali', '$status')";
    
    // Gunakan output buffering untuk menangkap output yang tidak diinginkan
            ob_start(); // Mulai buffer output
    
    if ($conn->query($sql)) {
        header("Location: index.php?success=tambah");
        exit();
    } else {
        $error = "Gagal menambahkan data: " . $conn->error;
        ob_end_clean(); // Bersihkan buffer
    }
}

// Setelah semua processing PHP, baru include header
include_once '../../includes/header.php';
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tambah Peminjaman</h2>
        <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_anggota" class="form-label">Anggota</label>
                        <select class="form-select" id="id_anggota" name="id_anggota" required>
                            <option value="">Pilih Anggota</option>
                            <?php
                            if ($result_anggota->num_rows > 0) {
                                while($row = $result_anggota->fetch_assoc()) {
                                    echo "<option value='".$row['id']."'>".$row['nis']." - ".$row['nama']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="id_buku" class="form-label">Buku</label>
                        <select class="form-select" id="id_buku" name="id_buku" required>
                            <option value="">Pilih Buku</option>
                            <?php
                            if ($result_buku->num_rows > 0) {
                                while($row = $result_buku->fetch_assoc()) {
                                    echo "<option value='".$row['id']."'>".$row['kode_buku']." - ".$row['judul_buku']." (Stok: ".$row['jumlah'].")</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?>