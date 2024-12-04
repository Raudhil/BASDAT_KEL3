<?php
require 'db.php';
$db = connectMongo();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        $id = new MongoDB\BSON\ObjectId($_GET['id']);
    } catch (Exception $e) {
        // Jika ID tidak valid
        echo "ID tidak valid.";
        exit;
    }

    // Cari berita berdasarkan ID
    $berita = $db->news->findOne(['_id' => $id]);

    if (!$berita) {
        echo "Berita tidak ditemukan.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validasi data input
        $title = trim($_POST['title']);
        $summary = trim($_POST['summary']);
        $category = trim($_POST['category']);
        $author = trim($_POST['author']);

        if (empty($title) || empty($summary) || empty($category) || empty($author)) {
            echo "Semua kolom wajib diisi.";
        } else {
            // Update data berita
            $db->news->updateOne(
                ['_id' => $id],
                ['$set' => [
                    'title' => $title,
                    'summary' => $summary,
                    'category' => $category,
                    'author' => $author,
                ]]
            );
            header('Location: index.php'); // Redirect setelah sukses
            exit;
        }
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Berita</title>
</head>
<body>
    <header>
        <h1>Edit Berita</h1>
    </header>

    <form method="post">
        <label for="title">Judul:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($berita->title) ?>" required><br><br>
        
        <label for="summary">Ringkasan:</label><br>
        <textarea id="summary" name="summary" required><?= htmlspecialchars($berita->summary) ?></textarea><br><br>

        <label for="category">Kategori:</label><br>
        <input type="text" id="category" name="category" value="<?= htmlspecialchars($berita->category) ?>" required><br><br>

        <label for="author">Penulis:</label><br>
        <input type="text" id="author" name="author" value="<?= htmlspecialchars($berita->author) ?>" required><br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
