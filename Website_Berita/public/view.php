<?php 
require '../config/db.php';
$db = connectMongo();

// Mengambil ID berita dari URL
$id = $_GET['id'];

// Menemukan berita berdasarkan ID
$berita = $db->news->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if (!$berita) {
    die("Berita tidak ditemukan!");
}

// Menangani pengiriman komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['author'], $_POST['comment'])) {
    $author = htmlspecialchars($_POST['author']);
    $comment = htmlspecialchars($_POST['comment']);

    $db->comments->insertOne([
        'news_id' => new MongoDB\BSON\ObjectId($id),
        'author' => $author,
        'comment' => $comment,
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);

    header("Location: view.php?id=" . $id);
    exit;
}

// Menangani penghapusan komentar
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_comment_id'])) {
    $deleteCommentId = $_GET['delete_comment_id'];

    $db->comments->deleteOne(['_id' => new MongoDB\BSON\ObjectId($deleteCommentId)]);

    header("Location: view.php?id=" . $id);
    exit;
}


// Mendapatkan komentar terkait berita
$comments = $db->comments->find(['news_id' => new MongoDB\BSON\ObjectId($id)]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styles seperti sebelumnya */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex-grow: 1;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
            margin-top: auto;
        }

        .comment-form {
            margin-top: 30px;
        }

        .comment-section {
            margin-top: 20px;
            padding: 20px;
            border-top: 1px solid #ddd;
        }

        .comment-item {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container text-center">
            <h1>Website Berita</h1>
        </div>
    </header>

    <main class="container my-4">
        <div class="main-container">
            <h2 class="header-title"><?= htmlspecialchars($berita->title) ?></h2>
            <p class="author-info">Kategori: <?= htmlspecialchars($berita->category) ?> | Penulis: <?= htmlspecialchars($berita->author) ?> | <?= date('d F Y', strtotime($berita->created_at)) ?></p>
            <div class="content-text">
                <p><?= nl2br(htmlspecialchars($berita->content)) ?></p>
            </div>

            <!-- Form untuk komentar -->
            <div class="comment-form">
                <h3>Tambah Komentar</h3>
                <form method="post">
                    <div class="mb-3">
                        <label for="author" class="form-label">Nama Anda</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>

            <!-- Menampilkan komentar -->
            <div class="comment-section">
                <h3>Komentar</h3>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <strong><?= htmlspecialchars($comment['author']) ?></strong> 
                        <small class="text-muted">(<?= date('d F Y H:i', $comment['created_at']->toDateTime()->getTimestamp()) ?>)</small>
                        <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                        <!-- Tombol untuk menghapus komentar -->
                        <a href="view.php?id=<?= $id ?>&delete_comment_id=<?= $comment['_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">Hapus</a>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="index.php" class="btn btn-back">Kembali ke Berita</a>
        </div>
    </main>

    <footer class="footer">
        <div>
            <p class="mb-0">&copy; 2024 Website Berita</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
