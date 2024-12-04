<?php
require 'db.php';
$db = connectMongo();

// Mengambil ID berita dari URL
$id = $_GET['id'];

// Menemukan berita berdasarkan ID
$berita = $db->news->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

if (!$berita) {
    die("Berita tidak ditemukan!");
}
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
        /* Pastikan body dan html menggunakan flexbox */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* Main content mengisi ruang tersisa */
    main {
        flex-grow: 1;
    }

    /* Footer tetap berada di bawah */
    .footer {
        background-color: #343a40;
        color: #ffffff;
        padding: 10px 0;
        text-align: center;
        margin-top: auto; /* Ini membuat footer tetap di bawah */
    }
        .header-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .author-info {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .content-text {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #333;
            margin-bottom: 30px;
        }

        .content-text p {
            margin-bottom: 1.5rem;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e1e1e1;
        }

        .btn-back {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        .main-container {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 30px;
            background-color: #ffffff;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
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
                <p><?= nl2br(htmlspecialchars($berita->summary)) ?></p>
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
