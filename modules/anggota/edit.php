<?php
// Error handling pertama
error_reporting(0);
ini_set('display_errors', 0);

// Include config database terlebih dahulu
include_once '../../config/database.php';

$id = $_GET['id'];
$sql = "SELECT * FROM anggota WHERE id = $id";
$result = $conn->query($sql);
$anggota = $result->fetch_assoc();

// Ambil data kelas untuk dropdown
$sql_kelas = "SELECT * FROM kelas ORDER BY tingkat, nama_kelas";
$result_kelas = $conn->query($sql_kelas);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    
    $sql = "UPDATE anggota SET 
            nis = '$nis', 
            nama = '$nama', 
            id_kelas = $id_kelas, 
            jenis_kelamin = '$jenis_kelamin', 
            alamat = '$alamat', 
            no_telepon = '$no_telepon' 
            WHERE id = $id";
    
    // Gunakan output buffering untuk menangkap output yang tidak diinginkan
            ob_start(); // Mulai buffer output
    
    if ($conn->query($sql)) {
        header("Location: index.php?success=edit");
        exit();
    } else {
        $error = "Gagal mengubah data: " . $conn->error;
        ob_end_clean(); // Bersihkan buffer
    }
}

// Setelah semua processing PHP, baru include header
include_once '../../includes/header.php';
?>

<div class="main-content" style="margin-left: 220px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Anggota</h2>
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
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $anggota['nis']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $anggota['nama']; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_kelas" class="form-label">Kelas</label>
                        <select class="form-select" id="id_kelas" name="id_kelas" required>
                            <option value="">Pilih Kelas</option>
                            <?php
                            if ($result_kelas->num_rows > 0) {
                                while($row = $result_kelas->fetch_assoc()) {
                                    $selected = $anggota['id_kelas'] == $row['id'] ? 'selected' : '';
                                    echo "<option value='".$row['id']."' $selected>".$row['tingkat']." ".$row['nama_kelas']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki" <?php echo $anggota['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php echo $anggota['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo $anggota['alamat']; ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?php echo $anggota['no_telepon']; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?>