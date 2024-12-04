<?php
require 'db.php';
$db = connectMongo();

// Mendapatkan kategori yang dipilih dari parameter URL
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Mendapatkan daftar kategori dari MongoDB untuk dropdown
$categories = $db->news->distinct('category');

// Mendapatkan berita berdasarkan kategori yang dipilih
$filter = $categoryFilter ? ['category' => $categoryFilter] : [];
$beritasCursor = $db->news->find($filter);

// Mengubah cursor menjadi array untuk diakses lebih lanjut
$beritas = iterator_to_array($beritasCursor);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Berdasarkan Kategori</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container text-center">
            <h1>Berita Terkini</h1>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Website Berita</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <!-- Link Kembali ke index.php -->
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Kembali ke Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <main class="container my-4">
        <h2 class="text-center mb-4">Cari Berita Berdasarkan Kategori</h2>

        <!-- Dropdown untuk memilih kategori -->
        <form method="GET" action="searchKategori.php" class="mb-4">
            <div class="form-group">
                <label for="category" class="form-label">Pilih Kategori:</label>
                <select id="category" name="category" class="form-select">
                    <option value="">Semua</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category) ?>" <?= $category == $categoryFilter ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Cari</button>
        </form>

        <div class="row">
            <?php if (count($beritas) > 0): ?>
                <?php foreach ($beritas as $berita): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="view.php?id=<?= $berita->_id ?>" class="text-decoration-none">
                                        <?= htmlspecialchars($berita->title) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">Kategori: <?= htmlspecialchars($berita->category) ?> | Penulis: <?= htmlspecialchars($berita->author) ?></p>
                                <p class="card-text"><?= htmlspecialchars($berita->summary) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Tidak ada berita yang ditemukan untuk kategori ini.</p>
            <?php endif; ?>
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
