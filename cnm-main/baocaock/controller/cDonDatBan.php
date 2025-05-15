<?php 
    include_once("../../model/mDonDatBan.php");

    class CDonDatBan{
        public function getAllDon(){
            $p = new MDonDatBan();
            $tblDon = $p->selectAllDon();
            if(!$tblDon){
                return -1;
            }else{
                if($tblDon->num_rows > 0){
                    return $tblDon;
                }else{
                    return 0; // không có dữ liệu trong bảng
                }
            }
        }

        
        public function getMaDon($id) {
            $p = new MDonDatBan();
            $tblDon = $p->selectMaDon($id);

            if ($tblDon) {
                return $tblDon;
            } else {
                return null; 
            }
        }
    }

?>