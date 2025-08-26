<?php
include_once '../../config/database.php';

$id = $_GET['id'];

// Ambil data peminjaman untuk mengembalikan stok buku jika status masih Dipinjam
$sql_peminjaman = "SELECT * FROM peminjaman WHERE id = $id";
$result = $conn->query($sql_peminjaman);
$peminjaman = $result->fetch_assoc();

if ($peminjaman['status'] == 'Dipinjam') {
    // Kembalikan stok buku
    $sql_update_buku = "UPDATE buku SET jumlah = jumlah + 1 WHERE id = " . $peminjaman['id_buku'];
    $conn->query($sql_update_buku);
}

$sql = "DELETE FROM peminjaman WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: index.php?success=hapus");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>