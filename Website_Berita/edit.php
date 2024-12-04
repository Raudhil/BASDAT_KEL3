<?php
require 'db.php';
$db = connectMongo();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $berita = $db->berita->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update article data
        $db->berita->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => [
                'title' => $_POST['title'],
                'summary' => $_POST['summary'],
                'category' => $_POST['category'],
                'author' => $_POST['author']
            ]]
        );
        header('Location: index.php'); // Redirect after editing
        exit;
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
        <label>Judul:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($berita->title) ?>" required><br>
        
        <label>Ringkasan:</label><br>
        <textarea name="summary" required><?= htmlspecialchars($berita->summary) ?></textarea><br>

        <label>Kategori:</label><br>
        <input type="text" name="category" value="<?= htmlspecialchars($berita->category) ?>" required><br>

        <label>Penulis:</label><br>
        <input type="text" name="author" value="<?= htmlspecialchars($berita->author) ?>" required><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
