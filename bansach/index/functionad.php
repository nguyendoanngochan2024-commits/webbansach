<?php 
class admin {
    public $host = "localhost";
    public $user = "root";
    public $pass = "";
    public $dbname = "bansach";
    private $dbadmin;
    public function __construct() {
        $this->dbadmin = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        $this->dbadmin->set_charset("utf8");
    }
    function ensureSessionStarted() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }//hàm này để tránh bị trùng session_start()
    function TaoIDMoi($table, $prefix) {
        // Map prefix to table's ID column name
        $idColumnMap = [
            'SP' => 'idSP',
            'KH' => 'idKH',
            'DM' => 'idDM',
            'HD' => 'idHD'
        ]; 
        $idColumn = isset($idColumnMap[$prefix]) ? $idColumnMap[$prefix] : 'id' . $prefix;
        $sql = "SELECT $idColumn as id FROM $table WHERE $idColumn LIKE ? ORDER BY $idColumn DESC LIMIT 1";
        $pattern = $prefix . '%';
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) {
            $sql = "SELECT id FROM $table ORDER BY id DESC LIMIT 1";
            $result = $this->dbadmin->query($sql);
        } else {
            $stmt->bind_param("s", $pattern);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $col = key($row);
            $lastID = $row[$col];
            $num = intval(substr($lastID, strlen($prefix))) + 1;
            return $prefix . str_pad($num, 3, "0", STR_PAD_LEFT);
        }
        return $prefix . "001";
    }
    function KiemTraHopLe($chuoi) {
        if (preg_match("/[^a-zA-Z0-9@._]/", $chuoi)) {
            return false;
        }
        return true;
    }
        function LoginAdmin($dienthoai, $password) {
        if (!$this->KiemTraHopLe($dienthoai) || !$this->KiemTraHopLe($password)) {
            return "Email hoặc mật khẩu chứa ký tự đặc biệt!";
        }
        $sql = "SELECT * FROM ADMIN WHERE DienThoai='$dienthoai' AND MatKhau='$password'";
        $result = $this->dbadmin->query($sql);
        if ($result->num_rows > 0) {
            $this->ensureSessionStarted();
            $_SESSION['DienThoai'] = $dienthoai;
            return "Đăng nhập thành công!";
        } else {
            return "Sai số điện thoại hoặc mật khẩu!";
        }
    }
    function KiemTraDangNhapAdmin () {
        $this->ensureSessionStarted();
        return isset($_SESSION['DienThoai']);
    }
    function DangXuatAdmin() {
        $this->ensureSessionStarted();
        session_destroy();
        header("Location: Dangnhapadmin.php");
        exit();
    }
    // Products
    function LayTatCaSach() {
    $sql = " SELECT * FROM SANPHAM ORDER BY idSP ASC";
    $res = $this->dbadmin->query($sql);
    if (!$res) {
        die('SQL error: ' . $this->dbadmin->error);
    }
    $rows = [];
    while ($r = $res->fetch_assoc()) {
        $rows[] = $r;
    }
    return $rows;
}
    function ThemSach($idDM, $TenSP, $Gia, $Hang, $AnhSP) {
        $checkDM = $this->dbadmin->prepare("SELECT idDM FROM DANHMUC WHERE idDM = ?");
        if (!$checkDM) return "Lỗi: " . $this->dbadmin->error;
        $checkDM->bind_param("s", $idDM);
        $checkDM->execute();
        if ($checkDM->get_result()->num_rows === 0) {
            $checkDM->close();
            return "Danh mục không tồn tại";
        }
        $checkDM->close();

        $newIDsp = $this->TaoIDMoi("SANPHAM", "SP");
        
        $sql = "INSERT INTO SANPHAM (idSP, idDM, TenSP, Gia, Hang, AnhSP) VALUES (?,?,?,?,?,?)";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return "Lỗi: " . $this->dbadmin->error;

        $stmt->bind_param("sssdss", $newIDsp, $idDM, $TenSP, $Gia, $Hang, $AnhSP);
        $ok = $stmt->execute();
        $error = $stmt->error; 
        $stmt->close();
        return $ok ? true : "Lỗi: " . $error;
    }
    function CapNhatSach($idSP, $idDM, $TenSP, $Gia, $Hang, $AnhSP) {
        $sql = "UPDATE SANPHAM SET idDM=?, TenSP=?, Gia=?, Hang=?, AnhSP=? WHERE idSP=?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        // idDM(s), TenSP(s), Gia(d), Hang(s), AnhSP(s), idSP(s) => "ssdsss"
        $stmt->bind_param("ssdsss", $idDM, $TenSP, $Gia, $Hang, $AnhSP, $idSP);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function XoaSach($idSP) {
        $sql = "DELETE FROM SANPHAM WHERE idSP=?";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("s", $idSP);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function LayTatCaNguoiDung() {
        $sql = "SELECT idKH, HoTen, Email, DienThoai, MatKhau FROM khachhang ORDER BY idKH ASC";
        $res = $this->dbadmin->query($sql);
        $rows = [];
        if ($res) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        return $rows;
    }
    function ThemNguoiDung($HoTen, $Email, $DienThoai, $MatKhau) {
        $check = $this->dbadmin->prepare("SELECT idKH FROM khachhang WHERE Email = ?");
        $check->bind_param("s", $Email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $check->close();
            return "Email đã tồn tại";
        }
        $check->close();
        $newID = $this->TaoIDMoi("khachhang", "KH");
        $sql = "INSERT INTO khachhang (idKH, HoTen, Email, DienThoai, MatKhau) VALUES (?,?,?,?,?)";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return "Lỗi: " . $this->dbadmin->error;
        $stmt->bind_param("sssss", $newID, $HoTen, $Email, $DienThoai, $MatKhau);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : "Lỗi: " . $this->dbadmin->error;
    }
    function CapNhatNguoiDung($idKH, $HoTen, $Email, $DienThoai, $MatKhau) {
        $check = $this->dbadmin->prepare("SELECT idKH FROM khachhang WHERE Email = ? AND idKH != ?");
        $check->bind_param("ss", $Email, $idKH);
        $check->execute();
        $r = $check->get_result();
        if ($r && $r->num_rows > 0) { $check->close(); return "Email đã được sử dụng bởi người khác"; }
        $check->close();
        $sql = "UPDATE khachhang SET HoTen=?, Email=?, DienThoai=?, MatKhau=? WHERE idKH=?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        $stmt->bind_param("sssss", $HoTen, $Email, $DienThoai, $MatKhau, $idKH);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function XoaNguoiDung($idKH) {
        $sql = "DELETE FROM khachhang WHERE idKH = ?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        $stmt->bind_param("s", $idKH);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function TimKiemSachAdmin($keyword) {
        $like = '%' . $keyword . '%';
        $sql = "SELECT * FROM SANPHAM WHERE TenSP LIKE ? OR Hang LIKE ? OR idDM LIKE ? ORDER BY idSP ASC";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param("sss", $like, $like, $like);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($r = $res->fetch_assoc()) $rows[] = $r;
        $stmt->close();
        return $rows;
    }
    function TimKiemNguoiDung($keyword) {
        $like = '%' . $keyword . '%';
        $sql = "SELECT idKH, HoTen, Email, DienThoai, MatKhau FROM khachhang 
                WHERE HoTen LIKE ? OR Email LIKE ? OR DienThoai LIKE ? ORDER BY idKH ASC";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param("sss", $like, $like, $like);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        if ($res) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        $stmt->close();
        return $rows;
    }
    function initCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    }
    function LayTatCaHoaDon() {
        $sql = "SELECT h.*, k.HoTen, k.Email FROM hoadon h 
                JOIN khachhang k ON h.idKH = k.idKH ORDER BY h.NgayTao DESC";
        $res = $this->dbadmin->query($sql);
        $rows = [];
        if ($res) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        return $rows;
    }
    function TimKiemHoaDonAdmin($keyword) {
        $like = '%' . $keyword . '%';
        $sql = "SELECT h.*, k.HoTen, k.Email FROM hoadon h 
                JOIN khachhang k ON h.idKH = k.idKH 
                WHERE h.idHD LIKE ? OR k.HoTen LIKE ? OR k.Email LIKE ? 
                ORDER BY h.NgayTao DESC";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param("sss", $like, $like, $like);
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($r = $res->fetch_assoc()) $rows[] = $r;
        $stmt->close();
        return $rows;
    }
    function LayHoaDonById($idHD) {
        $sql = "SELECT h.*, k.HoTen, k.Email FROM hoadon h 
                JOIN khachhang k ON h.idKH = k.idKH WHERE h.idHD = ? LIMIT 1";
        $stmt = $this->dbadmin->prepare($sql);
        $stmt->bind_param("s", $idHD);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->num_rows > 0 ? $res->fetch_assoc() : null;
        $stmt->close();
        return $row;
    }
    function CapNhatTrangThaiHoaDon($idHD, $trangThai) {
        $sql = "UPDATE hoadon SET TrangThai = ? WHERE idHD = ?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        $stmt->bind_param("ss", $trangThai, $idHD);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function XoaHoaDon($idHD) {
        // Xóa chi tiết hóa đơn trước
        $sql = "DELETE FROM chitiethoadon WHERE idHD = ?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        $stmt->bind_param("s", $idHD);
        $stmt->execute();
        $stmt->close();
        // Xóa hóa đơn
        $sql = "DELETE FROM hoadon WHERE idHD = ?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        $stmt->bind_param("s", $idHD);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function LayTatCaDanhMuc() {
        $sql = "SELECT idDM, TenDM FROM DANHMUC ORDER BY idDM ASC";
        $res = $this->dbadmin->query($sql);
        $rows = [];
        if ($res) {
            while ($r = $res->fetch_assoc()) $rows[] = $r;
        }
        return $rows;
    }
    function ThemDanhMuc($TenDM) {
        $check = $this->dbadmin->prepare("SELECT idDM FROM DANHMUC WHERE TenDM = ?");
        $check->bind_param("s", $TenDM);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $check->close();
            return "Danh mục này đã tồn tại";
        }
        $check->close();
        $newID = $this->TaoIDMoi("DANHMUC", "DM");
        $sql = "INSERT INTO DANHMUC (idDM, TenDM) VALUES (?,?)";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return "Lỗi: " . $this->dbadmin->error;
        $stmt->bind_param("ss", $newID, $TenDM);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : "Lỗi: " . $this->dbadmin->error;
    }
    function CapNhatDanhMuc($idDM, $TenDM) {
        $check = $this->dbadmin->prepare("SELECT idDM FROM DANHMUC WHERE TenDM = ? AND idDM != ?");
        $check->bind_param("ss", $TenDM, $idDM);
        $check->execute();
        $r = $check->get_result();
        if ($r && $r->num_rows > 0) { 
            $check->close(); 
            return "Tên danh mục này đã được sử dụng"; 
        }
        $check->close();
        $sql = "UPDATE DANHMUC SET TenDM=? WHERE idDM=?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        $stmt->bind_param("ss", $TenDM, $idDM);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function XoaDanhMuc($idDM) {
        $check = $this->dbadmin->prepare("SELECT idSP FROM SANPHAM WHERE idDM = ?");
        $check->bind_param("s", $idDM);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $check->close();
            return "Không thể xóa danh mục này vì còn sản phẩm";
        }
        $check->close();
        $sql = "DELETE FROM DANHMUC WHERE idDM = ?";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return $this->dbadmin->error;
        $stmt->bind_param("s", $idDM);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok ? true : $this->dbadmin->error;
    }
    function TimKiemDanhMucAdmin($q) {
        $pattern = "%" . $q . "%";
        $sql = "SELECT idDM, TenDM FROM DANHMUC WHERE idDM LIKE ? OR TenDM LIKE ? ORDER BY idDM ASC";
        $stmt = $this->dbadmin->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param("ss", $pattern, $pattern);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($r = $result->fetch_assoc()) $rows[] = $r;
        $stmt->close();
        return $rows;
    }
}
?>