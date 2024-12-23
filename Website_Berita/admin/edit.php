<?php
require '../config/db.php';
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
        $content = trim($_POST['content']);

        if (empty($title) || empty($summary) || empty($category) || empty($author) || empty($content)) {
            echo "Semua kolom wajib diisi.";
        } else {
            // Update data berita
            $db->news->updateOne(
                ['_id' => $id],
                ['$set' => [
                    'title' => $title,
                    'content' => $content,
                    'summary' => $summary,
                    'category' => $category,
                    'author' => $author,
                ]]
            );
            header('Location: indexadmin.php'); // Redirect setelah sukses
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-4">Edit Berita</h1>

                <form method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($berita->title) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Ringkasan</label>
                        <textarea class="form-control" id="summary" name="summary" rows="4" required><?= htmlspecialchars($berita->summary) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required><?= htmlspecialchars($berita->content) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Olahraga" <?= $berita->category === 'Olahraga' ? 'selected' : '' ?>>Olahraga</option>
                            <option value="Politik" <?= $berita->category === 'Politik' ? 'selected' : '' ?>>Politik</option>
                            <option value="Teknologi" <?= $berita->category === 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
                            <option value="Kesehatan" <?= $berita->category === 'Kesehatan' ? 'selected' : '' ?>>Kesehatan</option>
                            <option value="Ekonomi" <?= $berita->category === 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?= htmlspecialchars($berita->author) ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="indexadmin.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
