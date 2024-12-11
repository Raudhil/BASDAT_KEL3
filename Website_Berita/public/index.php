<?php
require '../config/db.php';
$db = connectMongo();

// Mengambil kata pencarian dan kategori dari URL (jika ada)
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

// Menentukan filter pencarian jika ada kata kunci atau kategori
$filter = [];
if ($searchQuery) {
    $filter['$or'] = [
        ['title' => new MongoDB\BSON\Regex($searchQuery, 'i')],
        ['category' => new MongoDB\BSON\Regex($searchQuery, 'i')],
        ['summary' => new MongoDB\BSON\Regex($searchQuery, 'i')],
    ];
}
if ($selectedCategory) {
    $filter['category'] = $selectedCategory;
}

// Mendapatkan daftar berita berdasarkan filter pencarian
$beritas = $db->news->find($filter);
$articles = $db->news->find();

// Mendapatkan daftar kategori (dummy data)
$categories = ['Politik', 'Olahraga', 'Teknologi', 'Hiburan', 'Bisnis','Kesehatan','Ekonomi'];
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeritaNet</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        footer {
            margin-top: auto;
        }

        .card {
            margin-bottom: 1rem;
            border: 1px solid #e1e1e1;
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-box {
            margin-bottom: 1rem;
        }

        .category-list {
            list-style: none;
            padding: 0;
        }

        .category-list li {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
            border: 1px solid #e1e1e1;
        }

        .category-list li svg {
            margin-right: 0.5rem;
        }

        .notification {
            margin-top: 1rem;
            background-color: #e9ecef;
            padding: 0.75rem;
            border-radius: 0.5rem;
            text-align: center;
        }

        .box-container {
            display: flex;
            gap: 1rem;
        }

        .news-box {
            flex: 3;
        }

        .category-box {
            flex: 1;
        }

        .logo {
            height: 40px;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex align-items-center">
            <img src="../../img/logo.png" alt="Logo" class="me-3 logo">
            <h1 class="m-0">BeritaNet</h1>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form action="" method="GET" class="d-flex ms-auto">
                    <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Cari berita..." aria-label="Cari berita">
                    <button type="submit" class="btn btn-warning ms-2">Cari</button>
                </form>
                <ul class="navbar-nav ms-3">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <?php if ($searchQuery): ?>
            <div class="notification">
                Hasil pencarian untuk: "<?= htmlspecialchars($searchQuery) ?>"
            </div>
        <?php endif; ?>
        <?php if ($selectedCategory): ?>
            <div class="notification">
                Menampilkan berita dengan kategori: "<?= htmlspecialchars($selectedCategory) ?>"
            </div>
        <?php endif; ?>


        <div class="box-container mt-3">
            <div class="news-box">
                <h2 class="text-center mb-4">Semua Berita</h2>

                <div class="row">
                    <?php foreach ($beritas as $berita): ?>
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card-body d-flex align-items-center">
                                    <!-- Gambar di sebelah kiri -->
                                    <?php if (!empty($berita->image)): ?>
                                        <img src="data:image/jpeg;base64,<?= $berita->image ?>" alt="Gambar Berita" class="img-fluid me-3" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
                                    <?php else: ?>
                                        <img src="default-image.jpg" alt="Gambar Default" class="img-fluid me-3" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px;">
                                    <?php endif; ?>

                                    <!-- Konten teks -->
                                    <div>
                                        <h5 class="card-title">
                                            <a href="view.php?id=<?= $berita->_id ?>" class="text-decoration-none">
                                                <?= htmlspecialchars($berita->title) ?>
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted">Kategori: <?= htmlspecialchars($berita->category) ?> | Penulis: <?= htmlspecialchars($berita->author) ?></p>
                                        <p class="card-text"><?= htmlspecialchars($berita->summary) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

            <div class="category-box mt-3">
                <h4 class="mb-3">Kategori</h4>
                <ul class="category-list">
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="?category=<?= urlencode($category) ?>" class="text-decoration-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                                    <path d="M9.828 4a.5.5 0 0 1 .354.146l2.828 2.828A.5.5 0 0 1 13 7.828V11.5a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-8A.5.5 0 0 1 1.5 3h5a.5.5 0 0 1 .354.146l1.328 1.328A.5.5 0 0 1 8.828 4H9.5h.328z" />
                                    <path d="M4.5 3a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-8A.5.5 0 0 1 1.5 3h3z" />
                                </svg>
                                <?= htmlspecialchars($category) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-center">
            <p class="mb-0">&copy; 2024 BeritaNet</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>