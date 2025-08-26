<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data buku
$sql = "SELECT * FROM buku ORDER BY judul_buku";
$result = $conn->query($sql);
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Buku</h2>
        <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Buku</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            if ($_GET['success'] == 'tambah') echo "Data buku berhasil ditambahkan!";
            if ($_GET['success'] == 'edit') echo "Data buku berhasil diubah!";
            if ($_GET['success'] == 'hapus') echo "Data buku berhasil dihapus!";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>".$no++."</td>
                                        <td>".$row['kode_buku']."</td>
                                        <td>".$row['judul_buku']."</td>
                                        <td>".$row['pengarang']."</td>
                                        <td>".$row['penerbit']."</td>
                                        <td>".$row['tahun_terbit']."</td>
                                        <td>".$row['jumlah']."</td>
                                        <td>
                                            <a href='edit.php?id=".$row['id']."' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                                            <a href='hapus.php?id=".$row['id']."' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'><i class='bi bi-trash'></i></a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>Tidak ada data buku</td></tr>";
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