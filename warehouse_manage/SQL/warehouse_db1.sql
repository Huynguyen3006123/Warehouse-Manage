-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 12, 2025 lúc 05:43 AM
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
  `MaDon` varchar(8) NOT NULL,
  `MaSP` varchar(8) NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` > 0),
  `DonGia` decimal(18,2) NOT NULL CHECK (`DonGia` >= 0),
  `ThanhTien` decimal(18,2) GENERATED ALWAYS AS (`SoLuong` * `DonGia`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaChiTiet`, `MaDon`, `MaSP`, `SoLuong`, `DonGia`) VALUES
(1, 'DH001', 'SP001', 2, 150000.00),
(2, 'DH002', 'SP002', 1, 250000.00),
(3, 'DH003', 'SP003', 3, 350000.00),
(4, 'DH004', 'SP004', 1, 500000.00),
(5, 'DH005', 'SP005', 2, 200000.00),
(6, 'DH006', 'SP006', 2, 250000.00),
(7, 'DH007', 'SP007', 1, 450000.00),
(8, 'DH008', 'SP008', 3, 500000.00),
(9, 'DH009', 'SP009', 1, 700000.00),
(10, 'DH010', 'SP010', 4, 350000.00),
(11, 'DH006', 'SP021', 2, 350000.00),
(12, 'DH006', 'SP022', 1, 450000.00),
(13, 'DH006', 'SP023', 2, 280000.00),
(14, 'DH007', 'SP024', 1, 750000.00),
(15, 'DH007', 'SP025', 1, 420000.00),
(16, 'DH007', 'SP026', 1, 520000.00),
(17, 'DH008', 'SP027', 1, 650000.00),
(18, 'DH008', 'SP028', 1, 1200000.00),
(19, 'DH009', 'SP029', 2, 300000.00),
(20, 'DH009', 'SP030', 1, 500000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietnhap`
--

CREATE TABLE `chitietnhap` (
  `MaPN` varchar(8) NOT NULL,
  `MaSP` varchar(8) NOT NULL,
  `SoLuongNhap` int(11) NOT NULL,
  `GiaNhap` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietnhap`
--

INSERT INTO `chitietnhap` (`MaPN`, `MaSP`, `SoLuongNhap`, `GiaNhap`) VALUES
('PN001', 'SP001', 50, 140000.00),
('PN002', 'SP002', 40, 230000.00),
('PN003', 'SP003', 30, 330000.00),
('PN004', 'SP004', 20, 480000.00),
('PN005', 'SP005', 60, 190000.00),
('PN006', 'SP006', 20, 230000.00),
('PN006', 'SP021', 10, 320000.00),
('PN006', 'SP022', 12, 400000.00),
('PN006', 'SP023', 15, 250000.00),
('PN007', 'SP007', 15, 420000.00),
('PN007', 'SP024', 8, 700000.00),
('PN007', 'SP025', 6, 380000.00),
('PN007', 'SP026', 5, 480000.00),
('PN008', 'SP008', 10, 480000.00),
('PN008', 'SP027', 9, 600000.00),
('PN008', 'SP028', 4, 1100000.00),
('PN009', 'SP009', 8, 680000.00),
('PN009', 'SP029', 15, 270000.00),
('PN009', 'SP030', 7, 450000.00),
('PN010', 'SP010', 25, 320000.00),
('PN011', 'SP011', 18, 380000.00),
('PN012', 'SP012', 22, 180000.00),
('PN013', 'SP013', 12, 500000.00),
('PN014', 'SP014', 5, 1150000.00),
('PN015', 'SP015', 14, 780000.00),
('PN016', 'SP016', 30, 620000.00),
('PN017', 'SP017', 10, 870000.00),
('PN018', 'SP018', 40, 160000.00),
('PN019', 'SP019', 35, 230000.00),
('PN020', 'SP020', 17, 650000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietxuat`
--

CREATE TABLE `chitietxuat` (
  `MaPX` varchar(8) NOT NULL,
  `MaSP` varchar(8) NOT NULL,
  `SoLuongXuat` int(11) NOT NULL CHECK (`SoLuongXuat` > 0),
  `GiaXuat` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietxuat`
--

INSERT INTO `chitietxuat` (`MaPX`, `MaSP`, `SoLuongXuat`, `GiaXuat`) VALUES
('PX001', 'SP001', 10, 0),
('PX002', 'SP002', 15, 0),
('PX003', 'SP003', 20, 0),
('PX004', 'SP004', 5, 0),
('PX005', 'SP005', 25, 0),
('PX006', 'SP006', 5, 0),
('PX006', 'SP021', 3, 0),
('PX006', 'SP022', 2, 0),
('PX006', 'SP023', 4, 0),
('PX007', 'SP007', 7, 0),
('PX007', 'SP024', 3, 0),
('PX007', 'SP025', 2, 0),
('PX007', 'SP026', 1, 0),
('PX008', 'SP008', 3, 0),
('PX008', 'SP027', 2, 0),
('PX008', 'SP028', 1, 0),
('PX009', 'SP009', 4, 0),
('PX009', 'SP029', 3, 0),
('PX009', 'SP030', 2, 0),
('PX010', 'SP010', 8, 0),
('PX011', 'SP011', 6, 0),
('PX012', 'SP012', 10, 0),
('PX013', 'SP013', 2, 0),
('PX014', 'SP014', 1, 0),
('PX015', 'SP015', 5, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MaDon` varchar(8) NOT NULL,
  `MaKH` varchar(8) NOT NULL,
  `NgayDat` datetime NOT NULL DEFAULT current_timestamp(),
  `TrangThai` enum('Đang xử lý','Đã giao','Đã hủy') DEFAULT 'Đang xử lý'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`MaDon`, `MaKH`, `NgayDat`, `TrangThai`) VALUES
('DH001', 'KH001', '2025-03-11 18:36:44', 'Đang xử lý'),
('DH002', 'KH002', '2025-03-11 18:36:44', 'Đã giao'),
('DH003', 'KH003', '2025-03-11 18:36:44', 'Đang xử lý'),
('DH004', 'KH004', '2025-03-11 18:36:44', 'Đã hủy'),
('DH005', 'KH005', '2025-03-11 18:36:44', 'Đã giao'),
('DH006', 'KH006', '2025-03-01 00:00:00', 'Đang xử lý'),
('DH007', 'KH007', '2025-03-02 00:00:00', 'Đã giao'),
('DH008', 'KH008', '2025-03-03 00:00:00', 'Đang xử lý'),
('DH009', 'KH009', '2025-03-04 00:00:00', 'Đã giao'),
('DH010', 'KH010', '2025-03-05 00:00:00', 'Đã hủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` varchar(8) NOT NULL,
  `TenKH` varchar(255) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `DiaChi`, `SoDienThoai`, `Email`) VALUES
('KH001', 'Nguyen Van A', 'Hà Nội', '0901123456', 'a@gmail.com'),
('KH002', 'Tran Thi B', 'TP.HCM', '0902234567', 'b@gmail.com'),
('KH003', 'Le Van C', 'Đà Nẵng', '0903345678', 'c@gmail.com'),
('KH004', 'Pham Thi D', 'Cần Thơ', '0904456789', 'd@gmail.com'),
('KH005', 'Hoang Van E', 'Hải Phòng', '0905567890', 'e@gmail.com'),
('KH006', 'Trần Minh D', 'Hà Nội', '0978123456', 'tranminhd@gmail.com'),
('KH007', 'Lê Hồng G', 'TP.HCM', '0987234567', 'lehg@gmail.com'),
('KH008', 'Nguyễn Văn H', 'Đà Nẵng', '0986345678', 'nguyenvanh@gmail.com'),
('KH009', 'Phạm Văn K', 'Hải Phòng', '0978456789', 'phamvank@gmail.com'),
('KH010', 'Bùi Thị M', 'Cần Thơ', '0967567890', 'buithim@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ncc`
--

CREATE TABLE `ncc` (
  `MaNCC` varchar(8) NOT NULL,
  `TenNCC` varchar(255) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ncc`
--

INSERT INTO `ncc` (`MaNCC`, `TenNCC`, `DiaChi`, `SoDienThoai`) VALUES
('NCC001', 'Công ty A', 'Hà Nội', '0912345678'),
('NCC002', 'Công ty B', 'TP.HCM', '0923456789'),
('NCC003', 'Công ty C', 'Đà Nẵng', '0934567890'),
('NCC004', 'Công ty D', 'Cần Thơ', '0945678901'),
('NCC005', 'Công ty E', 'Hải Phòng', '0956789012'),
('NCC006', 'Công ty X', 'Hà Nội', '0988888886'),
('NCC007', 'Công ty Y', 'TP.HCM', '0988888887'),
('NCC008', 'Công ty Z', 'Đà Nẵng', '0988888888'),
('NCC009', 'Công ty A', 'Hải Phòng', '0988888889'),
('NCC010', 'Công ty B', 'Cần Thơ', '0988888890'),
('NCC011', 'Công ty C', 'Huế', '0988888891'),
('NCC012', 'Công ty D', 'Nha Trang', '0988888892'),
('NCC013', 'Công ty E', 'Vinh', '0988888893'),
('NCC014', 'Công ty F', 'Quảng Ninh', '0988888894'),
('NCC015', 'Công ty G', 'Bắc Ninh', '0988888895'),
('NCC016', 'Công ty H', 'Hà Tĩnh', '0988888896'),
('NCC017', 'Công ty I', 'Đồng Nai', '0988888897'),
('NCC018', 'Công ty J', 'Bình Dương', '0988888898'),
('NCC019', 'Công ty K', 'Vũng Tàu', '0988888899'),
('NCC020', 'Công ty L', 'Thanh Hóa', '0988888900'),
('NCC021', 'Công ty M', 'Ninh Bình', '0988888901'),
('NCC022', 'Công ty N', 'Nam Định', '0988888902'),
('NCC023', 'Công ty O', 'Thái Bình', '0988888903'),
('NCC024', 'Công ty P', 'Hà Nam', '0988888904'),
('NCC025', 'Công ty Q', 'Cao Bằng', '0988888905');

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
(1, 'Nguyen Van A', 'Quản lý', '0987654321'),
(2, 'Tran Thi B', 'Nhân viên', '0978456123'),
(3, 'Le Van C', 'Nhân viên', '0967845123');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhap`
--

CREATE TABLE `nhap` (
  `MaPN` varchar(8) NOT NULL,
  `MaNCC` varchar(8) DEFAULT NULL,
  `NgayNhap` date NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `TrangThai` enum('Chờ duyệt','Đã duyệt','Từ chối') DEFAULT 'Chờ duyệt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhap`
--

INSERT INTO `nhap` (`MaPN`, `MaNCC`, `NgayNhap`, `MaNV`, `TrangThai`) VALUES
('PN001', 'NCC001', '2025-03-01', 1, 'Đã duyệt'),
('PN002', 'NCC002', '2025-03-02', 2, 'Chờ duyệt'),
('PN003', 'NCC003', '2025-03-03', 3, 'Đã duyệt'),
('PN004', 'NCC004', '2025-03-04', 4, 'Từ chối'),
('PN005', 'NCC005', '2025-03-05', 5, 'Chờ duyệt'),
('PN006', 'NCC006', '2025-03-01', 6, 'Chờ duyệt'),
('PN007', 'NCC007', '2025-03-02', 7, 'Đã duyệt'),
('PN008', 'NCC008', '2025-03-03', 8, 'Từ chối'),
('PN009', 'NCC009', '2025-03-04', 9, 'Đã duyệt'),
('PN010', 'NCC010', '2025-03-05', 10, 'Chờ duyệt'),
('PN011', 'NCC011', '2025-03-06', 11, 'Đã duyệt'),
('PN012', 'NCC012', '2025-03-07', 12, 'Chờ duyệt'),
('PN013', 'NCC013', '2025-03-08', 13, 'Từ chối'),
('PN014', 'NCC014', '2025-03-09', 14, 'Đã duyệt'),
('PN015', 'NCC015', '2025-03-10', 15, 'Chờ duyệt'),
('PN016', 'NCC016', '2025-03-11', 16, 'Đã duyệt'),
('PN017', 'NCC017', '2025-03-12', 17, 'Từ chối'),
('PN018', 'NCC018', '2025-03-13', 18, 'Chờ duyệt'),
('PN019', 'NCC019', '2025-03-14', 19, 'Đã duyệt'),
('PN020', 'NCC020', '2025-03-15', 20, 'Chờ duyệt'),
('PN021', 'NCC021', '2025-03-16', 1, 'Đã duyệt'),
('PN022', 'NCC022', '2025-03-17', 2, 'Từ chối'),
('PN023', 'NCC023', '2025-03-18', 3, 'Đã duyệt'),
('PN024', 'NCC024', '2025-03-19', 4, 'Chờ duyệt'),
('PN025', 'NCC025', '2025-03-20', 5, 'Đã duyệt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` varchar(8) NOT NULL,
  `TenSP` varchar(255) NOT NULL,
  `LoaiSP` varchar(100) DEFAULT NULL,
  `MauSac` varchar(50) DEFAULT NULL,
  `Gia` decimal(18,2) NOT NULL,
  `SoLuongTon` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `LoaiSP`, `MauSac`, `Gia`, `SoLuongTon`) VALUES
('SP001', 'Áo Thun', 'Thời trang', 'Đỏ', 150000.00, 100),
('SP002', 'Quần Jean', 'Thời trang', 'Xanh', 250000.00, 80),
('SP003', 'Áo Khoác', 'Thời trang', 'Đen', 350000.00, 50),
('SP004', 'Giày Sneaker', 'Giày dép', 'Trắng', 500000.00, 30),
('SP005', 'Túi Xách', 'Phụ kiện', 'Nâu', 200000.00, 60),
('SP006', 'Áo Polo', 'Áo', 'Xanh', 250000.00, 10),
('SP007', 'Áo Hoodie', 'Áo', 'Đen', 450000.00, 15),
('SP008', 'Áo Len', 'Áo', 'Xám', 500000.00, 8),
('SP009', 'Áo Blazer', 'Áo', 'Xanh Navy', 700000.00, 5),
('SP010', 'Quần Kaki', 'Quần', 'Nâu', 350000.00, 12),
('SP011', 'Quần Jean', 'Quần', 'Đen', 400000.00, 20),
('SP012', 'Quần Short', 'Quần', 'Be', 200000.00, 18),
('SP013', 'Váy Midi', 'Váy', 'Hồng', 550000.00, 6),
('SP014', 'Váy Dạ Hội', 'Váy', 'Đỏ', 1200000.00, 4),
('SP015', 'Váy Công Sở', 'Váy', 'Xanh Ngọc', 800000.00, 9),
('SP016', 'Giày Sneaker', 'Giày', 'Trắng', 650000.00, 30),
('SP017', 'Giày Da', 'Giày', 'Nâu', 900000.00, 12),
('SP018', 'Dép Lê', 'Dép', 'Xám', 180000.00, 50),
('SP019', 'Dép Quai Hậu', 'Dép', 'Xanh', 250000.00, 40),
('SP020', 'Túi Xách', 'Phụ kiện', 'Đen', 700000.00, 15),
('SP021', 'Áo Hoodie Local Brand', 'Áo', 'Đen', 350000.00, 30),
('SP022', 'Quần Jean Slimfit', 'Quần', 'Xanh', 450000.00, 25),
('SP023', 'Áo Polo Cao Cấp', 'Áo', 'Trắng', 280000.00, 40),
('SP024', 'Giày Sneaker Classic', 'Giày', 'Trắng Đen', 750000.00, 20),
('SP025', 'Balo Du Lịch Cỡ Nhỏ', 'Phụ kiện', 'Xám', 420000.00, 15),
('SP026', 'Váy Xòe Vintage', 'Váy', 'Hồng', 520000.00, 10),
('SP027', 'Áo Khoác Dù Nam', 'Áo', 'Xanh Navy', 650000.00, 18),
('SP028', 'Đồng Hồ Thể Thao', 'Phụ kiện', 'Đỏ', 1200000.00, 12),
('SP029', 'Quần Short Thể Thao', 'Quần', 'Xám', 300000.00, 35),
('SP030', 'Kính Mát Chống UV', 'Phụ kiện', 'Đen', 500000.00, 22),
('SP032', 'X-Men for boss', 'dau goi x sua tam', 'den', 150000.00, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhtoan`
--

CREATE TABLE `thanhtoan` (
  `MaTT` varchar(8) NOT NULL,
  `MaDon` varchar(8) NOT NULL,
  `SoTien` decimal(18,2) NOT NULL CHECK (`SoTien` > 0),
  `PhuongThuc` enum('Tiền mặt','Thẻ','Chuyển khoản') DEFAULT NULL,
  `NgayThanhToan` datetime NOT NULL DEFAULT current_timestamp(),
  `TrangThai` enum('Chưa thanh toán','Đã thanh toán','Thanh toán một phần') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhtoan`
--

INSERT INTO `thanhtoan` (`MaTT`, `MaDon`, `SoTien`, `PhuongThuc`, `NgayThanhToan`, `TrangThai`) VALUES
('TT001', 'DH001', 500000.00, 'Thẻ', '2025-03-11 18:36:45', 'Đã thanh toán'),
('TT002', 'DH002', 250000.00, 'Chuyển khoản', '2025-03-11 18:36:45', 'Đã thanh toán'),
('TT003', 'DH003', 300000.00, 'Tiền mặt', '2025-03-11 18:36:45', 'Thanh toán một phần'),
('TT004', 'DH004', 150000.00, 'Thẻ', '2025-03-11 18:36:45', 'Chưa thanh toán'),
('TT005', 'DH005', 400000.00, 'Tiền mặt', '2025-03-11 18:36:45', 'Đã thanh toán'),
('TT006', 'DH006', 500000.00, 'Chuyển khoản', '2025-03-01 00:00:00', 'Đã thanh toán'),
('TT007', 'DH007', 450000.00, 'Tiền mặt', '2025-03-02 00:00:00', 'Chưa thanh toán'),
('TT008', 'DH008', 1500000.00, 'Thẻ', '2025-03-03 00:00:00', 'Thanh toán một phần'),
('TT009', 'DH009', 700000.00, 'Chuyển khoản', '2025-03-04 00:00:00', 'Đã thanh toán'),
('TT010', 'DH010', 1400000.00, 'Tiền mặt', '2025-03-05 00:00:00', 'Đã thanh toán');

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
('U001', 'admin', '123456', 'Quản lý', 1),
('U002', 'user1', 'password1', 'Nhân viên', 2),
('U003', 'user2', 'password2', 'Nhân viên', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuat`
--

CREATE TABLE `xuat` (
  `MaPX` varchar(8) NOT NULL,
  `MaNV` int(11) DEFAULT NULL,
  `NgayXuat` date NOT NULL,
  `TrangThai` enum('Chờ duyệt','Đã duyệt','Từ chối') DEFAULT 'Chờ duyệt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `xuat`
--

INSERT INTO `xuat` (`MaPX`, `MaNV`, `NgayXuat`, `TrangThai`) VALUES
('PX001', 1, '2025-03-06', 'Đã duyệt'),
('PX002', 2, '2025-03-07', 'Chờ duyệt'),
('PX003', 3, '2025-03-08', 'Đã duyệt'),
('PX004', 4, '2025-03-09', 'Từ chối'),
('PX005', 5, '2025-03-10', 'Chờ duyệt'),
('PX006', 6, '2025-03-01', 'Chờ duyệt'),
('PX007', 7, '2025-03-02', 'Đã duyệt'),
('PX008', 8, '2025-03-03', 'Từ chối'),
('PX009', 9, '2025-03-04', 'Đã duyệt'),
('PX010', 10, '2025-03-05', 'Chờ duyệt'),
('PX011', 11, '2025-03-06', 'Đã duyệt'),
('PX012', 12, '2025-03-07', 'Từ chối'),
('PX013', 13, '2025-03-08', 'Chờ duyệt'),
('PX014', 14, '2025-03-09', 'Đã duyệt'),
('PX015', 15, '2025-03-10', 'Từ chối');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaChiTiet`),
  ADD KEY `MaDon` (`MaDon`),
  ADD KEY `MaSP` (`MaSP`);

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
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaDon`),
  ADD KEY `MaKH` (`MaKH`);

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
  ADD KEY `MaNV` (`MaNV`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`);

--
-- Chỉ mục cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD PRIMARY KEY (`MaTT`),
  ADD KEY `MaDon` (`MaDon`);

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
  ADD KEY `MaNV` (`MaNV`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  MODIFY `MaChiTiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MaNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdonhang`
--
ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`MaDon`) REFERENCES `hoadon` (`MaDon`),
  ADD CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `chitietnhap`
--
ALTER TABLE `chitietnhap`
  ADD CONSTRAINT `chitietnhap_ibfk_1` FOREIGN KEY (`MaPN`) REFERENCES `nhap` (`MaPN`),
  ADD CONSTRAINT `chitietnhap_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `chitietxuat`
--
ALTER TABLE `chitietxuat`
  ADD CONSTRAINT `chitietxuat_ibfk_1` FOREIGN KEY (`MaPX`) REFERENCES `xuat` (`MaPX`),
  ADD CONSTRAINT `chitietxuat_ibfk_2` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`);

--
-- Các ràng buộc cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`);

--
-- Các ràng buộc cho bảng `nhap`
--
ALTER TABLE `nhap`
  ADD CONSTRAINT `nhap_ibfk_1` FOREIGN KEY (`MaNCC`) REFERENCES `ncc` (`MaNCC`),
  ADD CONSTRAINT `nhap_ibfk_2` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Các ràng buộc cho bảng `thanhtoan`
--
ALTER TABLE `thanhtoan`
  ADD CONSTRAINT `thanhtoan_ibfk_1` FOREIGN KEY (`MaDon`) REFERENCES `hoadon` (`MaDon`);

--
-- Các ràng buộc cho bảng `useraccount`
--
ALTER TABLE `useraccount`
  ADD CONSTRAINT `useraccount_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);

--
-- Các ràng buộc cho bảng `xuat`
--
ALTER TABLE `xuat`
  ADD CONSTRAINT `xuat_ibfk_1` FOREIGN KEY (`MaNV`) REFERENCES `nhanvien` (`MaNV`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
