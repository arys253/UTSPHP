<?php
require_once __DIR__ . '/../config/Database.php';

class Buku extends Database {

    public function all() {
        $res = $this->conn->query("SELECT id, judul, penulis, tahun, stok FROM buku ORDER BY id DESC");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id) {
        $st = $this->conn->prepare("SELECT id, judul, penulis, tahun, stok FROM buku WHERE id=?");
        $st->bind_param("i", $id);
        $st->execute();
        return $st->get_result()->fetch_assoc();
    }

    public function create($judul, $penulis, $tahun, $stok) {
        $st = $this->conn->prepare(
            "INSERT INTO buku (judul, penulis, tahun, stok) VALUES (?,?,?,?)"
        );
        $st->bind_param("ssii", $judul, $penulis, $tahun, $stok);
        $ok = $st->execute();
        $st->close();
        return $ok;
    }

    public function update($id, $judul, $penulis, $tahun, $stok) {
        $st = $this->conn->prepare(
            "UPDATE buku SET judul=?, penulis=?, tahun=?, stok=? WHERE id=?"
        );
        $st->bind_param("ssiii", $judul, $penulis, $tahun, $stok, $id);
        $st->execute();
        $n = $st->affected_rows;
        $st->close();
        return $n;
    }

    public function delete($id) {
        $st = $this->conn->prepare("DELETE FROM buku WHERE id=?");
        $st->bind_param("i", $id);
        $st->execute();
        $n = $st->affected_rows;
        $st->close();
        return $n;
    }

    public function cari($kata) {
        $like = "%" . $kata . "%";
        $st = $this->conn->prepare(
            "SELECT id, judul, penulis, tahun, stok FROM buku WHERE judul LIKE ? ORDER BY id DESC"
        );
        $st->bind_param("s", $like);
        $st->execute();
        return $st->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}