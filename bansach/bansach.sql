-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 04:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bansach`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `DienThoai` varchar(15) NOT NULL,
  `MatKhau` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`DienThoai`, `MatKhau`) VALUES
('012345', '123');

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `idHD` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `idSP` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 1,
  `Gia` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`idHD`, `idSP`, `SoLuong`, `Gia`) VALUES
('HD001', 'SP005', 1, 99000.00),
('HD001', 'SP025', 2, 170000.00),
('HD002', 'SP005', 1, 99000.00),
('HD003', 'SP018', 2, 270000.00),
('HD004', 'SP012', 1, 85000.00),
('HD005', 'SP019', 1, 38000.00),
('HD006', 'SP005', 7, 693000.00),
('HD007', 'SP022', 1, 95000.00),
('HD008', 'SP017', 1, 115000.00),
('HD009', 'SP018', 2, 190000.00),
('HD009', 'SP020', 1, 42000.00),
('HD010', 'SP001', 1, 95000.00),
('HD010', 'SP014', 1, 130000.00),
('HD011', 'SP014', 1, 130000.00);

-- --------------------------------------------------------

--
-- Table structure for table `danhgia`
--

CREATE TABLE `danhgia` (
  `idKH` varchar(10) NOT NULL,
  `idSP` varchar(10) NOT NULL,
  `Star` int(1) DEFAULT NULL,
  `Comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `danhgia`
--

INSERT INTO `danhgia` (`idKH`, `idSP`, `Star`, `Comment`) VALUES
('KH001', 'SP001', 9, 'Chưa đọc sách nhưng web này bán sách đỉnh quá ae, nên mua sách ở đây.');

-- --------------------------------------------------------

--
-- Table structure for table `danhmuc`
--

CREATE TABLE `danhmuc` (
  `idDM` varchar(6) NOT NULL,
  `TenDM` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `danhmuc`
--

INSERT INTO `danhmuc` (`idDM`, `TenDM`) VALUES
('DM001', 'Tiểu thuyết'),
('DM002', 'Ngôn tình'),
('DM003', 'Văn học Nhật Bản'),
('DM004', 'Tự truyện'),
('DM005', 'Fantasy (Kỳ ảo)'),
('DM006', 'Văn học Việt Nam'),
('DM007', 'Văn học nước ngoài'),
('DM008', 'Truyện tranh'),
('DM009', 'Tâm lý - Kĩ năng sống'),
('DM010', 'Trinh thám'),
('DM011', 'Sách giáo khoa');

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `idKH` varchar(10) NOT NULL,
  `idSP` varchar(10) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `idHD` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `idKH` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TrangThai` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `DiaChiNhanHang` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `GhiChu` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `NgayTao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`idHD`, `idKH`, `TrangThai`, `DiaChiNhanHang`, `GhiChu`, `NgayTao`) VALUES
('HD001', 'KH002', '', 'hcm', 'haha', '2025-11-07 16:53:17'),
('HD002', 'KH002', 'Chờ xử lý', 'hcm', 'hahaha', '2025-11-07 17:11:46'),
('HD003', 'KH002', 'Chờ xử lý', 'shibal', 'huhuhihi', '2025-11-07 17:16:21'),
('HD004', 'KH002', 'Chờ xử lý', 'rwsfsv', 'ggd', '2025-11-07 17:21:25'),
('HD005', 'KH002', 'Chờ xử lý', 'x', 'xx', '2025-11-07 20:00:05'),
('HD006', 'KH002', 'Chờ xử lý', 'HYGH', '', '2025-11-07 20:05:27'),
('HD007', 'KH002', 'Chờ xử lý', 'qq', '', '2025-11-07 20:11:39'),
('HD008', 'KH032', 'Đã hủy', 'hcm', '', '2025-11-10 13:50:20'),
('HD009', 'KH032', 'Đã hủy', 'gvm', '', '2025-11-10 14:43:21'),
('HD010', 'KH032', 'Đã xác nhận', 'hcm', '0912345', '2025-11-15 15:28:20'),
('HD011', 'KH032', 'Đã xác nhận', 'hcm', '123', '2025-11-16 10:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `idKH` varchar(10) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `DienThoai` varchar(15) DEFAULT NULL,
  `MatKhau` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`idKH`, `HoTen`, `Email`, `DienThoai`, `MatKhau`) VALUES
