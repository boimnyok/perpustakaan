<?php
// Error handling pertama
error_reporting(0);
ini_set('display_errors', 0);

include_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_buku = $_POST['kode_buku'];
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $isbn = $_POST['isbn'];
    $jumlah = $_POST['jumlah'];
    
    $sql = "INSERT INTO buku (kode_buku, judul_buku, pengarang, penerbit, tahun_terbit, isbn, jumlah) 
            VALUES ('$kode_buku', '$judul_buku', '$pengarang', '$penerbit', '$tahun_terbit', '$isbn', $jumlah)";
    
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
        <h2>Tambah Buku</h2>
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
                        <label for="kode_buku" class="form-label">Kode Buku</label>
                        <input type="text" class="form-control" id="kode_buku" name="kode_buku" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pengarang" class="form-label">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" min="1900" max="2099" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
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