<?php 
    include_once("../../model/mKhachHang.php");

    class CKhachHang{
        public function getAllKH(){
            $p = new MKhachHang();
            $tblKH = $p->selectAllKH();
            if(!$tblKH){
                return -1;
            }else{
                if($tblKH->num_rows > 0){
                    return $tblKH;
                }else{
                    return 0; // không có dữ liệu trong bảng
                }
            }
        }

        // Lấy nhân viên theo mã
        public function getMaKH($id) {
            $p = new MKhachHang();
            $tblKH = $p->selectMaKH($id);

            if ($tblKH) {
                return $tblKH;
            } else {
                return null; // Không có nv với id đó
            }
        }

        public function getAllNVbyName($sp){
            $p = new MKhachHang();
            // Xử lý SQL injection tại đây
         
            $tblKH= $p->SelectAllNVbyName($sp);
            if(!$tblKH){
                return -1;
            }else{
                if($tblKH->num_rows>0){
                    return $tblKH;
                }else{
                    return 0;// không có dòng dữ liệu
                }
            }
        }
    }

?>