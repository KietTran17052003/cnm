<?php
include_once("ketnoi.php");

class MBan {
    public function SelectAllBan() {
        $p = new ketnoi();
        $con = $p->connect();
    
        if ($con) {
            $str = "SELECT * FROM ban ";
            $result = $con->query($str);
            $p->dongKetNoi($con);
    
            if ($result->num_rows > 0) {
                $bans = array();
                while ($row = $result->fetch_assoc()) {
                    $bans[] = $row;
                }
                return $bans;
            } else {
                echo "Không có bàn nào được tìm thấy.";
                return false;
            }
        } else {
            return false;
        }
    }

    public function SelecBanByID($id) {
        $p = new ketnoi();
        $con = $p->connect();
    
        if ($con) {
            $str = "SELECT * FROM ban WHERE idban = ?";
            $stmt = $con->prepare($str);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $p->dongKetNoi($con);
    
            if ($result->num_rows > 0) {
                $bans = array();
                while ($row = $result->fetch_assoc()) {
                    $bans[] = $row;
                }
                return $bans;
            } else {
                echo "Không có bàn nào được tìm thấy.";
                return false;
            }
        } else {
            return false;
        }
    }

    public function sua($sql) {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            if ($con->query($sql) === TRUE) {
                $p->dongKetNoi($con);
                return true;
            } else {
                $p->dongKetNoi($con);
                return false;
            }
        } else {
            return false;
        }
    }

    public function them($sql) {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            if ($con->query($sql) === TRUE) {
                $p->dongKetNoi($con);
                return true;
            } else {
                $p->dongKetNoi($con);
                return false;
            }
        } else {
            return false;
        }
    }

    public function SelectAllSPbyName($trangthai) {
        $p = new ketnoi();
        $con = $p->connect();
        if ($con) {
            $str = "SELECT * FROM ban WHERE trangthai LIKE ?";
            $stmt = $con->prepare($str);
            $likeTrangThai = "%" . $trangthai . "%";
            $stmt->bind_param("s", $likeTrangThai);
            $stmt->execute();
            $result = $stmt->get_result();
            $p->dongKetNoi($con);
            return $result;
        } else {
            return false;
        }
    }

    public function SelectBanByViTri($vitri) {
        $p = new ketnoi();
        $con = $p->connect();
    
        if ($con) {
            $str = "SELECT * FROM ban WHERE vitri = ?";
            $stmt = $con->prepare($str);
            if ($stmt === false) {
                return false;
            }
    
            $stmt->bind_param("s", $vitri);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $bans = array();
                while ($row = $result->fetch_assoc()) {
                    $bans[] = $row;
                }
                return $bans;
            } else {
                return null;
            }
            
            $stmt->close();
            $p->dongKetNoi($con);
        } else {
            return false;
        }
    }
    
    public function getAllBan() {
        $p = new ketnoi();
        $con = $p->connect();

        if ($con) {
            $sql = "SELECT 
                        ban.*, 
                        nguoidung.hoten AS tenkhachhang, 
                        nguoidung.sdt AS sodienthoai 
                    FROM ban 
                    LEFT JOIN nguoidung ON ban.id_user = nguoidung.id_user";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $data = array();
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                $p->dongKetNoi($con);

                // Kiểm tra dữ liệu trả về

                return $data;
            } else {
                $p->dongKetNoi($con);
                return false;
            }
        } else {
            return false;
        }
    }
    public function themddb($sql) {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            if ($con->query($sql) === TRUE) {
                // Đóng kết nối sau khi thực hiện truy vấn thành công
                $p->dongKetNoi($con);
                return true;
            } else {
                // Đóng kết nối sau khi truy vấn không thành công
                $p->dongKetNoi($con);
                return false;
            }
        } else {
            return false;
        }
    }
}
?>