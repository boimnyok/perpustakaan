<?php
include_once '../../includes/header.php';
include_once '../../config/database.php';

// Ambil data peminjaman yang belum dikembalikan
$sql = "SELECT p.*, a.nama, b.judul_buku 
        FROM peminjaman p 
        JOIN anggota a ON p.id_anggota = a.id 
        JOIN buku b ON p.id_buku = b.id 
        WHERE p.status = 'Dipinjam' 
        ORDER BY p.tanggal_pinjam";
$result = $conn->query($sql);
?>

<div class="main-content" style="margin-left: 50px; padding: 50px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pengembalian Buku</h2>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Buku berhasil dikembalikan!
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
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // Hitung denda (jika terlambat)
                                $tanggal_pinjam = new DateTime($row['tanggal_pinjam']);
                                $tanggal_sekarang = new DateTime();
                                $jatuh_tempo = $tanggal_pinjam->modify('+7 days'); // Jatuh tempo 7 hari
                                
                                $denda = 0;
                                if ($tanggal_sekarang > $jatuh_tempo) {
                                    $selisih = $tanggal_sekarang->diff($jatuh_tempo);
                                    $denda = $selisih->days * 1000; // Denda Rp 1000 per hari
                                }
                                
                                echo "<tr>
                                        <td>".$no++."</td>
                                        <td>".$row['nama']."</td>
                                        <td>".$row['judul_buku']."</td>
                                        <td>".date('d M Y', strtotime($row['tanggal_pinjam']))."</td>
                                        <td>".$jatuh_tempo->format('d M Y')."</td>
                                        <td>Rp ".number_format($denda, 0, ',', '.')."</td>
                                        <td>
                                            <a href='proses.php?id=".$row['id']."&denda=".$denda."' class='btn btn-sm btn-success' onclick='return confirm(\"Yakin ingin memproses pengembalian?\")'>Proses</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada data peminjaman yang aktif</td></tr>";
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