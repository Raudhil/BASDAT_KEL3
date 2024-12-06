<?php
require '../config/db.php';
$db = connectMongo();

// Mengambil kata pencarian dari URL (jika ada)
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Menentukan filter pencarian jika ada kata kunci
$filter = [];
if ($searchQuery) {
    $filter = [
        '$or' => [
            ['title' => new MongoDB\BSON\Regex($searchQuery, 'i')],
            ['category' => new MongoDB\BSON\Regex($searchQuery, 'i')],
            ['summary' => new MongoDB\BSON\Regex($searchQuery, 'i')]
        ]
    ];
}

// Mendapatkan daftar berita berdasarkan filter pencarian
$beritas = $db->news->find($filter);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terkini</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1; /* This will allow the main content area to expand and take available space */
        }

        footer {
            margin-top: auto; /* This ensures that the footer stays at the bottom */
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-title a {
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
        }

        .card-title a:hover {
            color: #0056b3;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e1e1e1;
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        .card-text.text-muted {
            font-style: italic;
        }

        .navbar-nav .nav-link {
            font-size: 1.1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container text-center">
            <h1>Berita Terkini</h1>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Website Berita</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Formulir Pencarian -->
    <div class="container my-4">
        <form action="" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Cari berita..." aria-label="Cari berita">
            <button type="submit" class="btn btn-primary ms-2">Cari</button>
        </form>
    </div>

    <main class="container my-4">
        <h2 class="text-center mb-4">Semua Berita</h2>

        <?php if ($searchQuery): ?>
            <h5 class="text-center mb-4">Hasil Pencarian untuk: "<?= htmlspecialchars($searchQuery) ?>"</h5>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($beritas as $berita): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
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
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-dark text-white py-3">
    <div class="container d-flex justify-content-center">
        <p class="mb-0">&copy; 2024 Website Berita</p>
    </div>
</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
