<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data peminjaman dengan join anggota dan buku
$sql = "SELECT p.*, a.nama, b.judul_buku 
        FROM peminjaman p 
        JOIN anggota a ON p.id_anggota = a.id 
        JOIN buku b ON p.id_buku = b.id 
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Peminjaman</h2>
        <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Peminjaman</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            if ($_GET['success'] == 'tambah') echo "Data peminjaman berhasil ditambahkan!";
            if ($_GET['success'] == 'edit') echo "Data peminjaman berhasil diubah!";
            if ($_GET['success'] == 'hapus') echo "Data peminjaman berhasil dihapus!";
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
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
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
                                        <td>
                                            <a href='edit.php?id=".$row['id']."' class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                                            <a href='hapus.php?id=".$row['id']."' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'><i class='bi bi-trash'></i></a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada data peminjaman</td></tr>";
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