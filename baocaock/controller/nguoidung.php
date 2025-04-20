<?php
include_once("../../model/nguoidung.php");

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

    public function dangnhaptaikhoan($username, $password) {
        //$password = md5($password); 
        $p = new MNguoiDung();
   
        $result = $p->dangnhap($username, $password);
        if ($result) {
            $_SESSION["dangnhap"] = $result;
            header("Location: ../index.php?page=home");

        } else {
            return 0;
        }
    }
}
?>
