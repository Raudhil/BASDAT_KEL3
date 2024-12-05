<?php
session_start();
require '../config/db.php';
$db = connectMongo(); // Menghubungkan ke MongoDB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data input dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mencari admin dengan email yang sesuai
    $admin = $db->admin->findOne(['email' => $email]);

    if ($admin) {
        // Jika admin ditemukan, periksa password
        if ($admin['password'] === $password) {
            // Jika password cocok, simpan data admin di session
            $_SESSION['admin'] = $admin['_id'];
            header('Location: ../admin/indexadmin.php'); // Ganti dengan halaman setelah login
            exit();
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Email tidak ditemukan!';
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Berita Terkini</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Membuat body mengisi penuh layar */
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            flex-grow: 1; /* Membuat form login mengisi ruang yang tersisa */
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .login-container input {
            width: 92.5%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-container button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: auto; /* Footer menempel di bawah */
        }
    </style>
</head>
<body>
    <header>
        <h1>Berita Terkini</h1>
    </header>

    <main>
        <div class="login-container">
            <h2>Login</h2>
            
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Website Berita</p>
    </footer>
</body>
</html>
