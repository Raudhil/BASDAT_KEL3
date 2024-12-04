<?php
require '../vendor/autoload.php';
function connectMongo() {

    try {
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $db = $client->selectDatabase("news_website");

        return $db;

    } catch (Exception $e) {
        // Handle errors if connection fails
        die("Error connecting to MongoDB: " . $e->getMessage());
    }
}
?>
