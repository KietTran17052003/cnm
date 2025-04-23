<?php
include_once("ketnoi.php");
class MKhachHang{
    public function SelectAllKH(){
        $p = new ketnoi();  
        $con = $p->connect();
        $con->set_charset('utf8');
        if($con){
            $str = "SELECT nguoidung.id_user, nguoidung.hoten, nguoidung.gioitinh, nguoidung.email, nguoidung.sdt, nguoidung.trangthai 
            FROM nguoidung
            WHERE nguoidung.id_role IN (4)";
    
            $tblKH = $con->query($str);
            $p->dongketnoi($con);
            return $tblKH;
        }else{
            return false; //không thể kết nối csdl
        }
    }

    // Lấy một KH theo id
    public function SelectMaKH($id) {
        $p = new ketnoi();
        $con = $p->connect();
        $con->set_charset('utf8');
        if ($con) {
            $str = "SELECT * FROM nguoidung WHERE id_user = ?";
            $stmt = $con->prepare($str);
            $stmt->bind_param("i", $id); // Sử dụng prepared statement để bảo vệ khỏi SQL Injection
            $stmt->execute();
            $result = $stmt->get_result();
            $p->dongketnoi($con);

            if ($result->num_rows > 0) {
                return $result->fetch_assoc(); // Trả về 1 dòng kết quả
            } else {
                return false; // Không tìm thấy nv với id đó
            }
        } else {
            return false; // Không thể kết nối đến CSDL
        }
    }

    //Tim kiem nhan vien theo ten
    public function SelectAllNVbyName($khachhang){
        $p= new ketnoi();
        $con= $p->connect();
        if($con){
            
            $str = "SELECT nguoidung.id_user, nguoidung.hoten, nguoidung.gioitinh, vaitro.tenvaitro, nguoidung.email, nguoidung.sdt, nguoidung.trangthai 
            FROM nguoidung
            LEFT JOIN vaitro ON nguoidung.id_role = vaitro.id_role
            WHERE nguoidung.hoten like N'%$khachhang%'";
            $tblKH= $con->query($str);
            $p->dongketnoi($con);
            return $tblKH;
        }
        else{
            return false; // không thể kết nối đến csdl
        }
    }
}
?>