-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 07, 2025 lúc 10:22 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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
(4, 2, 10, 200000),
(5, 10, 100, 100000),
(6, 11, 50, 200000),
(7, 10, 100, 0),
(8, 11, 200, 0),
(9, 12, 230, 0),
(10, 16, 1000, 0),
(11, 15, 2000, 0),
(12, 11, 100, 0),
(12, 14, 100, 0),
(13, 8, 150, 0),
(13, 13, 100, 0),
(14, 11, 230, 0),
(14, 14, 100, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietxuat`
--

CREATE TABLE `chitietxuat` (
  `MaPX` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `DonGia` decimal(18,4) NOT NULL,
  `SoLuongXuat` int(11) NOT NULL,
  `ThanhTien` decimal(18,4) GENERATED ALWAYS AS (`SoLuongXuat` * `DonGia`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietxuat`
--

INSERT INTO `chitietxuat` (`MaPX`, `MaSP`, `DonGia`, `SoLuongXuat`) VALUES
(1, 1, 150000.0000, 5),
(1, 2, 100000.0000, 100),
(2, 2, 300000.0000, 3),
(3, 3, 700000.0000, 2),
(4, 4, 350000.0000, 4),
(5, 1, 150000.0000, 10),
(5, 4, 350000.0000, 20),
(5, 8, 700000.0000, 2),
(6, 3, 700000.0000, 11),
(6, 9, 350000.0000, 2),
(7, 1, 160000.0000, 20),
(8, 2, 300000.0000, 10),
(8, 3, 700000.0000, 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cuahang`
--

CREATE TABLE `cuahang` (
  `MaCH` varchar(8) NOT NULL,
  `TenCH` varchar(255) NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `SoDienThoai` varchar(20) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `UserID` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cuahang`
--

INSERT INTO `cuahang` (`MaCH`, `TenCH`, `DiaChi`, `SoDienThoai`, `Email`, `UserID`) VALUES
('CH001', 'Nguyễn Văn X', 'Hà Nội', '0901122334', 'x@gmail.com', 'USER6'),
('CH002', 'Trần Thị Y', 'Hải Phòng', '0902233445', 'y@gmail.com', NULL),
('CH003', 'Lê Văn Z', 'Đà Nẵng', '0913344556', 'z@gmail.com', NULL),
('CH004', 'Hoàng Anh K', 'TP HCM', '0924455667', 'k@gmail.com', NULL),
('CH005', 'Nguyễn Hùng M', 'Cần Thơ', '0935566778', 'm@gmail.com', NULL),
('CH006', 'Nguyễn Văn X', 'Hà Nội', '0901122334', 'x@gmail.com', NULL),
('CH007', 'Trần Thị Y', 'Hải Phòng', '0902233445', 'y@gmail.com', NULL),
('CH008', 'Lê Văn Z', 'Đà Nẵng', '0913344556', 'z@gmail.com', NULL),
('CH009', 'Hoàng Anh K', 'TP HCM', '0924455667', 'k@gmail.com', NULL),
('CH010', 'Nguyễn Hùng M', 'Cần Thơ', '0935566778', 'm@gmail.com', NULL),
('CH011', 'KriK', 'Hà Nội', '0123456789', 'p@gmail.com', 'USER7');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDon` varchar(50) NOT NULL,
  `MaPX` int(11) NOT NULL,
  `NgayDat` datetime NOT NULL DEFAULT current_timestamp(),
  `TrangThai` enum('pending','canceled','confirmed') DEFAULT 'pending',
  `GhiChu` text DEFAULT NULL,
  `MaCH` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDon`, `MaPX`, `NgayDat`, `TrangThai`, `GhiChu`, `MaCH`) VALUES
('D001', 1, '2025-03-14 00:00:00', 'pending', NULL, 'CH005'),
('D002', 2, '2025-03-15 00:00:00', 'pending', NULL, 'CH008'),
('D003', 3, '2025-03-16 00:00:00', 'pending', NULL, 'CH002'),
('D004', 4, '2025-03-17 00:00:00', 'confirmed', NULL, 'CH001');

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
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `UserID` varchar(8) DEFAULT NULL,
  `ChucVu` enum('Quản lý','Nhân viên','Cửa Hàng') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `HoTen`, `SoDienThoai`, `UserID`, `ChucVu`) VALUES
