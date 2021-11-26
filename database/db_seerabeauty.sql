-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jun 2021 pada 07.29
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_seerabeauty`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `id_merek` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `id_merek`) VALUES
('B000001', 'Dark Spot', 26),
('B000002', 'PHTE', 18),
('B000003', 'Liptin', 19),
('B000004', 'else', 17),
('B000005', 'AMP', 18),
('B000006', 'Refining', 18),
('B000007', 'Inthedark', 21),
('B000008', 'whitening', 21),
('B000009', 'Mugwert', 26),
('B000010', 'Eye Cream', 18),
('B000011', 'Nsa', 21),
('B000012', 'Hyalu Rosic', 21),
('B000013', 'Retinol', 21),
('B000014', 'Winter', 24);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` varchar(16) CHARACTER SET utf8 NOT NULL,
  `id_user` int(5) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `nama_pelanggan` varchar(30) NOT NULL,
  `umur` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `id_user`, `tanggal_keluar`, `nama_pelanggan`, `umur`) VALUES
('TBK-000001', 17, '2020-02-01', 'rani', 20),
('TBK-000002', 17, '2020-02-01', 'dani', 23),
('TBK-000003', 17, '2020-02-01', 'wawan', 12),
('TBK-000004', 17, '2020-02-01', 'wanto', 23),
('TBK-000005', 17, '2020-02-01', 'bonang', 23),
('TBK-000006', 17, '2020-02-01', 'rendi', 25),
('TBK-000007', 17, '2020-02-01', 'warno', 24),
('TBK-000008', 17, '2020-02-01', 'grady', 26),
('TBK-000009', 17, '2020-02-01', 'rezka', 36),
('TBK-000010', 17, '2020-02-01', 'yahya', 27),
('TBK-000011', 17, '2020-02-01', 'giono', 36),
('TBK-000012', 17, '2020-02-01', 'wawan', 35),
('TBK-000013', 17, '2020-02-01', 'gionorp', 35),
('TBK-000014', 17, '2020-02-01', 'rangga', 14),
('TBK-000015', 17, '2020-02-01', 'faesal', 15),
('TBK-000016', 17, '2020-02-01', 'amaldie', 24),
('TBK-000017', 17, '2020-02-01', 'adli', 15),
('TBK-000018', 17, '2020-02-01', 'lilis', 29),
('TBK-000019', 17, '2020-02-01', 'pendi', 15),
('TBK-000020', 17, '2020-02-01', 'faisol', 24),
('TBK-000021', 17, '2020-02-01', 'bowo', 24),
('TBK-000022', 17, '2020-03-01', 'sari', 24),
('TBK-000023', 17, '2020-03-01', 'sari', 24),
('TBK-000024', 17, '2020-05-01', 'rangga', 25),
('TBK-000025', 17, '2020-06-01', 'daniel', 24),
('TBK-000026', 17, '2020-07-01', 'fae', 36),
('TBK-000027', 17, '2020-08-01', 'dendi', 25),
('TBK-000028', 17, '2020-03-01', 'lisa', 25),
('TBK-000029', 17, '2020-04-01', 'cindy', 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` char(16) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `id_supplier`, `id_user`, `tanggal_masuk`) VALUES
('TBM-000001', 6, 17, '2020-01-01'),
('TBM-000002', 7, 17, '2020-01-01'),
('TBM-000003', 7, 17, '2020-01-01'),
('TBM-000004', 6, 17, '2020-01-01'),
('TBM-000005', 6, 17, '2020-01-01'),
('TBM-000006', 7, 17, '2020-01-01'),
('TBM-000007', 7, 17, '2020-01-01'),
('TBM-000008', 7, 17, '2020-01-01'),
('TBM-000009', 7, 17, '2020-01-01'),
('TBM-000010', 6, 17, '2020-01-01'),
('TBM-000011', 6, 17, '2020-01-01'),
('TBM-000012', 6, 17, '2020-02-01'),
('TBM-000013', 6, 17, '2020-01-01'),
('TBM-000014', 6, 17, '2020-01-01'),
('TBM-000015', 7, 17, '2020-01-01'),
('TBM-000016', 7, 17, '2020-01-01'),
('TBM-000017', 6, 17, '2020-01-01'),
('TBM-000018', 7, 17, '2020-01-01'),
('TBM-000019', 6, 17, '2020-11-01'),
('TBM-000020', 6, 17, '2020-02-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_barang`
--

CREATE TABLE `detail_barang` (
  `id_detail_barang` int(5) NOT NULL,
  `id_barang` char(7) CHARACTER SET utf8 NOT NULL,
  `stok` int(11) NOT NULL,
  `id_variasi_ukuran` int(11) NOT NULL,
  `harga_jual` double NOT NULL,
  `harga_beli` double NOT NULL,
  `biaya_simpan` double NOT NULL,
  `biaya_pesan` double NOT NULL,
  `lead_time` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_barang`
--

INSERT INTO `detail_barang` (`id_detail_barang`, `id_barang`, `stok`, `id_variasi_ukuran`, `harga_jual`, `harga_beli`, `biaya_simpan`, `biaya_pesan`, `lead_time`) VALUES
(1, 'B000001', 19, 25, 200000, 560000, 2, 30000, 1),
(2, 'B000002', 55, 25, 140000, 0, 1, 10000, 1),
(3, 'B000002', 39, 19, 180000, 240000, 1, 23000, 2),
(4, 'B000003', 39, 20, 189000, 0, 1, 10000, 2),
(5, 'B000004', 20, 25, 140000, 0, 1, 23000, 2),
(6, 'B000005', 30, 25, 135000, 0, 1, 9000, 2),
(7, 'B000006', 20, 18, 129000, 0, 1, 9000, 1),
(8, 'B000006', 39, 17, 240000, 0, 1, 10000, 2),
(9, 'B000007', 30, 26, 180000, 0, 1, 20000, 2),
(10, 'B000008', 24, 25, 230000, 0, 1, 10000, 2),
(11, 'B000009', 0, 25, 250000, 0, 1, 29000, 2),
(12, 'B000010', 0, 25, 245000, 0, 1, 32000, 2),
(13, 'B000011', 80, 25, 170000, 340000, 1, 30000, 2),
(14, 'B000012', 5, 25, 125000, 0, 1, 20000, 1),
(15, 'B000013', 0, 25, 240000, 0, 1, 13000, 4),
(16, 'B000014', 0, 25, 130000, 0, 2, 10000, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_keluar`
--

CREATE TABLE `detail_keluar` (
  `id_barang_keluar` char(16) CHARACTER SET utf8 NOT NULL,
  `id_detail_barang` int(5) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_keluar`
--

INSERT INTO `detail_keluar` (`id_barang_keluar`, `id_detail_barang`, `jumlah`, `harga`) VALUES
('TBK-000001', 3, 20, 180000),
('TBK-000002', 1, 3, 199000),
('TBK-000003', 1, 5, 199000),
('TBK-000004', 1, 5, 199000),
('TBK-000005', 1, 8, 199000),
('TBK-000006', 1, 1, 199000),
('TBK-000007', 3, 5, 180000),
('TBK-000008', 1, 7, 199000),
('TBK-000009', 1, 10, 200000),
('TBK-000010', 13, 40, 170000),
('TBK-000011', 13, 5, 170000),
('TBK-000012', 1, 4, 200000),
('TBK-000012', 3, 6, 180000),
('TBK-000012', 7, 9, 129000),
('TBK-000013', 13, 1, 170000),
('TBK-000014', 1, 1, 200000),
('TBK-000015', 1, 1, 200000),
('TBK-000016', 1, 2, 200000),
('TBK-000017', 1, 1, 200000),
('TBK-000018', 1, 2, 200000),
('TBK-000019', 1, 2, 200000),
('TBK-000020', 1, 1, 200000),
('TBK-000021', 1, 1, 200000),
('TBK-000022', 1, 1, 200000),
('TBK-000023', 1, 1, 200000),
('TBK-000024', 1, 1, 200000),
('TBK-000025', 1, 1, 200000),
('TBK-000026', 1, 1, 200000),
('TBK-000027', 3, 1, 180000),
('TBK-000028', 2, 9, 140000),
('TBK-000029', 2, 5, 140000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_masuk`
--

CREATE TABLE `detail_masuk` (
  `id_detail_masuk` int(5) NOT NULL,
  `id_barang_masuk` char(16) CHARACTER SET utf8 NOT NULL,
  `id_detail_barang` int(5) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_beli` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_masuk`
--

INSERT INTO `detail_masuk` (`id_detail_masuk`, `id_barang_masuk`, `id_detail_barang`, `jumlah`, `harga_beli`) VALUES
(1, 'TBM-000001', 1, 23, 199000),
(2, 'TBM-000002', 2, 23, 180000),
(3, 'TBM-000003', 3, 25, 185000),
(4, 'TBM-000004', 4, 20, 189000),
(5, 'TBM-000005', 5, 20, 145000),
(6, 'TBM-000006', 4, 19, 230000),
(7, 'TBM-000007', 6, 30, 210000),
(8, 'TBM-000008', 7, 29, 230000),
(9, 'TBM-000009', 8, 39, 210000),
(10, 'TBM-000010', 9, 30, 125000),
(11, 'TBM-000011', 10, 24, 195000),
(12, 'TBM-000012', 1, 16, 240000),
(16, 'TBM-000013', 14, 5, 250000),
(17, 'TBM-000014', 13, 5, 250000),
(18, 'TBM-000015', 2, 46, 270000),
(19, 'TBM-000016', 3, 46, 200000),
(20, 'TBM-000017', 1, 24, 270000),
(23, 'TBM-000019', 13, 80, 140000),
(24, 'TBM-000020', 1, 15, 230000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_verifikasi`
--

CREATE TABLE `detail_verifikasi` (
  `id_verifikasiorder` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_detail_barang` int(5) NOT NULL,
  `cek` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_verifikasi`
--

INSERT INTO `detail_verifikasi` (`id_verifikasiorder`, `id_detail_barang`, `cek`) VALUES
('202106161', 1, 1),
('202106162', 3, 2),
('202106163', 1, 3),
('202106163', 13, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(5) NOT NULL,
  `id_detail_barang` int(5) NOT NULL,
  `id_session` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `jumlah` int(5) NOT NULL,
  `tgl` date NOT NULL,
  `jam` time NOT NULL,
  `stok_temp` int(5) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `merek`
--

CREATE TABLE `merek` (
  `id_merek` int(11) NOT NULL,
  `nama_merek` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `merek`
--

INSERT INTO `merek` (`id_merek`, `nama_merek`) VALUES
(17, 'Else'),
(18, 'Avoskin'),
(19, 'Syca'),
(20, 'Somethinc'),
(21, 'Glowsat'),
(22, 'glowsat'),
(24, 'Low'),
(25, 'Refind'),
(26, 'Anisy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `safety_stock`
--

CREATE TABLE `safety_stock` (
  `id_detail_barang` int(5) NOT NULL,
  `terjual` int(11) NOT NULL,
  `max` int(11) DEFAULT NULL,
  `rerata` float DEFAULT NULL,
  `leadtime` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `safety_stock` int(11) DEFAULT NULL,
  `rop` int(11) NOT NULL,
  `eoq` double NOT NULL,
  `status` varchar(10) NOT NULL,
  `kode` int(5) NOT NULL,
  `verifikasi` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `safety_stock`
--

INSERT INTO `safety_stock` (`id_detail_barang`, `terjual`, `max`, `rerata`, `leadtime`, `stock`, `safety_stock`, `rop`, `eoq`, `status`, `kode`, `verifikasi`) VALUES
(1, 59, 54, 4.91667, 1, 19, 49, 49, 29.748949561287, 'Safe', 0, 0),
(2, 14, 9, 1.16667, 1, 55, 8, 8, 14.142135623731, 'Safe', 0, 0),
(3, 32, 31, 2.66667, 2, 39, 57, 57, 28.59681411937, 'Safe', 0, 0),
(4, 0, 0, 0, 2, 39, 0, 0, 0, 'Safe', 0, 0),
(5, 0, 0, 0, 2, 20, 0, 0, 0, 'Safe', 0, 0),
(6, 0, 0, 0, 2, 30, 0, 0, 0, 'Safe', 0, 0),
(7, 9, 9, 0.75, 1, 20, 8, 8, 11.206310514564, 'Safe', 0, 0),
(8, 0, 0, 0, 2, 39, 0, 0, 0, 'Safe', 0, 0),
(9, 0, 0, 0, 2, 30, 0, 0, 0, 'Safe', 0, 0),
(10, 0, 0, 0, 2, 24, 0, 0, 0, 'Safe', 0, 0),
(13, 46, 46, 3.83333, 2, 80, 84, 85, 40.293044210691, 'Safe', 0, 0),
(14, 0, 0, 0, 1, 5, 0, 0, 0, 'Safe', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `no_telp`, `alamat`) VALUES
(6, 'PT.Indo Raya', '02134555', 'Jl.Jendara sudirman No.3 Jakarta Selatan'),
(7, 'Avoskin', '0890001827', 'jl.imogiri bantul');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `role` enum('manager','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `email`, `no_telp`, `role`, `password`, `is_active`) VALUES
(15, 'Admin', 'admin', 'admin@gmail.com', '0856766455', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(17, 'manager', 'manager', 'manager@gmail.com', '08576543241', 'manager', '1d0258c2440a8d19e716292b231e3190', 1),
(22, 'adityafauzan', 'adit', 'adit@gmail.com', '081324551234', 'manager', '357344787fa3d91429f000604af9667f', 1),
(23, 'dimas', 'dimas', 'dimasfaesalamaldie@yahoo.com', '082324515388', 'admin', '7d49e40f4b3d8f68c19406a58303f826', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `variasi_ukuran`
--

CREATE TABLE `variasi_ukuran` (
  `id_variasi_ukuran` int(11) NOT NULL,
  `nama_variasi_ukuran` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `variasi_ukuran`
--

INSERT INTO `variasi_ukuran` (`id_variasi_ukuran`, `nama_variasi_ukuran`) VALUES
(17, 'toner'),
(18, 'serum'),
(19, '30'),
(20, '01'),
(21, '02'),
(22, '03'),
(23, '40ml'),
(24, '20ml'),
(25, '-'),
(26, ' '),
(27, '24K');

-- --------------------------------------------------------

--
-- Struktur dari tabel `verifikasiorder`
--

CREATE TABLE `verifikasiorder` (
  `id_verifikasiorder` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_user` int(5) NOT NULL,
  `tanggal` date NOT NULL,
  `cetak` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `verifikasiorder`
--

INSERT INTO `verifikasiorder` (`id_verifikasiorder`, `id_user`, `tanggal`, `cetak`) VALUES
('202106161', 17, '2021-06-16', 1),
('202106162', 17, '2021-06-17', 1),
('202106163', 17, '2021-06-19', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`);

--
-- Indeks untuk tabel `detail_barang`
--
ALTER TABLE `detail_barang`
  ADD PRIMARY KEY (`id_detail_barang`);

--
-- Indeks untuk tabel `detail_masuk`
--
ALTER TABLE `detail_masuk`
  ADD PRIMARY KEY (`id_detail_masuk`);

--
-- Indeks untuk tabel `detail_verifikasi`
--
ALTER TABLE `detail_verifikasi`
  ADD PRIMARY KEY (`cek`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`);

--
-- Indeks untuk tabel `merek`
--
ALTER TABLE `merek`
  ADD PRIMARY KEY (`id_merek`);

--
-- Indeks untuk tabel `safety_stock`
--
ALTER TABLE `safety_stock`
  ADD PRIMARY KEY (`id_detail_barang`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `variasi_ukuran`
--
ALTER TABLE `variasi_ukuran`
  ADD PRIMARY KEY (`id_variasi_ukuran`);

--
-- Indeks untuk tabel `verifikasiorder`
--
ALTER TABLE `verifikasiorder`
  ADD PRIMARY KEY (`id_verifikasiorder`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_barang`
--
ALTER TABLE `detail_barang`
  MODIFY `id_detail_barang` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `detail_masuk`
--
ALTER TABLE `detail_masuk`
  MODIFY `id_detail_masuk` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `detail_verifikasi`
--
ALTER TABLE `detail_verifikasi`
  MODIFY `cek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `merek`
--
ALTER TABLE `merek`
  MODIFY `id_merek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `variasi_ukuran`
--
ALTER TABLE `variasi_ukuran`
  MODIFY `id_variasi_ukuran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
