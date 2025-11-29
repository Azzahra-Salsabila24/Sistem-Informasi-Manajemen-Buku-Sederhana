-- Hapus database lama jika ada, lalu buat baru
DROP DATABASE IF EXISTS simbs;
CREATE DATABASE simbs;
USE simbs;

-- Tabel users
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel kategori
CREATE TABLE kategori (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    tanggal_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel buku 
CREATE TABLE buku (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit YEAR,
    harga INT(11) NOT NULL,
    foto VARCHAR(255) DEFAULT 'default.jpg',
    id_kategori INT(11),
    tanggal_input TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id) ON DELETE SET NULL
);

-- Insert data untuk kategori 
INSERT INTO kategori (nama_kategori, tanggal_input) VALUES 
('Fiksi', '2024-11-20 08:15:00'),
('Non-Fiksi', '2024-11-21 09:30:00'),
('Teknologi', '2024-11-22 10:45:00'),
('Sejarah', '2024-11-23 11:20:00'),
('Pendidikan', '2024-11-24 13:10:00'),
('Bisnis', '2024-11-25 14:25:00'),
('Kesehatan', '2024-11-26 15:40:00'),
('Agama', '2024-11-27 16:55:00');

-- Insert data untuk buku 
INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, harga, foto, id_kategori, tanggal_input) VALUES 
('The 7 Habits', 'Stephen Covey', 'Binarupa Aksara', 1989, 125000, 'the7habits.jpg', 5, '2024-11-27 16:30:00'),
('Sapiens', 'Yuval Noah Harari', 'Kepustakaan Populer', 2015, 150000, 'sapiens.jpg', 4, '2024-11-26 15:20:00'),
('Python untuk Pemula', 'Budi Raharjo', 'Informatika', 2022, 95000, 'python.jpg', 3, '2024-11-25 14:10:00'),
('Filosofi Teras', 'Henry Manampiring', 'Kompas', 2019, 98000, 'filosofiteras.jpg', 2, '2024-11-24 13:45:00'),
('Rich Dad Poor Dad', 'Robert Kiyosaki', 'Gramedia', 2000, 110000, 'richdadpoordad.jpg', 6, '2024-11-23 12:30:00'),
('Atomic Habits', 'James Clear', 'Gramedia Pustaka', 2019, 105000, 'atomichabits.jpg', 2, '2024-11-22 11:15:00'),
('Sejarah Indonesia', 'Prof. Sartono', 'Gramedia', 2010, 135000, 'sejarahindonesia.jpg', 4, '2024-11-21 10:00:00'),
('Pemrograman Web', 'John Doe', 'Informatika', 2023, 89000, 'pemrogramanweb.jpg', 3, '2024-11-20 09:45:00'),
('Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 120000, 'bumimanusia.jpg', 1, '2024-11-19 08:30:00'),
('Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 88000, 'laskarpelangi.jpg', 1, '2024-11-18 07:15:00');
