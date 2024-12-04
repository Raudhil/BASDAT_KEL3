<?php
require 'db.php';
$db = connectMongo();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    try {
        // Validasi dan konversi ID menjadi ObjectId
        $id = new MongoDB\BSON\ObjectId($_GET['id']);
    } catch (Exception $e) {
        // Jika ID tidak valid
        echo "ID tidak valid.";
        exit;
    }

    // Hapus dokumen berdasarkan ID
    $result = $db->news->deleteOne(['_id' => $id]);

    if ($result->getDeletedCount() > 0) {
        // Redirect jika penghapusan berhasil
        header("Location: index.php");
        exit;
    } else {
        // Jika ID tidak ditemukan
        echo "Dokumen tidak ditemukan.";
        exit;
    }
} else {
    // Jika parameter ID tidak ada
    echo "ID tidak ditemukan.";
    exit;
}
?>