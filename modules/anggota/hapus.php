<?php
include_once '../../config/database.php';

$id = $_GET['id'];
$sql = "DELETE FROM anggota WHERE id = $id";

if ($conn->query($sql)) {
    header("Location: index.php?success=hapus");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>