<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data kelas
$sql = "SELECT * FROM kelas ORDER BY tingkat, nama_kelas";
$result = $conn->query($sql);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kelas</h1>
        <a href="tambah.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Kelas
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            if ($_GET['success'] == 'tambah') echo "Data kelas berhasil ditambahkan!";
            if ($_GET['success'] == 'edit') echo "Data kelas berhasil diubah!";
            if ($_GET['success'] == 'hapus') echo "Data kelas berhasil dihapus!";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas</h6>
            <a href="tambah.php" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Kelas</th>
                            <th width="20%">Tingkat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td class='text-center'>".$no++."</td>
                                        <td>".htmlspecialchars($row['nama_kelas'])."</td>
                                        <td class='text-center'>".htmlspecialchars($row['tingkat'])."</td>
                                        <td class='text-center'>
                                            <div class='btn-group' role='group'>
                                                <a href='edit.php?id=".$row['id']."' class='btn btn-warning btn-sm' title='Edit'>
                                                    <i class='bi bi-pencil'></i>
                                                </a>
                                                <a href='hapus.php?id=".$row['id']."' class='btn btn-danger btn-sm' 
                                                   onclick='return confirm(\"Yakin ingin menghapus kelas ini?\")' title='Hapus'>
                                                    <i class='bi bi-trash'></i>
                                                </a>
                                            </div>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='4' class='text-center py-4'>
                                        <div class='text-muted'>
                                            <i class='bi bi-inbox display-4'></i>
                                            <p class='mt-3'>Belum ada data kelas</p>
                                            <a href='tambah.php' class='btn btn-primary mt-2'>
                                                <i class='bi bi-plus-circle'></i> Tambah Kelas Pertama
                                            </a>
                                        </div>
                                    </td>
                                  </tr>";
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