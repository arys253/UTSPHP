CREATE DATABASE IF NOT EXISTS perpustakaan_db CHARACTER SET utf8mb4;
USE perpustakaan_db;

CREATE TABLE IF NOT EXISTS buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150) NOT NULL,
  penulis VARCHAR(100) NOT NULL,
  tahun INT NOT NULL,
  stok INT NOT NULL DEFAULT 0
);

INSERT INTO buku (judul, penulis, tahun, stok) VALUES
('Belajar PHP Dasar', 'Andi Pratama', 2021, 5),
('Pemrograman Web dengan MySQL', 'Budi Santoso', 2022, 3),
('Algoritma dan Struktur Data', 'Citra Dewi', 2019, 7);