<?php
require 'db.php';
$db = connectMongo();

$id = '674f0b6204e4fb7e62a4b4b9';

// Fetch the article from the database by its ID
$berita = $db->berita->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if (!$berita) {
    // If article not found
    echo "Artikel tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Berita</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; }
        header { background: #333; color: #fff; padding: 10px 20px; text-align: center; }
        nav { background: #444; padding: 10px; text-align: center; }
        nav a { color: #fff; margin: 0 10px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        main { padding: 20px; }
        .content { margin-bottom: 20px; }
        .footer { background: #333; color: #fff; text-align: center; padding: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <header>
        <h1>Detail Berita</h1>
    </header>

    <nav>
        <a href="index.php">Semua Berita</a>
        <a href="categories.php">Kategori</a>
        <a href="input.php">Tambah Berita</a>
    </nav>

    <main>
        <div class="content">
            <h2><?= htmlspecialchars($berita->title) ?></h2>
            <p><small>Kategori: <?= htmlspecialchars($berita->category) ?> | Penulis: <?= htmlspecialchars($berita->author) ?></small></p>
            <p><small>Diposting pada: <?= date("d M Y H:i", strtotime($berita->created_at->toDateTime()->format('Y-m-d H:i:s'))) ?></small></p>
            <p><strong>Ringkasan:</strong> <?= htmlspecialchars($berita->summary) ?></p>
            <p><strong>Konten:</strong></p>
            <p><?= nl2br(htmlspecialchars($berita->content)) ?></p> <!-- Show the full content of the article -->
        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Website Berita</p>
    </footer>
</body>
</html>
