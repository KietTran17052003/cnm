<?php
include_once("../../model/mMonAn.php");

class CMonAN {
    public function getAllMonAN() {
        $p = new MMonAn();
        $tblSP = $p->SelectAllMonAn();
        // mysql_query("set names utf8");
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

    // Lấy món ăn theo mã
    public function getMaMonAn($id) {
        $p = new MMonAn();
        $tblMonAn = $p->SelectMaMonAn($id);

        if ($tblMonAn) {
            return $tblMonAn; // Trả về mảng món ăn
        } else {
            return null; // Không có món ăn với id đó
        }
    }

    // Cập nhật món ăn
    // public function getUpdateMonAn($maMonAn, $tenMonAn, $maLoaiMonAn, $giaBan, $moTa, $tinhTrang, $hinhAnh) {
    //     $p = new MMonAn();
    //     $result = $p->updateMonAn($maMonAn, $tenMonAn, $maLoaiMonAn, $giaBan, $moTa, $tinhTrang, $hinhAnh);
        
    //     if (!$result) {
    //         return -1;  // Lỗi khi cập nhật
    //     } else {
    //         return 1;  // Thành công
    //     }
    // }
    
    
    
    public function getAllSPbyName($sp){
        $p = new MMonAn();
        // Xử lý SQL injection tại đây
     
        $tblSP= $p->SelectAllSPbyName($sp);
        if(!$tblSP){
            return -1;
        }else{
            if($tblSP->num_rows>0){
                return $tblSP;
            }else{
                return 0;// không có dòng dữ liệu
            }
        }
    }
    public function getAllSPbyMonAn($loaiMonAnId){
        $p = new MMonAn();
        // Xử lý SQL injection tại đây
     
        $tblSP= $p->SelectAllSPbyName($loaiMonAnId);
        if(!$tblSP){
            return -1;
        }else{
            if($tblSP->num_rows>0){
                return $tblSP;
            }else{
                return 0;// không có dòng dữ liệu
            }
        }
    }
    public function getAllMonanbyLoai($loaiMonAnId){
        $p = new MMonAn();
        // Xử lý SQL injection tại đây
     
        $tblSP= $p->SelectMonanbyLoai($loaiMonAnId);
        if(!$tblSP){
            return -1;
        }else{
            if($tblSP->num_rows>0){
                return $tblSP;
            }else{
                return 0;// không có dòng dữ liệu
            }
        }
    }
    public function getSua($sql){
        $p = new MMonAn();
        // Xử lý SQL injection tại đây
     
        $result= $p->sua($sql);
        if (!$result) {
            return -1;  // Lỗi khi cập nhật
        } else {
            return 1;  // Thành công
        }
    }
    public function getThem($sql){
        $p = new MMonAn();
        // Xử lý SQL injection tại đây
     
        $result= $p->them($sql);
        if (!$result) {
            return -1;  // Lỗi khi cập nhật
        } else {
            return 1;  // Thành công
        }
    }
    
 
    
}
?>
