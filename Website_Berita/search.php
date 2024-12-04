<?php
require 'db.php';

class Search {
    private $db;
    private $searchQuery;
    private $results;

    public function __construct($db) {
        $this->db = $db;
        $this->searchQuery = '';
        $this->results = [];
    }

    // Menetapkan nilai pencarian
    public function setSearchQuery($search) {
        $this->searchQuery = $search;
    }

    // Mendapatkan nilai pencarian
    public function getSearchQuery() {
        return $this->searchQuery;
    }

    // Melakukan pencarian di database
    public function searchNews() {
        if ($this->searchQuery) {
            // Cari berita yang sesuai dengan pencarian
            $this->results = $this->db->news->find([
                '$or' => [
                    ['title' => new MongoDB\BSON\Regex($this->searchQuery, 'i')],
                    ['category' => new MongoDB\BSON\Regex($this->searchQuery, 'i')],
                    ['summary' => new MongoDB\BSON\Regex($this->searchQuery, 'i')]
                ]
            ]);
        } else {
            // Jika tidak ada pencarian, ambil semua berita
            $this->results = $this->db->news->find();
        }
    }

    // Mendapatkan hasil pencarian
    public function getResults() {
        return $this->results;
    }
}
?>
