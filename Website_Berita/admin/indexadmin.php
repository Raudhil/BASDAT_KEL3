<?php
require '../config/db.php';
$db = connectMongo();

// Mendapatkan daftar semua berita
$beritas = $db->news->find(); // Menampilkan semua berita
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terkini</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menggunakan flexbox agar footer tetap berada di bawah */
        html, body {
            height: 100%;
            margin: 0;
        }
        .content {
            min-height: 100%; /* Agar konten memanjang sesuai tinggi layar */
            display: flex;
            flex-direction: column;
        }
        footer {
            margin-top: auto; /* Memastikan footer berada di bawah */
        }
    </style>
</head>
<body>
    <div class="content">
        <header class="bg-dark text-white py-3">
            <div class="container text-center">
                <h1>Berita Terkini</h1>
            </div>
        </header>

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">Website Berita</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto"> <!-- ms-auto untuk mengalihkan tombol ke kanan -->
                    <!-- Tombol Baru di Kiri Login -->
                    <li class="nav-item">
                        <a href="searchKategori.php" class="btn btn-outline-light me-2">Cari Berdasarkan Kategori</a>
                    </li>    
                    <li class="nav-item">
                            <a class="nav-link" href="input.php">Tambah Berita</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../public/logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?');">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container my-4">
            <h2 class="text-center mb-4">Semua Berita</h2>

            <div class="row">
                <?php foreach ($beritas as $berita): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="../public/view.php?id=<?= $berita->_id ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($berita->title) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">Kategori: <?= htmlspecialchars($berita->category) ?> | Penulis: <?= htmlspecialchars($berita->author) ?></p>
                                <p class="card-text"><?= htmlspecialchars($berita->summary) ?></p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <!-- Tombol Edit -->
                                <a href="edit.php?id=<?= $berita->_id ?>" class="btn btn-warning btn-sm">Edit</a>
                                <!-- Tombol Delete -->
                                <a href="delete.php?id=<?= $berita->_id ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <footer class="bg-dark text-white py-3">
    <div class="container d-flex justify-content-center">
        <p class="mb-0">&copy; 2024 Website Berita</p>
    </div>
</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
