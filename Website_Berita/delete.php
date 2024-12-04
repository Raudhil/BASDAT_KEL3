<?php
require 'db.php';
$db = connectMongo();

if (isset($_GET['id'])) {
    $id = new MongoDB\BSON\ObjectId($_GET['id']);
    $db->berita->deleteOne(['_id' => $id]);
    header("Location: view.php");
    exit;
}
?>