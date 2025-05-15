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

        public function capNhatTrangThaiDon($id, $trangthai) {
            $p = new MDonDatBan(); // Khởi tạo đối tượng MDeXuat
            $result = $p->capNhatTrangThaiDon($id, $trangthai); // Gọi phương thức updateTrangThai từ lớp MDeXuat
    
            // Kiểm tra kết quả trả về
            if ($result) {
                return true; // Thành công
            } else {
                return false; // Thất bại
            }
        }
    }

?>