<?php
include_once("ketnoi.php");

class MMonAn {
    public function SelectAllMonAn() {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            $str = "select * from monan";
            $tblMonAN = $con->query($str) ;
          
            mysqli_query($con, "SET NAMES 'utf8'");
 $p->dongKetNoi($con);
            return $tblMonAN;
        } else {
            return false; 
        }
    } 
    
   // Lấy một món ăn theo id
   public function SelectMaMonAn($id) {
    $p = new ketnoi();
    $con = $p->connect();
    
    if ($con) {
        $str = "SELECT * FROM monan WHERE idmonan = ?";
        $stmt = $con->prepare($str);
        $stmt->bind_param("i", $id); // Sử dụng prepared statement để bảo vệ khỏi SQL Injection
        $stmt->execute();

        // Thay thế get_result() bằng bind_result()
        $stmt->bind_result($idmonan, $tenmonan, $mota,$giaban, $hinhanh, $trangthai,$idloaimonan);
        if ($stmt->fetch()) {
            // Trả về dữ liệu dưới dạng mảng kết hợp
            $result = array(
                'idmonan' => $idmonan,
                'tenmonan' => $tenmonan,
                'idloaimonan' => $idloaimonan,
                'giaban' => $giaban,
                'mota' => $mota,
                'trangthai' => $trangthai,
                'hinhanh' => $hinhanh
         );
            $stmt->close();
            $p->dongKetNoi($con);
            return $result;
        } else {
            $stmt->close();
            $p->dongKetNoi($con);
            return false; // Không tìm thấy món ăn với id đó
        }
    } else {
        return false; // Không thể kết nối đến CSDL
    }
}

// // Cập nhật món ăn
// public function updateMonAn($maMonAn, $tenMonAn, $maLoaiMonAn, $giaBan, $moTa, $tinhTrang, $hinhAnh) {
//     $p = new clsKetNoi();
//     $con = $p->moKetNoi();
    
//     if ($con) {
//         $str = "UPDATE monan SET 
//                 Tenmonan = ?, 
//                 MaLoaiMonAn = ?, 
//                 Giaban = ?, 
//                 Mota = ?, 
//                 Tinhtrang = ?, 
//                 Hinhanh = ? 
//                 WHERE MaMonAn = ?";
        
//         $stmt = $con->prepare($str);
//         $stmt->bind_param("sssssssi", $tenMonAn, $maLoaiMonAn, $giaBan, $moTa, $tinhTrang, $hinhAnh, $maMonAn);
//         $result = $stmt->execute();
//         $p->dongKetNoi($con);
//         return $result;
//     } else {
//         return false; 
//     }
// }
    
    public function SelectAllSPbyMonAn($id){
        $p= new ketnoi();
        $con= $p->connect();
        if($con){
            $str = "select * from monan where idloaimonan='$id'";
            $tblSP= $con->query($str);
            $p->dongKetNoi($con);
            return $tblSP;
        }
        else{
            return false; // không thể kết nối đến csdl
        }
    }
    public function SelectAllSPbyName($monan){
        $p= new ketnoi();
        $con= $p->connect();
        if($con){
            $str = "select * from monan where tenmonan like N'%$monan%'";
            $tblSP= $con->query($str);
            $p->dongKetNoi($con);
            return $tblSP;
        }
        else{
            return false; // không thể kết nối đến csdl
        }
    }
    // Lấy danh sách món ăn theo loại (JOIN với bảng loaimonan)
    public function SelectMonAnByLoai($loaiMonAnId) {
        $p = new ketnoi();
        $con = $p->connect();

        if ($con) {
            $str = "SELECT *
                    FROM monan 
                    JOIN loaimonan ON monan.idloaimonan = loaimonan.idloaimon
                    WHERE monan.idloaimonan = ?"; // JOIN để kết hợp dữ liệu
            $stmt = $con->prepare($str);
            $stmt->bind_param("i", $loaiMonAnId); // `i` là kiểu integer
            $stmt->execute();
            $result = $stmt->get_result();
            $p->dongKetNoi($con);
            return $result;
        } else {
            return false;
        }
    }
    // Phương thức thực thi câu truy vấn UPDATE (sua)
    public function sua($sql) {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            if ($con->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
            $p->dongKetNoi($con);
        } else {
            return false;
        }
    }
    public function them($sql) {
        $p = new ketnoi();
        $con = $p->connect();
        
        if ($con) {
            if ($con->query($sql) === TRUE) {
                // Đóng kết nối sau khi thực hiện truy vấn thành công
                $p->dongKetNoi($con);
                return true;
            } else {
                // Đóng kết nối sau khi truy vấn không thành công
                $p->dongKetNoi($con);
                return false;
            }
        } else {
            return false;
        }
    }
    
    
}
?>
