-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 22, 2025 lúc 04:41 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30
CREATE DATABASE IF NOT EXISTS `warehouse_db1`;
USE `warehouse_db1`;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `warehouse_db1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaChiTiet` int(11) NOT NULL,
  `MaDon` varchar(50) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` > 0),
  `DonGia` decimal(18,4) NOT NULL CHECK (`DonGia` >= 0),
  `ThanhTien` decimal(18,4) GENERATED ALWAYS AS (`SoLuong` * `DonGia`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaChiTiet`, `MaDon`, `MaSP`, `SoLuong`, `DonGia`) VALUES
(1, 'D001', 1, 2, 150000.0000),
(2, 'D002', 2, 1, 300000.0000),
(3, 'D003', 3, 1, 700000.0000),
(4, 'D004', 4, 3, 350000.0000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietnhap`
--

CREATE TABLE `chitietnhap` (
  `MaPN` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuongNhap` int(11) NOT NULL,
  `GiaNhap` float NOT NULL,
  `ThanhTien` float GENERATED ALWAYS AS (`SoLuongNhap` * `GiaNhap`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietnhap`
--

INSERT INTO `chitietnhap` (`MaPN`, `MaSP`, `SoLuongNhap`, `GiaNhap`) VALUES
(1, 1, 10, 100000),
(1, 2, 15, 200000),
(2, 3, 20, 500000),
(3, 4, 25, 250000),
(4, 1, 5, 100000),
(4, 2, 10, 200000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietxuat`
--

CREATE TABLE `chitietxuat` (
  `MaPX` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `DonGiax` decimal(18,4) NOT NULL CHECK (`DonGiax` >= 0),
  `SoLuongXuat` int(11) NOT NULL,
  `ThanhTien` decimal(18,4) GENERATED ALWAYS AS (`SoLuongXuat` * `DonGiax`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietxuat`
--

INSERT INTO `chitietxuat` (`MaPX`, `MaSP`, `DonGiax`, `SoLuongXuat`) VALUES
(1, 1, 150000.0000, 5),
(2, 2, 300000.0000, 3),
(3, 3, 700000.0000, 2),
(4, 4, 350000.0000, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDon` varchar(50) NOT NULL,
  `MaPX` int(11) NOT NULL,
  `MaKH` varchar(8) NOT NULL,
  `NgayDat` datetime NOT NULL DEFAULT current_timestamp(),
  `TrangThai` enum('pending','canceled','confirmed') DEFAULT 'pending',
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDon`, `MaPX`, `MaKH`, `NgayDat`, `TrangThai`, `GhiChu`) VALUES
('D001', 1, 'KH001', '2025-03-14 00:00:00', 'pending', NULL),
('D002', 2, 'KH002', '2025-03-15 00:00:00', 'pending', NULL),
('D003', 3, 'KH003', '2025-03-16 00:00:00', 'pending', NULL),
('D004', 4, 'KH004', '2025-03-17 00:00:00', 'confirmed', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHoaDon` int(11) NOT NULL,
  `LoaiPhieu` varchar(10) NOT NULL,
  `NgayThucHien` date DEFAULT NULL,
  `MaNV` int(11) NOT NULL,
  `TrangThai` enum('accept','waiting','deny') NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`MaHoaDon`, `LoaiPhieu`, `NgayThucHien`, `MaNV`, `TrangThai`) VALUES
(1, 'Nhập', '2025-03-05', 4, 'accept'),
(2, 'Nhập', '2025-03-06', 3, 'waiting'),
(3, 'Nhập', '2025-03-07', 4, 'deny'),
(4, 'Nhập', '2025-03-08', 3, 'accept'),
(15, 'Xuất', '2025-03-10', 2, 'waiting'),
(16, 'Xuất', '2025-03-11', 3, 'waiting'),
(17, 'Xuất', '2025-03-12', 4, 'waiting'),
(18, 'Xuất', '2025-03-13', 3, 'accept');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` varchar(8) NOT NULL,
  `TenKH` varchar(255) NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `SoDienThoai` varchar(20) NOT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `DiaChi`, `SoDienThoai`, `Email`) VALUES
('KH001', 'Nguyễn Văn X', 'Hà Nội', '0901122334', 'x@gmail.com'),
('KH002', 'Trần Thị Y', 'Hải Phòng', '0902233445', 'y@gmail.com'),
('KH003', 'Lê Văn Z', 'Đà Nẵng', '0913344556', 'z@gmail.com'),
('KH004', 'Hoàng Anh K', 'TP HCM', '0924455667', 'k@gmail.com'),
('KH005', 'Nguyễn Hùng M', 'Cần Thơ', '0935566778', 'm@gmail.com'),
('KH006', 'Nguyễn Văn X', 'Hà Nội', '0901122334', 'x@gmail.com'),
('KH007', 'Trần Thị Y', 'Hải Phòng', '0902233445', 'y@gmail.com'),
('KH008', 'Lê Văn Z', 'Đà Nẵng', '0913344556', 'z@gmail.com'),
('KH009', 'Hoàng Anh K', 'TP HCM', '0924455667', 'k@gmail.com'),
('KH010', 'Nguyễn Hùng M', 'Cần Thơ', '0935566778', 'm@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ncc`
--

CREATE TABLE `ncc` (
  `MaNCC` int(11) NOT NULL,
  `TenNCC` varchar(255) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ncc`
--

INSERT INTO `ncc` (`MaNCC`, `TenNCC`, `DiaChi`, `SoDienThoai`) VALUES
(1, 'Công ty ABC', 'Hà Nội', '0901122334'),
(2, 'Công ty XYZ', 'Hải Phòng', '0902233445'),
(3, 'Công ty DEF', 'Đà Nẵng', '0913344556'),
(4, 'Công ty LMN', 'TP HCM', '0924455667');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` int(11) NOT NULL,
  `HoTen` varchar(255) NOT NULL,
  `ChucVu` varchar(50) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `HoTen`, `ChucVu`, `SoDienThoai`) VALUES
(1, 'Nguyễn Văn A', 'Quản lý', '0987654321'),
(2, 'Bùi Văn G', 'Nhân viên', '0933344455'),
(3, 'Đỗ Thị H', 'Nhân viên', '0966677889'),
(4, 'Phạm Thị D', 'Nhân viên', '0901234567');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhap`
--

CREATE TABLE `nhap` (
  `MaPN` int(11) NOT NULL,
  `MaNCC` int(11) DEFAULT NULL,
  `NgayNhap` date NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `TrangThai` enum('confirmed','deny','pending') DEFAULT 'pending',
  `MaHoaDon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhap`
--

INSERT INTO `nhap` (`MaPN`, `MaNCC`, `NgayNhap`, `MaNV`, `TrangThai`, `MaHoaDon`) VALUES
(1, 1, '2025-03-05', 4, 'confirmed', 1),
(2, 2, '2025-03-06', 3, 'pending', 2),
(3, 3, '2025-03-07', 4, 'deny', 3),
(4, 4, '2025-03-08', 3, 'pending', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `TrangThai` enum('hide','show') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'show',
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(255) NOT NULL,
  `LoaiSP` varchar(100) DEFAULT NULL,
  `KichCo` varchar(10) DEFAULT NULL,
  `MauSac` varchar(50) DEFAULT NULL,
  `GiaNhap` float NOT NULL,
  `GiaXuat` float NOT NULL,
  `SoLuongTon` int(11) NOT NULL DEFAULT 0,
  `NgayNhap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`TrangThai`, `MaSP`, `TenSP`, `LoaiSP`, `KichCo`, `MauSac`, `GiaNhap`, `GiaXuat`, `SoLuongTon`, `NgayNhap`) VALUES
('hide', 1, 'Áo thun', 'Thời trang', 'M', 'đen', 100000, 150000, 50, '2025-03-01'),
('hide', 2, 'Quần jeans', 'Thời trang', 'L', 'Xanh', 200000, 300000, 30, '2025-03-02'),
('hide', 3, 'Giày thể thao', 'Giày dép', '42', 'Đen', 500000, 700000, 20, '2025-03-03'),
('hide', 4, 'Balo du lịch', 'Phụ kiện', 'One-size', 'Xám', 250000, 350000, 40, '2025-03-04'),
('hide', 6, 'Áo thun', 'Áo nam', 'M', 'Đỏ', 100000, 150000, 50, '2025-03-01'),
('hide', 7, 'Quần jeans', 'Quần Nữ', 'L', 'Xanh', 200000, 300000, 30, '2025-03-02'),
('hide', 8, 'Giày thể thao', 'Giày nam', '42', 'Đen', 500000, 700000, 5, '2025-03-03'),
('hide', 9, 'Balo du lịch', 'Phụ kiện', 'One-size', 'Xám', 250000, 350000, 40, '2025-03-04'),
('hide', 10, 'Ao Lot', 'Ao Nu', NULL, 'trắng', 100000, 150000, 0, '2025-03-21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `useraccount`
--

CREATE TABLE `useraccount` (
  `UserID` varchar(8) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('Quản lý','Nhân viên') NOT NULL,
  `MaNV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `useraccount`
--

INSERT INTO `useraccount` (`UserID`, `UserName`, `Password`, `Role`, `MaNV`) VALUES
('ADMIN', 'admin', '$2y$10$h2q3akzzd54izcLCtKHGJ.guXvyW74oBlaL.b2k2DDlMoRO24uu9G', 'Quản lý', NULL),
('USER1', 'user1', '$2y$10$GEWuWZAcsXQcgsdCZNgdNuLLSbpYEM1NJ.CG3mKKHTJkQtq3oPP3q', 'Nhân viên', NULL),
('USER2', 'user2', '$2y$10$w7x9CX/yHlosRyg..9SmH.TiZ.t6eUn1IhLPYDYBD5fUD1jbzckBe', 'Nhân viên', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vw_alltransactions`
-- (See below for the actual view)
--
CREATE TABLE `vw_alltransactions` (
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuat`
--

CREATE TABLE `xuat` (
  `MaPX` int(11) NOT NULL,
  `NgayXuat` date NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `MaKH` varchar(8) NOT NULL,
  `TrangThai` enum('confirmed','pending') DEFAULT 'pending',
  `MaHoaDon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `xuat`
--

INSERT INTO `xuat` (`MaPX`, `NgayXuat`, `MaNV`, `MaKH`, `TrangThai`, `MaHoaDon`) VALUES
(1, '2025-03-10', 2, 'KH001', 'pending', 15),
(2, '2025-03-11', 3, 'KH002', 'pending', 16),
(3, '2025-03-12', 4, 'KH003', 'pending', 17),
(4, '2025-03-13', 3, 'KH004', 'pending', 18);

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vw_alltransactions`
--
DROP TABLE IF EXISTS `vw_alltransactions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_alltransactions`  AS SELECT `nhap`.`MaPN` AS `MaPhieu`, 'Nhập' AS `LoaiPhieu`, `nhap`.`NgayNhap` AS `NgayThucHien`, `nhap`.`MaNV` AS `NguoiTao`, NULL AS `MaDon`, `nhap`.`TrangThai` AS `TrangThaiGiaoDich` FROM `nhap`union all select `xuat`.`MaPX` AS `MaPhieu`,'Xuất' AS `LoaiPhieu`,`xuat`.`NgayXuat` AS `NgayThucHien`,`xuat`.`MaNV` AS `NguoiTao`,`xuat`.`MaDon` AS `MaDon`,`xuat`.`TrangThaiXuat` AS `TrangThaiGiaoDich` from `xuat`  ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaChiTiet`),
  ADD KEY `MaSP` (`MaSP`),
  ADD KEY `MaDon` (`MaDon`);

--
-- Chỉ mục cho bảng `chitietnhap`
--
ALTER TABLE `chitietnhap`
  ADD PRIMARY KEY (`MaPN`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `chitietxuat`
--
ALTER TABLE `chitietxuat`
  ADD PRIMARY KEY (`MaPX`,`MaSP`),
  ADD KEY `MaSP` (`MaSP`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDon`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `donhang_ibfk_2` (`MaPX`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHoaDon`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`);

--
-- Chỉ mục cho bảng `ncc`
--
ALTER TABLE `ncc`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`);

--
-- Chỉ mục cho bảng `nhap`
--
ALTER TABLE `nhap`
  ADD PRIMARY KEY (`MaPN`),
  ADD KEY `MaNCC` (`MaNCC`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MaHoaDon` (`MaHoaDon`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `NgayNhap` (`NgayNhap`);

--
-- Chỉ mục cho bảng `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `xuat`
--
ALTER TABLE `xuat`
  ADD PRIMARY KEY (`MaPX`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `MaKH` (`MaKH`),
  ADD KEY `MaHoaDon` (`MaHoaDon`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `MaChiTiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHoaDon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDon`) REFERENCES `donhang` (`MaDon`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chitietnhap`
--
ALTER TABLE `chitietnhap`
  ADD CONSTRAINT `chitietnhap_ibfk_1` FOREIGN KEY (`MaPN`) REFERENCES `nhap` (`MaPN`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitietnhap_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chitietxuat`
--
ALTER TABLE `chitietxuat`
  ADD CONSTRAINT `chitietxuat_ibfk_1` FOREIGN KEY (`MaPX`) REFERENCES `xuat` (`MaPX`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitietxuat_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`MaPX`) REFERENCES `xuat` (`MaPX`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Các ràng buộc cho bảng `nhap`
--
ALTER TABLE `nhap`
  ADD CONSTRAINT `nhap_ibfk_1` FOREIGN KEY (`MaNCC`) REFERENCES `ncc` (`MaNCC`) ON DELETE CASCADE,
  ADD CONSTRAINT `nhap_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL,
  ADD CONSTRAINT `nhap_ibfk_3` FOREIGN KEY (`MaHoaDon`) REFERENCES `hoadon` (`MaHoaDon`);

--
-- Các ràng buộc cho bảng `useraccount`
--
ALTER TABLE `useraccount`
  ADD CONSTRAINT `useraccount_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `xuat`
--
ALTER TABLE `xuat`
  ADD CONSTRAINT `xuat_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`) ON DELETE SET NULL,
  ADD CONSTRAINT `xuat_ibfk_2` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE,
  ADD CONSTRAINT `xuat_ibfk_3` FOREIGN KEY (`MaHoaDon`) REFERENCES `hoadon` (`MaHoaDon`),
  ADD CONSTRAINT `xuat_ibfk_4` FOREIGN KEY (`MaHoaDon`) REFERENCES `hoadon` (`MaHoaDon`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
