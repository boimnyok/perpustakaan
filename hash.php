<?php
// Password yang ingin Anda gunakan
$password_plain = 'admin';

// Proses hashing
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Tampilkan hash-nya
echo "Password asli: " . $password_plain . "<br>";
echo "Password yang sudah di-hash: " . $password_hashed;
?>