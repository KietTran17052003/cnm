<?php
include_once("../../model/mnguoidung.php");

class CNguoiDung {
    public function getAllND() {
        $p = new MNguoiDung();
        $tblSP = $p->SelectAllND();
        
        if (!$tblSP) {
            return -1; 
        } else {
            if ($tblSP->num_rows > 0) {
                return $tblSP; 
            } else { 
                return 0; 
            }
        }
    }

    public function dangnhaptaikhoan($email, $password) {
        $password = md5($password); // vì trong DB đang lưu dưới dạng md5
        $p = new MNguoiDung();
        $result = $p->dangnhap($email, $password);
        return $result;
    }
    public function dangkytk($sql){
        $p = new MNguoiDung();
        // Xử lý SQL injection tại đây
     
        $result= $p->dangky($sql);
        if (!$result) {
            return -1;  // Lỗi khi cập nhật
        } else {
            return 1;  // Thành công
        }
    }

    public function kiemtraEmail($email) {
        $p = new MNguoiDung();
        return $p->kiemtraEmail($email);
    }
}
?>
