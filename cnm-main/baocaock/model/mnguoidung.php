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

    public function dangnhap($email, $password) {
        $p = new ketnoi();
        $con = $p->connect();

        if ($con) {
            $stmt = $con->prepare("SELECT id_user, hoten, gioitinh, email, sdt, id_role, trangthai 
                                   FROM nguoidung 
                                   WHERE email = ? AND password = ?");
            if (!$stmt) {
                die("Lỗi prepare: " . $con->error);
            }

            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $stmt->bind_result($uid, $hoten, $gioitinh, $emailResult, $sdt, $id_role, $trangthai);

            if ($stmt->fetch()) {
                $stmt->close();
                $p->dongKetNoi($con);

                return array(
                    "id_user" => $uid,
                    "hoten" => $hoten,
                    "gioitinh" => $gioitinh,
                    "email" => $emailResult,
                    "sdt" => $sdt,
                    "id_role" => $id_role,
                    "trangthai" => $trangthai
                );
            } else {
                $stmt->close();
                $p->dongKetNoi($con);
                return 0;
            }
        } else {
            return false;
        }
    }
    public function dangky($sql) {
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

    public function kiemtraEmail($email) {
        $p = new ketnoi();
        $con = $p->connect();

        if ($con) {
            $stmt = $con->prepare("SELECT email FROM nguoidung WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                return true; // Email đã tồn tại
            } else {
                return false; // Email chưa tồn tại
            }
        } else {
            return false; // Lỗi kết nối
        }
    }
}
?>

