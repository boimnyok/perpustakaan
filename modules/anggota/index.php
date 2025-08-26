<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data anggota dengan join kelas
$sql = "SELECT a.*, k.nama_kelas, k.tingkat 
        FROM anggota a 
        JOIN kelas k ON a.id_kelas = k.id 
        ORDER BY a.nama";
$result = $conn->query($sql);
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Anggota</h2>
        <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Anggota</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            if ($_GET['success'] == 'tambah') echo "Data anggota berhasil ditambahkan!";
            if ($_GET['success'] == 'edit') echo "Data anggota berhasil diubah!";
            if ($_GET['success'] == 'hapus') echo "Data anggota berhasil dihapus!";
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
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telepon</th>
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
                                        <td>".$row['nis']."</td>
                                        <td>".$row['nama']."</td>
                                        <td>".$row['tingkat']." ".$row['nama_kelas']."</td>
                                        <td>".$row['jenis_kelamin']."</td>
                                        <td>".$row['no_telepon']."</td>
                                        <td>
                                            <a href='edit.php?id=".$row['id']."' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                                            <a href='hapus.php?id=".$row['id']."' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'><i class='bi bi-trash'></i></a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada data anggota</td></tr>";
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