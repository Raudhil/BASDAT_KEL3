<?php
require '../config/db.php';
$db = connectMongo();

$collection = $db->selectCollection('mycollection');
$categories = $db->berita->distinct('category');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori Berita</title>
</head>
<body>
    <header>
        <h1>Kategori Berita</h1>
    </header>
    
    <nav>
        <a href="index.php">Semua Berita</a>
    </nav>

    <main>
        <h2>Daftar Kategori</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><a href="index.php?kategori=<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Website Berita</p>
    </footer>
</body>
</html>
