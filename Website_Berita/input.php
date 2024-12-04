<?php
require 'db.php';
$db = connectMongo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db->berita->insertOne([
        'title' => $_POST['title'],
        'summary' => $_POST['summary'],
        'category' => $_POST['category'],
        'author' => $_POST['author'],
        'created_at' => new MongoDB\BSON\UTCDateTime(),
        'updated_at' => new MongoDB\BSON\UTCDateTime(),
    ]);
    header('Location: index.php'); // Redirect to the news list after insertion
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Berita</title>
</head>
<body>
    <header>
        <h1>Tambah Berita Baru</h1>
    </header>

    <form method="post">
        <label>Judul:</label><br>
        <input type="text" name="title" required><br>
        
        <label>Ringkasan:</label><br>
        <textarea name="summary" required></textarea><br>

        <label>Kategori:</label><br>
        <input type="text" name="category" required><br>

        <label>Penulis:</label><br>
        <input type="text" name="author" required><br>

        <button type="submit">Tambah Berita</button>
    </form>
</body>
</html>
