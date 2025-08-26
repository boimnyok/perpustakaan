<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data anggota
$sql = "SELECT a.*, k.nama_kelas, k.tingkat 
        FROM anggota a 
        JOIN kelas k ON a.id_kelas = k.id 
        ORDER BY a.nama";
$result = $conn->query($sql);
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Cetak Kartu Anggota</h2>
    </div>

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
                                        <td>
                                            <a href='cetak-kartu.php?id=".$row['id']."' class='btn btn-sm btn-primary' target='_blank'><i class='bi bi-printer'></i> Cetak</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Tidak ada data anggota</td></tr>";
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