(1, 'Nguyễn Văn A', '0987654321', 'USER0', 'Quản lý'),
(2, 'Bùi Văn G', '09333444343', 'USER1', 'Nhân viên'),
(3, 'Đỗ Thị L', '0966677889', 'USER2', 'Nhân viên'),
(4, 'Phạm Thị D', '0901234567', 'USER3', 'Nhân viên'),
(5, 'Nguyễn Tấn Phát1', '091209176652', 'USER4', 'Nhân viên'),
(6, 'Đỗ Thị Linh', '0912091766', 'USER5', 'Nhân viên'),
(7, 'Nguyễn Tấn Fat', '0817288868', 'USER8', 'Nhân viên'),
(8, 'th', '12', '345', 'Nhân viên'),
(9, 'Hoàng Cát Tường', '123456789', '123', 'Nhân viên'),
(10, 'hh', '123', '232', 'Nhân viên'),
(11, 'Nguyễn Tấn Phát', '0912091788', 'USER12', 'Nhân viên');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhap`
--

CREATE TABLE `nhap` (
  `MaPN` int(11) NOT NULL,
  `MaNCC` int(11) DEFAULT NULL,
  `NgayNhap` date NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `TrangThai` enum('confirmed','deny','pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhap`
--

INSERT INTO `nhap` (`MaPN`, `MaNCC`, `NgayNhap`, `MaNV`, `TrangThai`) VALUES
(1, 1, '2025-03-05', 4, 'confirmed'),
(2, 2, '2025-03-06', 3, 'confirmed'),
(3, 3, '2025-03-07', 4, 'confirmed'),
(4, 4, '2025-03-08', 3, 'deny'),
(5, 3, '2025-04-07', 2, 'confirmed'),
(6, 1, '2025-04-07', 2, 'confirmed'),
(7, 2, '2025-04-07', 2, 'confirmed'),
(8, 4, '2025-04-07', 2, 'confirmed'),
(9, 1, '2025-04-07', 2, 'confirmed'),
(10, 3, '2025-04-07', 7, 'deny'),
(11, 1, '2025-04-07', 7, 'confirmed'),
(12, 3, '2025-04-07', 7, 'deny'),
(13, 2, '2025-04-08', 2, 'pending'),
(14, 1, '2025-04-08', 2, 'pending');

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
('show', 1, 'Áo thun', 'Thời trang', 'MM', 'đenM', 100, 160, 20, '2025-03-01'),
('show', 2, 'Quần jeans', 'Thời trang', 'L', 'Xanh', 200000, 300000, 20, '2025-03-02'),
('show', 3, 'Giày thể thao', 'Giày dép', '43', 'Đen', 500, 700, 0, '2025-03-03'),
('show', 4, 'Balo du lịch', 'Phụ kiện', 'One-size', 'Đen', 250, 350, 30, '2025-03-04'),
('show', 6, 'Áo thun', 'Áo nam', 'M', 'Đỏ', 100000, 150000, 60, '2025-03-01'),
('show', 7, 'Quần jeans', 'Quần Nữ', 'LL', 'Xanh', 200, 333333, 30, '2025-03-02'),
('show', 8, 'Giày thể thao', 'Giày nam', '42', 'Đen', 500000, 700000, 3, '2025-03-03'),
('show', 9, 'Balo du lịch', 'Phụ kiện', 'One-size', 'Xám', 250000, 350000, 38, '2025-03-04'),
('show', 10, 'Ao Lot', 'Ao Nu', 'C', 'trắng', 100000, 150000, 200, '2025-03-21'),
('show', 11, 'áo sơ mi', 'áo nam', 'M', 'trắng', 200000, 250000, 200, '2025-04-05'),
('show', 12, 'hoodie', 'áo nam', 'L', 'đen', 200, 150, 230, '2025-04-05'),
('show', 13, 'Áo Quây', 'Áo Nữ', 'S', 'Đen', 100000, 200000, 0, '2025-04-07'),
('show', 14, 'Tất', 'Phụ Kiện', 'FreeSize', 'Đen', 10000, 150000, 0, '2025-04-07'),
('show', 15, 'Mũ Len', 'Mũ', 'FreeSize', 'Đỏ', 1, 200000, 2000, '2025-04-07'),
('show', 16, 'Mũ Lưỡi Trai', 'Mũ', 'FreeSize', 'Xanh', 1000, 150, 0, '2025-04-07'),
('show', 23, 'Áo một mảnh', 'Áo nam', 'L', 'Đỏ', 123000, 222000, 0, '2025-04-07'),
('show', 45, 'Áo hoodie', 'Áo nam', 'L', 'Hồng', 200, 250, 0, '2025-04-07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `useraccount`
--

CREATE TABLE `useraccount` (
  `UserID` varchar(8) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('Quản lý','Nhân viên','Cửa Hàng') NOT NULL DEFAULT 'Cửa Hàng',
  `TrangThai` enum('normal','banned') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `useraccount`
--

INSERT INTO `useraccount` (`UserID`, `UserName`, `Password`, `Role`, `TrangThai`) VALUES
('USER0', 'ad', '$2y$10$h2q3akzzd54izcLCtKHGJ.guXvyW74oBlaL.b2k2DDlMoRO24uu9G', 'Quản lý', 'normal'),
('USER1', 'user1', '$2y$10$jLZHlURlSzFGFapgPccUUuLiBN53aHNpeVunfCAHYKTBpZNYL0fsy', 'Nhân viên', 'normal'),
('USER10', 'th', '$2y$10$tAdaJvbJS3liuiq.19ZfCeWD2We9EQlS9wRhffAFqxEwbOXzTIhk.', 'Nhân viên', 'normal'),
('USER11', 'tuo', '$2y$10$ThOKHWehCERCQlmHvBxdU.sckmdLeaT1RL4p14XmEPAMd4Dhn0wk6', 'Nhân viên', 'normal'),
('USER12', 'phat1', '$2y$10$6BG9R8ar1X0o5QxoloJXdOcwYgrwI6bTUGmqaN58BDs8BcGj5tG7y', 'Nhân viên', 'normal'),
('USER2', 'user2', '$2y$10$IdGrR5Q67X/.Wgf9sXw6r.mjUnB9CpcLkgkRjRH.OBVPl3uUjhFT2', 'Nhân viên', 'normal'),
('USER3', 'user3', '$2y$10$Kjxjl0Sd./rTGFwPwVB/ze.b5d5GKckbmFQHSqzxY7d5qotPYcyka', 'Nhân viên', 'normal'),
('USER4', 'user4', '$2y$10$yRF/3fRq2oD4LNv8q2miaerbxqS.z0RUY09b5hMDsSRE9/UP8CKXu', 'Nhân viên', 'normal'),
('USER5', 'user5', '$2y$10$OqTyG9pnqZxqygy9K51RpOzNPrP6Dyj7OeJ2cILOEFeEW8Mu/VA7m', 'Nhân viên', 'normal'),
('USER6', 'ch1', '$2y$10$rfD0C0BvJp6syqH6N0.QUObTJMMWbuJXjyZ4Acou27lon9N7vzZSi', 'Cửa Hàng', 'normal'),
('USER7', 'user7', '$2y$10$vaetHu2tRQMl1FqI2FylGOJ4JICDqatdtjFNfFvdXouMOR/D33HBO', 'Cửa Hàng', 'normal'),
('USER8', 'u8', '$2y$10$Dlhsk/yTZr94L95OfxOCee0u.fWflb2lFxu5bPgYt/TW5frBNHgAu', 'Nhân viên', 'normal'),
('USER9', 'tuong', '$2y$10$UCdrk0zzn8UbFUrkiaCuzekwwW4UKG2VBmJ6cgGME8lEoubBRAO3C', 'Nhân viên', 'normal');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuat`
--

CREATE TABLE `xuat` (
  `MaPX` int(11) NOT NULL,
  `NgayXuat` date NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `TrangThai` enum('confirmed','deny','pending') DEFAULT 'pending',
  `MaCH` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `xuat`
--

INSERT INTO `xuat` (`MaPX`, `NgayXuat`, `MaNV`, `TrangThai`, `MaCH`) VALUES
(1, '2025-04-06', 2, 'confirmed', 'CH005'),
(2, '2025-04-07', 1, 'confirmed', 'CH008'),
(3, '2025-04-07', 5, 'confirmed', 'CH002'),
(4, '2025-03-13', 3, 'deny', 'CH001'),
(5, '2025-04-07', 2, 'pending', 'CH001'),
(6, '2025-04-07', 2, 'deny', 'CH001'),
(7, '2025-04-07', 1, 'confirmed', 'CH001'),
(8, '2025-04-07', 2, 'confirmed', 'CH001');

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
-- Chỉ mục cho bảng `cuahang`
--
ALTER TABLE `cuahang`
  ADD PRIMARY KEY (`MaCH`),
  ADD KEY `cuahang_ibfk_1` (`UserID`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDon`),
  ADD KEY `donhang_ibfk_2` (`MaPX`),
  ADD KEY `donhang_ibfk_1` (`MaCH`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHoaDon`),
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `ncc`
--
ALTER TABLE `ncc`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`),
  ADD KEY `nhanvien_ibfk_1` (`UserID`),
  ADD KEY `nhanvien_ibfk_2` (`ChucVu`);

--
-- Chỉ mục cho bảng `nhap`
--
ALTER TABLE `nhap`
  ADD PRIMARY KEY (`MaPN`),
  ADD KEY `MaNCC` (`MaNCC`),
  ADD KEY `MaNV` (`MaNV`);

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
  ADD KEY `ChucVu` (`Role`);

--
-- Chỉ mục cho bảng `xuat`
--
ALTER TABLE `xuat`
  ADD PRIMARY KEY (`MaPX`),
  ADD KEY `MaNV` (`MaNV`),
  ADD KEY `xuat_ibfk_2` (`MaCH`);

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
  MODIFY `MaHoaDon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `xuat`
--
ALTER TABLE `xuat`
  MODIFY `MaPX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
