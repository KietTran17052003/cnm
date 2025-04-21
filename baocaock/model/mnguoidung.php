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
}
?>