('KH001', 'Hán', '12@gmail.com', '123', '202cb962ac59075b964b07152d234b70'),
('KH002', 'HânCB', '123@gmail.com', '1234', 'd9b1d7db4cd6e70935368a1efb10e377'),
('KH003', 'Đạt', 'c3@gmail.com', '90003', '2e1ddfa70558c14c0cb8fcb41c1d02e0'),
('KH004', 'Yến', 'd4@gmail.com', '90004', '1cfeb243f9a9e8c2e0955ad43d44fbd0'),
('KH005', 'Phát', 'e5@gmail.com', '90005', 'a50d4cc122e50ff7c3a27f8b1d75a1e3'),
('KH006', 'Tiến', 'f6@gmail.com', '90006', 'aab1a2b7e293b9b4a77f1e8d4a8e7a09'),
('KH007', 'Vy', 'g7@gmail.com', '90007', 'd24e5af7c4e91c12e4c4db8a2a182f7b'),
('KH008', 'Nhi', 'h8@gmail.com', '90008', '48e7baf80e8cb1b3a9d080ad13e7b9a0'),
('KH009', 'Nhung', 'i9@gmail.com', '90009', 'e7d93cc247efca5ee6a9de8dbf7214ce'),
('KH010', 'Hằng', 'j10@gmail.com', '90010', 'ea8e5ceba1e9a4b52fcb43a8ac85376e'),
('KH011', 'Duyên', 'k11@gmail.com', '90011', 'a70e5f67a7d17d34af9a804f4422f6b0'),
('KH012', 'Hoa', 'l12@gmail.com', '90012', 'c0cfb2db0534a24cdbf9b72a05bff9cb'),
('KH013', 'Tiên', 'm13@gmail.com', '90013', 'd7a67d8a03d1b6b364d3b2a2ccba87cb'),
('KH014', 'Trân', 'n14@gmail.com', '90014', 'f6f35c0e3f7e60d6dfb8c7b91b2f89cb'),
('KH015', 'Hoàng', 'o15@gmail.com', '90015', 'c0dc4ce2387e1b5e2b09eb9db7e63d2d'),
('KH016', 'Trung', 'p16@gmail.com', '90016', '7ad819f43a5c682f92c2d81a57a665df'),
('KH017', 'Bách', 'q17@gmail.com', '90017', 'd38bfb4d46f85c75875d6cbaef50d66a'),
('KH018', 'Phương', 'r18@gmail.com', '90018', '7ad492a3f1a7ff58f6bca796e7e3d0e2'),
('KH019', 'Hạ', 's19@gmail.com', '90019', '80a2b1a2a07e7f53cf7b1cebf302f4a9'),
('KH020', 'Thanh', 't20@gmail.com', '90020', '1e6d3f8dc3530e7ed65b20b7f3b5d99c'),
('KH021', 'Khoa', 'u21@gmail.com', '90021', 'ea53137ebc2af64b72a7f2dce2d606b1'),
('KH022', 'Quang', 'v22@gmail.com', '90022', '7ef601e8d85f17c4b24b1accc52c8e49'),
('KH023', 'Hào', 'w23@gmail.com', '90023', '519196c5f17a10a64f493e5f4a8d218a'),
('KH024', 'Hiếu', 'x24@gmail.com', '90024', '9e050b64a665b1cfb2a1541a68f458da'),
('KH025', 'Hiền', 'y25@gmail.com', '90025', 'a98e8e22105e5eb6a85e5a58f4d33b6a'),
('KH026', 'Bảo', 'z26@gmail.com', '90026', '9e32de35ebf55efcfb9c4482dd32d6b0'),
('KH027', 'Trâm', 'aa27@gmail.com', '90027', '4b3a3ce85af986240cd355a316bb2e91'),
('KH028', 'Trí', 'bb28@gmail.com', '90028', 'e493d01932a04b68b329a6dcbccfb53a'),
('KH029', 'Diễm', 'cc29@gmail.com', '90029', '6d47db7c2f2f78bcae2cf6b3198844c5'),
('KH031', 'Hân', '1234@gmail.com', '123', '202cb962ac59075b964b07152d234b70'),
('KH032', 'Hân', '1111@gmail.com', '123', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `phanhoi`
--

CREATE TABLE `phanhoi` (
  `idKH` varchar(10) NOT NULL,
  `idSP` varchar(10) NOT NULL,
  `PhanHoi` text DEFAULT NULL,
  `traloi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `idSP` varchar(6) NOT NULL,
  `idDM` varchar(6) DEFAULT NULL,
  `TenSP` varchar(150) NOT NULL,
  `Hang` varchar(100) DEFAULT NULL,
  `Soluong` int(11) NOT NULL DEFAULT 0,
  `Gia` decimal(10,2) DEFAULT NULL,
  `AnhSP` varchar(255) DEFAULT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`idSP`, `idDM`, `TenSP`, `Hang`, `Soluong`, `Gia`, `AnhSP`, `MoTa`) VALUES
('SP001', 'DM001', 'Ngôi Nhà Nghìn Hành Lang', 'NXB Trẻ', 9, 95000.00, '../biasach/ngoi nha nghin hanh lang.jpg', 'Tác giả: Neil Gaiman. Năm xuất bản: (phiên bản VN). Tiểu thuyết kỳ ảo kể về một chàng trai bước vào ngôi nhà chứa vô số hành lang và những bí mật thời gian. Tác phẩm kết hợp yếu tố cổ tích, hài hước và uẩn khúc, dẫn dắt người đọc qua những suy ngẫm về định mệnh, tình thân và ý nghĩa của hành trình tìm kiếm.'),
('SP002', 'DM002', 'Triều Du - Tập 1', 'NXB Hà Nội', 10, 90000.00, '../biasach/trieu du tap 1.jpg', 'Tác giả: (tập truyện ngôn tình). Năm xuất bản: (phiên bản VN). Tập 1 của bộ truyện nhẹ nhàng miêu tả mối quan hệ giữa các nhân vật trẻ trong bối cảnh xã hội hiện đại. Nội dung tập trung vào cảm xúc, xung đột nội tâm và quá trình trưởng thành, phù hợp cho độc giả yêu mến thể loại lãng mạn.'),
('SP003', 'DM003', 'Mộ Đom Đóm', 'NXB Kim Đồng', 10, 79000.00, '../biasach/mo dom dom.jpg', 'Tác giả: Akiyuki Nosaka. Năm xuất bản: 1967. Mộ Đom Đóm là tác phẩm đầy xúc động mô tả số phận hai đứa trẻ mồ côi trong thời chiến, phơi bày nỗi đau và nhân tính. Văn phong giản dị mà sâu sắc, tác phẩm để lại ấn tượng lâu dài về tình người và những hậu quả của chiến tranh.'),
('SP004', 'DM004', 'Một Lít Nước Mắt', 'NXB Hội Nhà Văn (Nhà Nam)', 10, 105000.00, '../biasach/mot lit nuoc mat.jpg', 'Tác giả: Kito Aya. Năm xuất bản: (phiên bản VN). Một Lít Nước Mắt kể lại nhật ký của cô gái trẻ đối diện với bệnh tật nghiêm trọng, từ những ngày đầu chẩn đoán đến hành trình tìm ý nghĩa cuộc sống. Sách mang thông điệp về nghị lực, hy vọng và tình thân, thường khiến độc giả cảm động sâu sắc.'),
('SP005', 'DM005', 'Bụi Sao', 'NXB Lao Động - Hà Nội', 10, 99000.00, '../biasach/bui sao.jpg', 'Tác giả: Neil Gaiman. Năm xuất bản: (phiên bản VN). Tác phẩm kỳ ảo với bối cảnh đan xen giữa hiện thực và huyền thoại, dẫn dắt độc giả vào những cuộc gặp gỡ kỳ lạ và những quyết định định mệnh. Nội dung giàu hình tượng, suy ngẫm về ước mơ, ký ức và bản sắc cá nhân.'),
('SP006', 'DM006', 'Chiếc Lược Ngà', 'NXB Văn Hóa - Văn Nghệ TP.HCM', 10, 75000.00, '../biasach/chiec luoc nga.jpg', 'Tác giả: Nguyễn Quang Sáng. Năm xuất bản: (phiên bản VN). Chiếc Lược Ngà là truyện ngắn nổi tiếng nói về tình cha con thời chiến, xúc động và đầy nhân văn. Ngôn từ cô đọng, hình ảnh đậm chất dân gian đã khiến tác phẩm trở thành một trong những kinh điển văn học Việt Nam.'),
('SP007', 'DM007', 'Ông Già Và Biển Cả', 'NXB Văn Học', 10, 88000.00, '../biasach/ong gia va bien ca.jpg', 'Tác giả: Ernest Hemingway. Năm xuất bản: 1952. Ông Già Và Biển Cả là câu chuyện về nghị lực, phẩm giá con người và cuộc chiến đấu không khoan nhượng với thiên nhiên. Qua hình tượng ông lão đánh cá, Hemingway bàn về lòng kiên trì, danh dự và ý nghĩa chiến thắng dù thất bại.'),
('SP008', 'DM006', 'Có Hai Con Mèo Ngồi Bên Cửa Sổ', 'NXB Trẻ', 10, 96000.00, '../biasach/co hai con meo ngoi ben cua so.jpg', 'Tác giả: Nguyễn Nhật Ánh. Năm xuất bản: (phiên bản VN). Tác phẩm nhẹ nhàng, ấm áp kể về những mẩu chuyện đời thường, tình bạn và những rung động tuổi trẻ. Phong cách giàu hình ảnh và hồn nhiên, phù hợp cho độc giả mọi lứa tuổi muốn tìm kiếm cảm xúc thanh thản.'),
('SP009', 'DM006', 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh', 'NXB Trẻ', 10, 105000.00, '../biasach/toi thay hoa vang tren co xanh.jpg', 'Tác giả: Nguyễn Nhật Ánh. Năm xuất bản: 2010. Một câu chuyện tuổi thơ đầy màu sắc, miêu tả ký ức, tình bạn và những giá trị tinh thần của tuổi nhỏ. Tác phẩm đưa người đọc về với cảm xúc trong veo, đồng thời phản ánh những thay đổi xã hội và nỗi lòng người lớn.'),
('SP010', 'DM007', 'Cây Cam Ngọt Của Tôi', 'NXB Hội Nhà Văn', 10, 99000.00, '../biasach/cay cam ngot cua toi.jpg', 'Tác giả: José Mauro de Vasconcelos. Năm xuất bản: 1968. Cây Cam Ngọt Của Tôi là tiểu thuyết đầy cảm xúc về tuổi thơ, tình bạn và nỗi niềm gia đình trong bối cảnh nghèo khó. Văn phong chân thật, giàu cảm xúc giúp độc giả đồng cảm sâu sắc với số phận nhân vật.'),
('SP011', 'DM008', 'Thanh Gươm Diệt Quỷ', 'NXB Kim Đồng', 10, 50000.00, '../biasach/thanh guom diet quy.jpg', 'Tác giả: Gotouge Koyoharu. Năm xuất bản: 2016. Manga hành động kể về Tanjiro và sứ mệnh cứu em gái khỏi lời nguyền, đồng thời chiến đấu với quỷ dữ. Truyện kết hợp pha hành động, cảm xúc gia đình và yếu tố siêu nhiên, thu hút độc giả trẻ.'),
('SP012', 'DM002', 'Em Là Niềm Kiêu Hãnh Của Anh', 'NXB Văn Học', 10, 85000.00, '../biasach/kieu hanh.jpg', 'Tác giả: Cố Mạn. Năm xuất bản: 2014. Em Là Niềm Kiêu Hãnh Của Anh là câu chuyện tình hiện đại, khai thác chủ đề tình yêu, danh vọng và lòng kiêu hãnh. Tác phẩm có nhịp kể chậm rãi, chú trọng nội tâm nhân vật và những khoảnh khắc gần gũi, đem lại trải nghiệm cảm động cho người đọc.'),
('SP013', 'DM009', 'Tư Duy Nhanh Và Chậm', 'NXB Lao Động', 10, 145000.00, '../biasach/tu duy nhanh cham.jpg', 'Tác giả: Daniel Kahneman. Năm xuất bản: 2011 (Phiên bản Việt). Quyển sách trình bày hai hệ thống tư duy của con người: nhanh và chậm, giải thích các thiên kiến nhận thức và ảnh hưởng của chúng tới quyết định. Nội dung giàu thí nghiệm, minh họa thực tế, rất hữu ích cho người làm kinh doanh, quản lý hoặc ai muốn hiểu hành vi con người.'),
('SP014', 'DM009', 'Sức Mạnh Của Thói Quen', 'NXB Lao Động – Xã Hội', 8, 130000.00, '../biasach/suc manh cua thoi quen.jpg', 'Tác giả: Charles Duhigg. Năm xuất bản: 2012. Sức Mạnh Của Thói Quen giải thích cơ chế hình thành thói quen và phương pháp thay đổi chúng để nâng cao hiệu suất và chất lượng sống. Tác phẩm kết hợp nghiên cứu khoa học và câu chuyện thực tế, cung cấp công cụ thực hành cho người đọc.'),
('SP015', 'DM009', 'Đi Tìm Lẽ Sống', 'NXB Tổng Hợp TP.HCM', 10, 115000.00, '../biasach/di tim le song.jpg', 'Tác giả: Viktor E. Frankl. Năm xuất bản: 1946. Đi Tìm Lẽ Sống là tác phẩm triết lý sinh tồn viết từ trải nghiệm tác giả trong trại tập trung, nói về ý nghĩa tồn tại và cách con người tìm thấy mục đích sống. Nội dung sâu sắc, giàu suy ngẫm, là nguồn cảm hứng tinh thần mạnh mẽ.'),
('SP016', 'DM010', 'Phía Sau Nghi Can X', 'NXB Trẻ', 10, 98000.00, '../biasach/phia sau nghi can x.jpg', 'Tác giả: Higashino Keigo. Năm xuất bản: 2005. Phía Sau Nghi Can X là tiểu thuyết trinh thám Nhật Bản với mạch truyện căng thẳng và cao trào bất ngờ. Tác phẩm khai thác chủ đề tội phạm, đạo đức và sự hy sinh, đồng thời khắc họa tâm lý nhân vật rất tinh tế.'),
('SP017', 'DM010', 'Sự Im Lặng Của Bầy Cừu', 'NXB Văn Học', 10, 115000.00, '../biasach/su im lang cua bay cuu.jpg', 'Tác giả: Thomas Harris. Năm xuất bản: 1988. Sự Im Lặng Của Bầy Cừu là tác phẩm trinh thám tâm lý nổi tiếng, giới thiệu nhân vật Hannibal Lecter và những màn đấu trí đầy ám ảnh. Nội dung kịch tính, vừa gây sợ hãi vừa khiến người đọc suy ngẫm về bản chất con người.'),
('SP018', 'DM010', 'Hỏa Ngục', 'NXB Lao Động', 10, 95000.00, '../biasach/hoa nguc.jpg', 'Tác giả: Dan Brown. Năm xuất bản: 2013 (phiên bản VN). Hỏa Ngục tiếp nối dòng trinh thám hiện đại kết hợp mật mã, lịch sử và nghệ thuật. Tác phẩm đặt ra câu hỏi đạo đức và trách nhiệm khoa học trong bối cảnh câu chuyện hồi hộp đầy tốc độ.'),
('SP019', 'DM011', 'Toán 12 – Kết nối tri thức', 'NXB Giáo Dục Việt Nam', 10, 38000.00, '../biasach/toan12_ketnoi.jpg', 'Tác giả: Bộ GD&ĐT (biên soạn). Năm xuất bản: 2022. Sách giáo khoa Toán 12 - Kết nối tri thức trình bày nội dung chương trình mới, kết hợp bài tập thực tế và hướng dẫn vận dụng. Thích hợp cho học sinh lớp 12 ôn tập và tham khảo khi chuẩn bị thi tốt nghiệp.'),
('SP020', 'DM011', 'Ngữ Văn 10 – Chân trời sáng tạo', 'NXB Giáo Dục Việt Nam', 10, 42000.00, '../biasach/ngu van10_chantroi.jpg', 'Tác giả: Bộ GD&ĐT (biên soạn). Năm xuất bản: 2022. Ngữ Văn 10 - Chân Trời Sáng Tạo cung cấp chương trình học hiện đại, chú trọng phát triển năng lực đọc hiểu và viết lập luận. Sách có phương pháp tiếp cận tích hợp, nhiều văn bản mẫu và bài tập thực hành.'),
('SP021', 'DM011', 'Tiếng Anh 6 – Global Success', 'NXB Giáo Dục Việt Nam', 10, 49000.00, '../biasach/tieng anh6_global.jpg', 'Tác giả: Bộ GD&ĐT (biên soạn). Năm xuất bản: 2022. Tiếng Anh 6 - Global Success là tài liệu tiếng Anh cơ bản dành cho học sinh, thiết kế theo chuẩn quốc tế để phát triển kỹ năng giao tiếp và ngữ pháp nền tảng. Bám sát chương trình, phù hợp cho môi trường học tập trường phổ thông.'),
('SP022', 'DM001', 'Không Gia Đình', 'NXB Kim Đồng', 10, 95000.00, '../biasach/khong gia dinh.jpg', 'Tác giả: Hector Malot. Năm xuất bản: 1878. Không Gia Đình là tiểu thuyết giàu tính nhân văn kể về hành trình cậu bé Rémi tìm kiếm gia đình và nhân phẩm. Tác phẩm đề cao lòng tốt, tình bạn và lòng kiên trì vượt qua khó khăn.'),
('SP023', 'DM001', 'Những Người Khốn Khổ', 'NXB Văn Học', 10, 120000.00, '../biasach/nhung nguoi khon kho.jpg', 'Tác giả: Victor Hugo. Năm xuất bản: 1862. Những Người Khốn Khổ mang đến bức tranh xã hội rộng lớn, khắc họa số phận con người trong bối cảnh công lý và lòng nhân đạo. Tác phẩm kết hợp sự bi kịch, hành trình chuộc lỗi và niềm hy vọng mạnh mẽ.'),
('SP024', 'DM001', 'Cuốn Theo Chiều Gió', 'NXB Phụ Nữ', 10, 135000.00, '../biasach/cuon theo chieu gio.jpg', 'Tác giả: Margaret Mitchell. Năm xuất bản: 1936. Cuốn Theo Chiều Gió là tiểu thuyết sử thi xoay quanh tình yêu, danh dự và những biến động thời chiến. Văn bản đồ sộ, giàu chi tiết, mang lại cái nhìn sâu về xã hội và số phận con người.'),
('SP025', 'DM002', 'Bên Nhau Trọn Đời', 'NXB Văn Học', 10, 85000.00, '../biasach/ben nhau tron doi.jpg', 'Tác giả: Cố Mạn. Năm xuất bản: 2005. Bên Nhau Trọn Đời là tiểu thuyết ngôn tình nổi tiếng mô tả mối tình bền bỉ qua năm tháng, với nhân vật có chiều sâu nội tâm. Cốt truyện giàu cảm xúc, hòa trộn yếu tố hài hước và day dứt.'),
('SP026', 'DM002', 'Mãi Mãi Là Bao Xa', 'NXB Dân Trí', 0, 92000.00, '../biasach/mai mai la bao xa.jpg', 'Tác giả: Diệp Lạc Vô Tâm. Năm xuất bản: 2012. Mãi Mãi Là Bao Xa là câu chuyện tình cảm đầy cảm xúc về khoảng cách, nhớ thương và sự hi sinh. Ngôn từ giàu cảm xúc, phù hợp độc giả yêu truyện lãng mạn hiện đại.'),
('SP027', 'DM002', 'Thiên Quan Tứ Phúc', 'NXB Văn Học', 0, 135000.00, '../biasach/thien quan tu phuc.jpg', 'Tác giả: Mặc Hương Đồng Khứu. Năm xuất bản: 2017. Thiên Quan Tứ Phúc là tiểu thuyết đam mỹ cổ trang với cốt truyện kiêm cả hài lẫn bi, chú trọng tình cảm thơ mộng và mạch truyện lôi cuốn. Tác phẩm được nhiều độc giả yêu thích và chuyển thể.'),
('SP028', 'DM007', 'Nhà Giả Kim', 'NXB Văn Học', 0, 96000.00, '../biasach/nha gia kim.jpg', 'Tác giả: Paulo Coelho. Năm xuất bản: 1988. Nhà Giả Kim kể về hành trình truy tìm kho báu của chàng chăn cừu Santiago, thông qua đó truyền tải bài học về ước mơ, định mệnh và giá trị trải nghiệm. Văn phong giản dị, triết lý sâu sắc, truyền cảm hứng cho nhiều thế hệ.'),
('SP029', 'DM007', 'Tiếng Chim Hót Trong Bụi Mận Gai', 'NXB Phụ Nữ', 0, 125000.00, '../biasach/tieng chim hot.jpg', 'Tác giả: Colleen McCullough. Năm xuất bản: 1977. Tiếng Chim Hót Trong Bụi Mận Gai là tiểu thuyết lãng mạn, đầy bi kịch và chiều sâu tâm lý, kể về những mối quan hệ phức tạp và hệ quả của chúng. Tác phẩm nổi bật ở cốt truyện dàn trải và nhân vật đa chiều.'),
('SP030', 'DM007', 'Sherlock Holmes', 'NXB Trẻ', 0, 110000.00, '../biasach/sherlock holmes.jpg', 'Tác giả: Arthur Conan Doyle. Năm xuất bản: cuối thế kỷ 19. Tuyển tập Sherlock Holmes tổng hợp các vụ án trứ danh của thám tử lừng danh, kết hợp trí tuệ, quan sát tỉ mỉ và phong cách kể chuyện độc đáo. Đây là nguồn cảm hứng lớn cho thể loại trinh thám hiện đại.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`DienThoai`);

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`idHD`,`idSP`),
  ADD KEY `idSP` (`idSP`);

--
-- Indexes for table `danhgia`
--
ALTER TABLE `danhgia`
  ADD KEY `idx_dg_idSP` (`idSP`),
  ADD KEY `idx_dg_idKH` (`idKH`);

--
-- Indexes for table `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`idDM`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`idKH`,`idSP`),
  ADD KEY `idKH` (`idKH`),
  ADD KEY `idSP` (`idSP`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`idHD`),
  ADD KEY `idKH` (`idKH`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`idKH`);

--
-- Indexes for table `phanhoi`
--
ALTER TABLE `phanhoi`
  ADD KEY `idx_ph_idKH` (`idKH`),
  ADD KEY `idx_ph_idSP` (`idSP`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`idSP`),
  ADD KEY `idx_sanpham_idDM` (`idDM`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
