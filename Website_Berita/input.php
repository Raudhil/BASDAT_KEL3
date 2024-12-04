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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <header class="mb-4 text-center">
            <h1 class="text-primary">Tambah Berita Baru</h1>
        </header>

        <form method="post" class="shadow-lg p-3 mb-5 bg-body-tertiary rounded bg-light">
            <div class="mb-3">
                <label for="title" class="form-label">Judul:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="summary" class="form-label">Ringkasan:</label>
                <textarea class="form-control" id="summary" name="summary" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Kategori:</label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Penulis:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Tambah Berita</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
