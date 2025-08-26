<?php
include_once '../../config/database.php';

$id = $_GET['id'];
$denda = $_GET['denda'];

// Update status peminjaman
$sql = "UPDATE peminjaman SET status = 'Dikembalikan', tanggal_kembali = CURDATE(), denda = $denda WHERE id = $id";

if ($conn->query($sql)) {
    // Tambah stok buku
    $sql_buku = "SELECT id_buku FROM peminjaman WHERE id = $id";
    $result = $conn->query($sql_buku);
    $peminjaman = $result->fetch_assoc();
    $id_buku = $peminjaman['id_buku'];
    
    $sql_update_buku = "UPDATE buku SET jumlah = jumlah + 1 WHERE id = $id_buku";
    $conn->query($sql_update_buku);
    
    header("Location: index.php?success=true");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>