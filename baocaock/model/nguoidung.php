<?php
include_once("ketnoi.php");

class MNguoiDung {
    public function SelectAllND() {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            $str = "SELECT * FROM nguoidung";
            $tblND = $con->query($str);
            $p->dongKetNoi($con);
            return $tblND;
        } else {
            return false; 
        }
    } 

    public function dangnhap($tenTK, $password) {
        $p = new ketnoi();
        $con = $p->connect();
    
        if ($con) {
            $stmt = $con->prepare("SELECT id_user,hoten,gioitinh,email,sdt,id_role,trangthai
                       FROM nguoidung
                       WHERE email = ? AND password = ?");
            if (!$stmt) {
                die("Lỗi prepare: " . $con->error);  // Hiển thị lỗi cụ thể
            }

            $stmt->bind_param("ss", $tenTK, $password);
            $stmt->execute();
    
            // Gắn kết các cột kết quả vào biến
            $stmt->bind_result($id_user, $hoten,$gioitinh,$email,$sdt,$id_role,$trangthai);
    
            if ($stmt->fetch()) {
                $_SESSION["dangnhap"] = array(
                    "id_user" => $id_user,
                    "hoten" => $hoten,
                    "id_role" => $id_role
                );
    
                $stmt->close();
                $p->dongKetNoi($con);
                return $_SESSION["dangnhap"];
            } else {
                $stmt->close();
                $p->dongKetNoi($con);
                return 0;
            }
        } else {
            return false;
        }
    }
    
    
    
}
?>
