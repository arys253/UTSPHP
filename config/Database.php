<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";           
    private $db   = "perpustakaan_db";

    protected $conn;

    public function __construct() {
        $this->connect();
    }

    protected function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }
}