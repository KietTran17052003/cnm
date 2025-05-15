<?php
include_once("ketnoi.php");

class MNhanVien {
    public function SelectAllNV() {
        $p = new ketnoi();
        $con = $p->connect();
        $con->set_charset('utf8');
        if ($con) {
            $str = "SELECT nguoidung.id_user, nguoidung.hoten, nguoidung.gioitinh, vaitro.tenvaitro, nguoidung.email, nguoidung.sdt, nguoidung.trangthai
                 FROM nguoidung
                 LEFT JOIN vaitro ON nguoidung.id_role = vaitro.id_role
                 WHERE nguoidung.id_role IN (1, 2, 3)";
            $tblNV = $con->query($str);
            $p->dongketnoi($con);
            return $tblNV;
        } else {
            return false;
        }
    }

    public function SelectMaNV($id) {
        $p = new ketnoi();
        $con = $p->connect();
        $con->set_charset('utf8');
        if ($con) {
            $str = "SELECT * FROM nguoidung WHERE id_user = ?";
            $stmt = $con->prepare($str);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($id_user, $hoten, $gioitinh, $email, $sdt, $id_role, $password, $trangthai);
            if ($stmt->fetch()) {
                $nv = array(
                    "id_user" => $id_user,
                    "hoten" => $hoten,
                    "gioitinh" => $gioitinh,
                    "email" => $email,
                    "sdt" => $sdt,
                    "id_role" => $id_role,
                    "password" => $password,
                    "trangthai" => $trangthai
                );
                $stmt->close();
                $p->dongketnoi($con);
                return $nv;
            } else {
                $stmt->close();
                $p->dongketnoi($con);
                return false;
            }
        } else {
            return false;
        }
    }

    public function SelectAllNVbyName($nhanvien) {
        $p = new ketnoi();
        $con = $p->connect();
        if ($con) {
            $nhanvien = $con->real_escape_string($nhanvien);
            $str = "SELECT nguoidung.id_user, nguoidung.hoten, nguoidung.gioitinh, vaitro.tenvaitro, nguoidung.email, nguoidung.sdt, nguoidung.trangthai "
                 . "FROM nguoidung "
                 . "LEFT JOIN vaitro ON nguoidung.id_role = vaitro.id_role "
                 . "WHERE nguoidung.hoten LIKE N'%$nhanvien%'";
            $tblNV = $con->query($str);
            $p->dongketnoi($con);
            return $tblNV;
        } else {
            return false;
        }
    }

    public function checkPhoneExists($phone) {
        $p = new ketnoi();
        $con = $p->connect();
        $con->set_charset('utf8');
        if ($con) {
            $query = "SELECT COUNT(*) FROM nguoidung WHERE sdt = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            $p->dongketnoi($con);
            return $count > 0;
        } else {
            return false;
        }
    }

    public function checkEmailExists($email) {
        $p = new ketnoi();
        $con = $p->connect();
        $con->set_charset('utf8');
        if ($con) {
            $query = "SELECT COUNT(*) FROM nguoidung WHERE email = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            $p->dongketnoi($con);
            return $count > 0;
        } else {
            return false;
        }
    }

    public function getLastInsertId() {
        $p = new ketnoi();
        $con = $p->connect();
        $insertId = $con->insert_id;
        $p->dongketnoi($con);
        return $insertId;
    }

    public function checkExist($sql) {
        $p = new ketnoi();
        $con = $p->connect();
        $result = $con->query($sql);
        $p->dongketnoi($con);
        return $result->num_rows > 0;
    }

    public function addNV($name, $gender, $email, $phone, $idrole, $password, $trangthai) {
        $p = new ketnoi();
        $con = $p->connect();
        $con->set_charset('utf8');
        if ($con) {
            $sql = "INSERT INTO nguoidung (hoten, gioitinh, email, sdt, id_role, password, trangthai) "
                 . "VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sissssi", $name, $gender, $email, $phone, $idrole, $password, $trangthai);
            if ($stmt->execute()) {
                $insertId = $con->insert_id;
                $stmt->close();
                $p->dongketnoi($con);
                return $insertId;
            } else {
                error_log("Lỗi: " . $stmt->error);
                $stmt->close();
                $p->dongketnoi($con);
                return false;
            }
        } else {
            error_log("Không thể kết nối tới cơ sở dữ liệu");
            return false;
        }
    }

    // UPDATE Nhan vien
    public function suaNV($sql) {
        $p = new ketnoi();
        $con = $p->connect();
        $con->set_charset('utf8');
        if ($con) {
            if ($con->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
            $p->dongketnoi($con);
        } else {
            return false;
        }
    }

}
?>
