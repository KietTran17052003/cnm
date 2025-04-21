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
        $password = md5($password);
        $p = new MNguoiDung();
        $result = $p->dangnhap($email, $password);
        return $result;        
    }
}
?>
