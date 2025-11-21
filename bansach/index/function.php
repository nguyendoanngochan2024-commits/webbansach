<?php
class khachhang {
    public $host = "localhost";
    public $user = "root"; 
    public $pass = "";
    public $dbname = "bansach"; 
    private $db;
    public function __construct() {
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
       $this->db->set_charset("utf8");
    }
        function ensureSessionStarted() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    } //hàm này để tránh bị trùng session_start()
    function KiemTraHopLe($chuoi) {
        if (preg_match("/[^a-zA-Z0-9@._]/", $chuoi)) {
            return false;
        }
        return true;
    } //hàm này sẽ kiểm tra chuỗi có ký tự đặc biệt không
    function DangKy($HoTen, $Email, $DienThoai, $MatKhau) {
        if (!$this->KiemTraHopLe($Email) || !$this->KiemTraHopLe($MatKhau)) {
            return "Email hoặc mật khẩu chứa ký tự đặc biệt!";
        }
        // Kiểm tra trùng Email
        $check = $this->db->query("SELECT * FROM KHACHHANG WHERE Email='$Email'");
        if ($check->num_rows > 0) {
            return "Email đã tồn tại!";
        }
        $result = $this->db->query("SELECT idKH FROM KHACHHANG ORDER BY idKH DESC LIMIT 1");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastID = $row['idKH']; 
        $num = intval(substr($lastID, 2)) + 1; 
        $newID = "KH" . str_pad($num, 3, "0", STR_PAD_LEFT); 
    } else {
        $newID = "KH001"; 
    } //giúp tạo mã khách hàng dạng KH001, KH002,...
        $sql = "INSERT INTO KHACHHANG (idKH, Hoten, Email, DienThoai, MatKhau)
                VALUES ('$newID', '$HoTen', '$Email', '$DienThoai', '$MatKhau')";
        if ($this->db->query($sql)) {
            return "Đăng ký thành công!";
        } else {
            return "Lỗi đăng ký: " . $this->db->error;
        } 
    }
     function DangNhap($Email, $MatKhau, $remember = false) {
        if (!$this->KiemTraHopLe($Email) || !$this->KiemTraHopLe($MatKhau)) {
            return "Email hoặc mật khẩu chứa ký tự đặc biệt!";
        }
        $sql = "SELECT * FROM KHACHHANG WHERE Email='$Email' AND MatKhau='$MatKhau'";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
            $this->ensureSessionStarted();
            $row = $result->fetch_assoc();
            $_SESSION['Email'] = $Email;
            $_SESSION['HoTen'] = $row['HoTen'];
            if ($remember) {
            setcookie("email", "", time() +60*60);
            setcookie("hoten", "", time() +60*60);
            }
            return "Đăng nhập thành công!";
        } else {
            return "Sai Email hoặc mật khẩu!";
        }
    }
    function LayThongTinKH($Email) {
        $sql = "SELECT * FROM KHACHHANG WHERE Email='$Email'";
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
         return $result->fetch_assoc();
        }
    return null;
    }
    function CapNhatThongTinKH($HoTen, $DienThoai, $MatKhau) {
       // Kiểm tra có bị bỏ trống không
            $thongtin = $this->LayThongTinKH($_SESSION['Email']);
            if (empty($HoTen)) { $HoTen = $thongtin['HoTen'];}
            if (empty($MatKhau)) { $MatKhau = $thongtin['MatKhau'];} 
            if (empty($DienThoai)) {$DienThoai = $thongtin['DienThoai'];}
    // Kiểm tra ký tự đặc biệt
        if (!$this->KiemTraHopLe($MatKhau)) {
        return "Mật khẩu chứa ký tự không hợp lệ!";
        }
    // Cập nhật thông tin
        $sql = "UPDATE KHACHHANG 
                SET HoTen = '$HoTen',
                DienThoai = '$DienThoai',
                MatKhau = '$MatKhau'
                WHERE Email = '$_SESSION[Email]'";
        if ($this->db->query($sql)) {
        return "Cập nhật thông tin thành công!";
        } else {
        return "Lỗi khi cập nhật: " . $this->db->error;
        }
    }
    function LayTatCaHang() {
        $sql = "SELECT DISTINCT Hang FROM sanpham WHERE Hang IS NOT NULL ORDER BY Hang";
        $result = $this->db->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row['Hang'];
            }
        }
        return $data;
    }
    function LayDanhSachSanPham($idDM = null, $selectedBrands = null, $minPrice = null, $maxPrice = null) {
        $conditions = [];
        $params = [];
        if ($idDM != null && $idDM != "") {
            $conditions[] = "s.idDM = ?";
            $params[] = $idDM;
        }
        if (!empty($selectedBrands) && is_array($selectedBrands)) {
            $placeholders = str_repeat('?,', count($selectedBrands) - 1) . '?';
            $conditions[] = "s.Hang IN ($placeholders)";
            $params = array_merge($params, $selectedBrands);
        }
        if ($minPrice !== null && $minPrice !== '') {
            $conditions[] = "s.Gia >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice !== null && $maxPrice !== '') {
            $conditions[] = "s.Gia <= ?";
            $params[] = $maxPrice;
        }
        $sql = "SELECT s.*, d.TenDM 
                FROM sanpham s 
                LEFT JOIN danhmuc d ON s.idDM = d.idDM";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $sql .= " ORDER BY s.TenSP";
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    // Lấy chi tiết một sản phẩm theo idSP
    function LaySanPhamTheoID($idSP) {
        $sql = "SELECT s.*, d.TenDM FROM sanpham s LEFT JOIN danhmuc d ON s.idDM = d.idDM WHERE s.idSP = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param('s', $idSP);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            return $res->fetch_assoc();
        }
        return null;
    }
    function LayDanhMuc() {
        $sql = "SELECT d.idDM, d.TenDM, COUNT(s.idSP) as SoLuong 
                FROM danhmuc d 
                LEFT JOIN sanpham s ON d.idDM = s.idDM 
                GROUP BY d.idDM, d.TenDM 
                ORDER BY d.TenDM";
        $result = $this->db->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
    function ThemVaoGioHang($idSP) {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['Email'])) {
            return "Vui lòng đăng nhập để thêm vào giỏ hàng";
        }
        $email = $_SESSION['Email'];
        $sql = "SELECT idKH FROM khachhang WHERE Email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return "Không tìm thấy thông tin khách hàng";
        }
        $idKH = $result->fetch_assoc()['idKH'];
        // Nếu đã có thì +1, nếu không thì insert mới
        $sql = "INSERT INTO giohang (idKH, idSP, SoLuong) VALUES (?, ?, 1) 
                ON DUPLICATE KEY UPDATE SoLuong = SoLuong + 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $idKH, $idSP);
        return $stmt->execute() ? "Đã thêm vào giỏ hàng" : "Lỗi: " . $this->db->error;
    }
    function LayGioHang() {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['Email'])) return [];
        $email = $_SESSION['Email'];
        $sql = "SELECT g.*, s.TenSP, s.Gia, s.AnhSP
                FROM giohang g
                JOIN sanpham s ON g.idSP = s.idSP
                WHERE g.idKH = (SELECT idKH FROM khachhang WHERE Email = ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $items = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    function CapNhatSoLuong($idSP, $soluong) {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['Email'])) return "Vui lòng đăng nhập";
        $email = $_SESSION['Email'];
        if ($soluong > 0) {
            $sql = "UPDATE giohang SET SoLuong = ? 
                    WHERE idKH = (SELECT idKH FROM khachhang WHERE Email = ?) AND idSP = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("iss", $soluong, $email, $idSP);
        } else {
            $sql = "DELETE FROM giohang 
                    WHERE idKH = (SELECT idKH FROM khachhang WHERE Email = ?) AND idSP = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ss", $email, $idSP);
        }
        return $stmt->execute() ? "Cập nhật thành công" : "Lỗi: " . $this->db->error;
    }
    function KiemTraDangNhap () {
        $this->ensureSessionStarted();
        return isset($_SESSION['Email']);
    }
    // Tạo mã hóa đơn mới
    private function TaoMaHoaDon() {
        $result = $this->db->query("SELECT idHD FROM hoadon ORDER BY idHD DESC LIMIT 1");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastID = $row['idHD'];
            $num = intval(substr($lastID, 2)) + 1;
            return "HD" . str_pad($num, 3, "0", STR_PAD_LEFT);
        }
        return "HD001";
    }
    function TaoHoaDon($diaChi, $ghiChu = '') {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['Email'])) {
            return "Vui lòng đăng nhập để thanh toán";
        }
        $email = $_SESSION['Email'];
        $stmt = $this->db->prepare("SELECT idKH FROM khachhang WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return "Không tìm thấy thông tin khách hàng";
        }
        $idKH = $result->fetch_assoc()['idKH'];
        $gioHang = $this->LayGioHang();
        if (empty($gioHang)) {
            return "Giỏ hàng trống";
        }
        $this->db->begin_transaction();
        try {
            // Kiểm tra tồn kho cho từng sản phẩm
            $checkStmt = $this->db->prepare("SELECT SoLuong, TenSP FROM sanpham WHERE idSP = ? FOR UPDATE");
            foreach ($gioHang as $item) {
                $checkStmt->bind_param('s', $item['idSP']);
                $checkStmt->execute();
                $res = $checkStmt->get_result();
                if ($res->num_rows === 0) {
                    throw new Exception("Không tìm thấy sản phẩm: " . $item['idSP']);
                }
                $row = $res->fetch_assoc();
                $available = intval($row['SoLuong']);
                $tenSP = $row['TenSP'];
                $requested = intval($item['SoLuong']);
                if ($available <= 0) {
                    throw new Exception("Sản phẩm '$tenSP' đã hết hàng.");
                }
                if ($requested > $available) {
                    throw new Exception("Sản phẩm '$tenSP' không đủ hàng (còn $available).");
                }
            }
            // Tạo hóa đơn
            $idHD = $this->TaoMaHoaDon();
            $trangThai = "Chờ xử lý";
            $sql = "INSERT INTO hoadon (idHD, idKH, TrangThai, DiaChiNhanHang, GhiChu) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssss", $idHD, $idKH, $trangThai, $diaChi, $ghiChu);
            if (!$stmt->execute()) throw new Exception("Lỗi tạo hóa đơn");
            // Thêm chi tiết hóa đơn và trừ tồn kho
            $insertStmt = $this->db->prepare("INSERT INTO chitiethoadon (idHD, idSP, SoLuong, Gia) VALUES (?, ?, ?, ?)");
            $updateStockStmt = $this->db->prepare("UPDATE sanpham SET SoLuong = SoLuong - ? WHERE idSP = ?");
            foreach ($gioHang as $item) {
                $qty = intval($item['SoLuong']);
                $thanhTien = $item['Gia'] * $qty;
                $insertStmt->bind_param("ssid", $idHD, $item['idSP'], $qty, $thanhTien);
                if (!$insertStmt->execute()) throw new Exception("Lỗi thêm chi tiết hóa đơn");
                $updateStockStmt->bind_param("is", $qty, $item['idSP']);
                if (!$updateStockStmt->execute()) throw new Exception("Lỗi cập nhật tồn kho");
            }
            // Xóa giỏ hàng
            $stmt = $this->db->prepare("DELETE FROM giohang WHERE idKH = ?");
            $stmt->bind_param("s", $idKH);
            if (!$stmt->execute()) throw new Exception("Lỗi xóa giỏ hàng");
            $this->db->commit();
            return "Đặt hàng thành công! Mã đơn hàng của bạn là: " . $idHD;
        } catch (Exception $e) {
            $this->db->rollback();
            return "Lỗi: " . $e->getMessage();
        }
    }
    function HuyHoaDon($idHD) {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['Email'])) return "Vui lòng đăng nhập";
        $hd = $this->LayHoaDonById($idHD);
        if (!$hd) return "Không tìm thấy hóa đơn.";
        $kh = $this->LayThongTinKH($_SESSION['Email']);
        if (!$kh || $kh['idKH'] !== $hd['idKH']) return "Bạn không có quyền hủy đơn này.";
        if ($hd['TrangThai'] === 'Đã hủy') return "Đơn hàng đã hủy trước đó.";
        $this->db->begin_transaction();
        try {
            $items = $this->LayChiTietHoaDon($idHD);
            // Trả lại tồn kho
            $updateStock = $this->db->prepare("UPDATE sanpham SET SoLuong = SoLuong + ? WHERE idSP = ?");
            foreach ($items as $it) {
                $qty = intval($it['SoLuong']);
                $updateStock->bind_param('is', $qty, $it['idSP']);
                if (!$updateStock->execute()) throw new Exception("Lỗi trả tồn kho sản phẩm " . $it['idSP']);
            }
            // Cập nhật trạng thái
            $stmt = $this->db->prepare("UPDATE hoadon SET TrangThai = 'Đã hủy' WHERE idHD = ?");
            $stmt->bind_param('s', $idHD);
            if (!$stmt->execute()) throw new Exception("Lỗi cập nhật trạng thái");
            $this->db->commit();
            return "Hủy đơn thành công.";
        } catch (Exception $e) {
            $this->db->rollback();
            return "Lỗi: " . $e->getMessage();
        }
    }
    // Lấy danh sách hóa đơn của khách hàng
    function LayHoaDonTheoKH($idKH) {
        $sql = "SELECT * FROM hoadon WHERE idKH = ? ORDER BY NgayTao DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $idKH);
        $stmt->execute();
        $res = $stmt->get_result();
        $data = [];
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    // Lấy thông tin hóa đơn theo idHD
    function LayHoaDonById($idHD) {
        $sql = "SELECT * FROM hoadon WHERE idHD = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $idHD);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) return $res->fetch_assoc();
        return null;
    }
    // Lấy chi tiết hóa đơn (các dòng) theo idHD
    function LayChiTietHoaDon($idHD) {
        $sql = "SELECT c.*, s.TenSP, s.AnhSP FROM chitiethoadon c LEFT JOIN sanpham s ON c.idSP = s.idSP WHERE c.idHD = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $idHD);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    function DangXuat() {
        $this->ensureSessionStarted();
        if (isset($_COOKIE['email'])) {
            setcookie("email", "", time() - 1);
            setcookie("hoten", "", time() - 1);
        }
        session_destroy();
        header ('location: Trangchu.php');
    }
}
?>