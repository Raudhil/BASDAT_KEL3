<?php
require '../config/db.php';
$db = connectMongo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data input
    $title = trim($_POST['title']);
    $summary = trim($_POST['summary']);
    $category = trim($_POST['category']);
    $author = trim($_POST['author']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($summary) || empty($category) || empty($author || empty($content))) {
        echo "Semua kolom wajib diisi.";
    } else {
        // Masukkan data ke MongoDB
        $db->news->insertOne([
            'title' => $title,
            'summary' => $summary,
            'category' => $category,
            'author' => $author,
            'content' => $_POST['content'],
            'created_at' => new MongoDB\BSON\UTCDateTime(),
            'updated_at' => new MongoDB\BSON\UTCDateTime(),
        ]);

        // Redirect ke index.php setelah berhasil
        header('Location: indexadmin.php');
        exit;
    }

    header('Location: indexadmin.php'); // Redirect to the news list after insertion
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
                <label for="summary" class="form-label">Konten</label>
                <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="summary" class="form-label">Ringkasan:</label>
                <textarea class="form-control" id="summary" name="summary" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Kategori:</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Olahraga">Olahraga</option>
                    <option value="Politik">Politik</option>
                    <option value="Teknologi">Teknologi</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Ekonomi">Ekonomi</option>
                </select>
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
