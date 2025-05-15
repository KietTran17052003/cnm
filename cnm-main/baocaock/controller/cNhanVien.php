<?php 
    include_once("../../model/mNhanVien.php");
    class CNhanVien{
        public function getAllNV(){
            $p = new MNhanVien();
            $tblNV = $p->selectAllNV();
            if(!$tblNV){
                return -1;
            }else{
                if($tblNV->num_rows > 0){
                    return $tblNV;
                }else{
                    return 0; // không có dữ liệu trong bảng
                }
            }
        }

        // Lấy nhân viên theo mã
        public function getMaNV($id) {
            $p = new MNhanVien();
            $tblNV = $p->selectMaNV($id);

            if ($tblNV) {
                return $tblNV;
            } else {
                return null; // Không có nv với id đó
            }
        }

        // public function getNVwithChucVu($id) {
        //     $p = new MNhanVien();
        //     $tblNV = $p->SelectNVwithChucVu($id);

        //     if ($tblNV) {
        //         return $tblNV;
        //     } else {
        //         return null; // Không có nv với id đó
        //     }
        // }

        public function getAllNVbyName($sp){
            $p = new MNhanVien();
            // Xử lý SQL injection tại đây
         
            $tblNV= $p->SelectAllNVbyName($sp);
            if(!$tblNV){
                return -1;
            }else{
                if($tblNV->num_rows>0){
                    return $tblNV;
                }else{
                    return 0;// không có dòng dữ liệu
                }
            }
        }

        public function getSua($sql){
            $p = new MNhanVien();
            // Xử lý SQL injection tại đây
         
            $result= $p->sua($sql);
            if (!$result) {
                return -1;  // Lỗi khi cập nhật
            } else {
                return 1;  // Thành công
            }
        }
    }

?>