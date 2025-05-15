<?php
include_once("../../model/mBan.php");

class CBan {
    public function getAllBan() {
        $p = new MBan();
        // Lấy dữ liệu bàn từ SelectAllBan()
        $tblSP = $p->getAllBan();
        
        // Kiểm tra nếu không có bàn nào
        if (empty($tblSP)) {
            return false;  // Trả về false nếu mảng rỗng (không có bàn nào)
        } else {
            return $tblSP;  // Trả về mảng bàn
        }
    }

    public function getMaBan($id) {
        $p = new MBan();
        $tblBan = $p->SelecBanByID($id); // Sửa tên hàm cho đúng với mBan.php

        if ($tblBan && count($tblBan) > 0) {
            return $tblBan; // Trả về mảng bàn
        } else {
            return null; // Không có bàn với id đó
        }
    }

    public function getSua($sql) {
        $p = new MBan(); // Sửa lại để sử dụng MBan thay vì MCuaHang
        $result = $p->sua($sql);

        if (!$result) {
            return -1;  // Lỗi khi cập nhật
        } else {
            return 1;  // Thành công
        }
    }

    public function getThem($sql) {
        $p = new MBan(); // Sửa lại để sử dụng MBan thay vì MCuaHang
        $result = $p->them($sql);

        if (!$result) {
            return -1;  // Lỗi khi thêm
        } else {
            return 1;  // Thành công
        }
    }

    public function getAllSPbyName($sp) {
        $p = new MBan();
        $tblSP = $p->SelectAllSPbyName($sp);

        if (!$tblSP) {
            return -1; // Lỗi kết nối hoặc không tìm thấy dữ liệu
        } else {
            if ($tblSP->num_rows > 0) {
                return $tblSP; // Trả về kết quả
            } else {
                return 0; // Không có dòng dữ liệu
            }
        }
    }

    public function getAllBanByViTri($vitri) {
        $p = new MBan();
        $tblSP = $p->SelectBanByViTri($vitri); // Sửa tên hàm cho đúng với mBan.php

        if (!$tblSP) {
            return -1; // Lỗi kết nối hoặc không tìm thấy dữ liệu
        } else {
            if (count($tblSP) > 0) {
                return $tblSP; // Trả về kết quả
            } else {
                return 0; // Không có dòng dữ liệu
            }
        }
    }
    public function getthemddb($sql) {
        $p = new MBan(); // Sửa lại để sử dụng MBan thay vì MCuaHang
        $result = $p->themddb($sql);

        if (!$result) {
            return -1;  // Lỗi khi thêm
        } else {
            return 1;  // Thành công
        }
    }
}
?>
