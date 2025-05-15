<?php
include_once("ketnoi.php");

class MLoaiMonAn {
    public function SelectAllLoaiMonAn() {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            $str = "SELECT * FROM loaimonan";
            $tblLoaiMonAN = $con->query($str);
            $p->dongKetNoi($con);
            return $tblLoaiMonAN;
        } else {
            return false; 
        }
    }   

    

}
?>
