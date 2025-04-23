<?php
include_once("ketnoi.php");

class MVaiTro {
    public function selectVaiTroForNhanVien() {
        $p = new ketnoi();
        $con = $p->connect();
        

        if ($con) {
            $str = "SELECT * FROM vaitro";
            $tblCV = $con->query($str);
            $p->dongketnoi($con);
            return $tblCV;
        } else {
            return false; 
        }
    }
    
    
}
?>
