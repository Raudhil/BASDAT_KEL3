<?php
session_start(); // Memulai session
session_unset(); // Menghapus semua data session
session_destroy(); // Menghancurkan session
header('Location: index.php'); // Mengarahkan kembali ke halaman utama
exit(); // Menghentikan eksekusi setelah pengalihan
?>
