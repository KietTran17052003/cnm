<?php
    include_once("../../model/mNhanVien.php"); 
    $obj = new MNhanVien(); // Tạo đối tượng của lớp MNhanVien

    if (isset($_POST["btnAdd"])) {
        // Lấy dữ liệu từ form
        $name = $_POST["name"];
        $gender = $_POST["gender"];
        $idrole = $_POST["idchucvu"];
        // $address = $_POST["address"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $trangthai = $_POST["trangthai"];
        $password = md5($_POST["password"]);
        
        // Kiểm tra trạng thái
        switch ($trangthai) {
            case 'Đang làm việc':
                $trangthai = 1;
                break;
            // case 'Thử việc':
            //     $trangthai = 2;
            //     break;
            default:
                $trangthai = 0;
        }

        // Kiểm tra số điện thoại đã tồn tại
        if ($obj->checkPhoneExists($phone)) {
            // echo "<script>alert('Số điện thoại đã tồn tại. Vui lòng nhập số khác!');</script>";
            echo "<script>showToast('Số điện thoại đã tồn tại. Vui lòng nhập số khác!', 'error');</script>";

        } elseif ($obj->checkEmailExists($email)) {
            // echo "<script>alert('Email đã tồn tại. Vui lòng nhập email khác!');</script>";
            echo "<script>showToast('Email đã tồn tại. Vui lòng nhập email khác!', 'error');</script>";

        } else {
            // Thêm nhân viên
            $maNVmoi = $obj->addNV($name, $gender, $email, $phone, $idrole, $password, $trangthai);
            if ($maNVmoi) {
                echo "<script>showToast('Thêm nhân viên thành công!', 'success');</script>";
            } else {
                echo "<script>showToast('Thêm nhân viên thất bại. Vui lòng thử lại!', 'error');</script>";
            }

        }
    }
?>
