<?php
require 'db.php';
$db = connectMongo();

// Mendapatkan daftar semua berita
$beritas = $db->news->find(); // Menampilkan semua berita
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Terkini</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; text-align: center; } /* Menengahkan seluruh body */
        header { background: #333; color: #fff; padding: 10px 20px; text-align: center; }
        nav { background: #444; padding: 10px; text-align: center; }
        nav a { color: #fff; margin: 0 10px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        main { padding: 20px; }
        .berita { border-bottom: 1px solid #ccc; margin-bottom: 20px; padding-bottom: 10px; text-align: center; } /* Menengahkan setiap berita */
        .ringkasan { color: #555; }
        .footer { background: #333; color: #fff; text-align: center; padding: 10px; margin-top: 20px; }
        h2 a { text-decoration: none; color: #333; } /* Menghilangkan underline pada link judul */
        h2 a:hover { color: #007bff; } /* Warna berubah saat hover */
    </style>
</head>
<body>
    <header>
        <h1>Berita Terkini</h1>
    </header>

    <nav>
        <a href="index.php">Semua Berita</a>
        <a href="categories.php">Kategori</a>
        <a href="input.php">Tambah Berita</a>
    </nav>

    <main>
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
