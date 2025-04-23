<?php
include_once("../../model/mLoaiMonAn.php");

class CLoaiMonAN {
    public function getAllLoaiMonAn() {
        $p = new MLoaiMonAn();
        $tblSP = $p->SelectAllLoaiMonAn();
        
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
    
}
?>
