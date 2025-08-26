<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data admin
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM admin WHERE id = $admin_id";
$result = $conn->query($sql);
$admin = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE admin SET nama_lengkap = '$nama_lengkap', username = '$username', password = '$password_hashed' WHERE id = $admin_id";
    } else {
        $sql = "UPDATE admin SET nama_lengkap = '$nama_lengkap', username = '$username' WHERE id = $admin_id";
    }
    
    if ($conn->query($sql)) {
        $_SESSION['admin_nama'] = $nama_lengkap;
        $_SESSION['admin_username'] = $username;
        $success = "Profil berhasil diperbarui!";
    } else {
        $error = "Gagal memperbarui profil: " . $conn->error;
    }
}
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pengaturan</h2>
    </div>

    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $admin['nama_lengkap']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $admin['username']; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirm" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm">
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