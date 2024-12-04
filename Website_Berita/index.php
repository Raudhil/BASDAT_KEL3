<?php
session_start(); // Memulai session untuk cek status login
require 'db.php';
$db = connectMongo();

// Cek apakah user sudah login
$loggedIn = isset($_SESSION['admin']); // Menggunakan session untuk memeriksa login

// Mendapatkan daftar semua berita
$beritas = $db->news->find(); // Menampilkan semua berita
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Terkini</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        nav {
            background: #444;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
        }
        .berita {
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
            padding-bottom: 10px;
            text-align: center;
        }
        .ringkasan {
            color: #555;
        }
        .footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
        h2 a {
            text-decoration: none;
            color: #333;
        }
        h2 a:hover {
            color: #007bff;
        }
        .login-btn {
            float: right; /* Menempatkan tombol login di pojok kanan atas */
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <?php if (!$loggedIn): ?>
            <a href="login.php" class="login-btn">Login</a>
        <?php else: ?>
            <a href="logout.php" class="login-btn">Logout</a> <!-- Tombol logout -->
        <?php endif; ?>
        <h1>Berita Terkini</h1>
        <!-- Menampilkan tombol login jika belum login -->
    </header>

    <nav>
        <a href="index.php">Semua Berita</a>
        <a href="categories.php">Kategori</a>
        <a href="input.php">Tambah Berita</a>
    </nav>

    <main>
        <!-- Menampilkan tombol login jika belum login -->
        <?php if (!$loggedIn): ?>
        <?php else: ?>
            <span>Selamat datang, Admin!</span> <!-- Menampilkan pesan setelah login -->
        <?php endif; ?>
        <h2>Semua Berita</h2>

        <?php foreach ($beritas as $berita): ?>
            <div class="berita">
                <h2><a href="view.php?id=<?= $berita->_id ?>"><?= htmlspecialchars($berita->title) ?></a></h2>
                <p class="ringkasan"><?= htmlspecialchars($berita->summary) ?></p>
                <p><small>Kategori: <?= htmlspecialchars($berita->category) ?> | Penulis: <?= htmlspecialchars($berita->author) ?></small></p>
            </div>
        <?php endforeach; ?>
    </main>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Website Berita</p>
    </footer>
</body>
</html>
