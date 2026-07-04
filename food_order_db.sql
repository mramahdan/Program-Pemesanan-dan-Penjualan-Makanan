-- ============================
-- DATABASE
-- ============================
CREATE DATABASE IF NOT EXISTS food_order_db;
USE food_order_db;

-- ============================
-- 1. USERS
-- ============================
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telepon VARCHAR(20),
    alamat TEXT,
    role ENUM('admin','pelanggan') DEFAULT 'pelanggan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- 2. PRODUK
-- ============================
CREATE TABLE produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    kategori ENUM('makanan','minuman') NOT NULL,
    harga INT NOT NULL,
    stok INT DEFAULT 0,
    gambar VARCHAR(255),
    deskripsi TEXT,
    status ENUM('tersedia','habis') DEFAULT 'tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- 3. KERANJANG
-- ============================
CREATE TABLE keranjang (
    id_keranjang INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_produk INT,
    jumlah INT NOT NULL,
    subtotal INT,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk) ON DELETE CASCADE
);

-- ============================
-- 4. PESANAN
-- ============================
CREATE TABLE pesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total INT,
    ongkir INT DEFAULT 0,
    status ENUM(
        'diproses',
        'dibayar',
        'menunggu_verifikasi',
        'diproses_kitchen',
        'selesai',
        'dibatalkan'
    ) DEFAULT 'diproses',
    metode_bayar VARCHAR(50),
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

-- ============================
-- 5. DETAIL PESANAN
-- ============================
CREATE TABLE detail_pesanan (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT,
    id_produk INT,
    jumlah INT,
    harga INT,
    subtotal INT,
    variasi VARCHAR(100),
    nama_produk VARCHAR(255)
);

-- ============================
-- 6. PEMBAYARAN
-- ============================
CREATE TABLE pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT,
    id_user INT,
    bank VARCHAR(50),
    no_rekening VARCHAR(50),
    nama_pengirim VARCHAR(100),
    status ENUM('menunggu_verifikasi','dibayar','ditolak') DEFAULT 'menunggu_verifikasi',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================
-- DATA AWAL USERS
-- ============================
INSERT INTO users (nama, email, password, role)
VALUES ('Admin', 'admin@gmail.com', '12345', 'admin');

-- ============================
-- DATA PRODUK (FIXED SQL)
-- ============================
INSERT INTO produk (nama_produk, kategori, harga, stok) VALUES
('Bakso Bakar', 'makanan', 10000, 10),
('Mie Level Pentol', 'makanan', 15000, 15),
('Mie Level Biasa', 'makanan', 10000, 10),
('Pop Ice', 'minuman', 5000, 20),
('Nutrisari', 'minuman', 5000, 25),
('Jus Alpukat', 'minuman', 10000, 12),
('Es Coklat Boba', 'minuman', 10000, 18),
('Soto', 'makanan', 10000, 12),
('Es Campur', 'minuman', 12000, 10),
('Bakwan Goreng', 'makanan', 8000, 30),
('Es Kopi Susu', 'minuman', 10000, 20),
('Tahu Bakso', 'makanan', 8000, 25),
('Tempe Goreng', 'makanan', 8000, 25),
('Es Kelapa', 'minuman', 9000, 15),
('Jus Mangga', 'minuman', 8000, 15),
('Air Mineral', 'minuman', 5000, 50),
('Air Aqua', 'minuman', 5000, 50),
('Nasi Goreng', 'makanan', 15000, 20),
('Seblak Pedas Komplit', 'makanan', 15000, 18),
('Nasi Ayam Goreng', 'makanan', 15000, 20);