
<?php
include_once("../../model/mVaiTro.php");

class CVaiTro {
    public function getVaiTroForNhanVien() {
        $p = new MVaiTro();
        $tblCV = $p->selectVaiTroForNhanVien();
        if (!$tblCV) {
                    return -1; 
                } else {
                    if ($tblCV->num_rows > 0) {
                        return $tblCV; 
                    } else { 
                        return 0; 
                    }
                }

    }
    
    
}
?>
