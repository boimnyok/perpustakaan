<?php
// Error handling pertama
error_reporting(0);
ini_set('display_errors', 0);

// Include config database terlebih dahulu
include_once '../../config/database.php';

// Inisialisasi variabel error
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi input
    if (empty($_POST['nama_kelas']) || empty($_POST['tingkat'])) {
        $error = "Semua field harus diisi!";
    } else {
        $nama_kelas = trim($_POST['nama_kelas']);
        $tingkat = trim($_POST['tingkat']);
        
        // Escape input untuk mencegah SQL injection
        $nama_kelas = $conn->real_escape_string($nama_kelas);
        $tingkat = $conn->real_escape_string($tingkat);
        
        // Cek apakah kelas sudah ada
        $check_sql = "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas' AND tingkat = '$tingkat'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result && $check_result->num_rows > 0) {
            $error = "Kelas dengan nama dan tingkat yang sama sudah ada!";
        } else {
            // Insert data baru
            $sql = "INSERT INTO kelas (nama_kelas, tingkat) VALUES ('$nama_kelas', '$tingkat')";
            
        // Gunakan output buffering untuk menangkap output yang tidak diinginkan
            ob_start(); // Mulai buffer output    
            
            if ($conn->query($sql)) {
                header("Location: index.php?success=tambah");
                exit();
            } else {
                $error = "Gagal menambahkan data: " . $conn->error;
                ob_end_clean(); // Bersihkan buffer
                // Debug info - bisa dihapus setelah testing
                error_log("SQL Error: " . $conn->error);
                error_log("SQL Query: " . $sql);
            }
        }
    }
}

// Setelah semua processing PHP, baru include header
include_once '../../includes/header.php';
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kelas</h1>
        <a href="index.php" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kelas</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" 
                                   value="<?php echo isset($_POST['nama_kelas']) ? htmlspecialchars($_POST['nama_kelas']) : ''; ?>" 
                                   required placeholder="Masukkan nama kelas">
                            <div class="form-text">Contoh: A, B, C, IPA, IPS, dll.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tingkat" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select" id="tingkat" name="tingkat" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="X" <?php echo (isset($_POST['tingkat']) && $_POST['tingkat'] == 'X') ? 'selected' : ''; ?>>Kelas X</option>
                                <option value="XI" <?php echo (isset($_POST['tingkat']) && $_POST['tingkat'] == 'XI') ? 'selected' : ''; ?>>Kelas XI</option>
                                <option value="XII" <?php echo (isset($_POST['tingkat']) && $_POST['tingkat'] == 'XII') ? 'selected' : ''; ?>>Kelas XII</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                            <a href="index.php" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once '../../includes/footer.php';
?>