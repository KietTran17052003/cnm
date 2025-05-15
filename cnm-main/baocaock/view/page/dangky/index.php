<?php
// session_start();
include('../../controller/cnguoidung.php');

if (isset($_POST['btDangky'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;

    if ($gender === null || $gender === '') {
        echo "<p style='color:red; text-align:center;'>Vui lòng chọn giới tính!</p>";
        exit();
    }

    $password = md5($_POST['password']); // Mã hóa mật khẩu bằng md5
    $confirm_password = md5($_POST['confirm_password']); // Mã hóa mật khẩu xác nhận

    // Kiểm tra mật khẩu và xác nhận mật khẩu
    if ($password !== $confirm_password) {
        echo "<p style='color:red; text-align:center;'>Mật khẩu và xác nhận mật khẩu không khớp!</p>";
    } else {
        $obj = new CNguoiDung();

        // Kiểm tra email đã tồn tại
        $existingUser = $obj->kiemtraEmail($email);
        if ($existingUser) {
            echo "<p style='color:red; text-align:center;'>Email đã tồn tại, vui lòng sử dụng email khác!</p>";
        } else {
            // Tạo câu lệnh SQL để thêm người dùng
            $sql = "INSERT INTO nguoidung (hoten, gioitinh, email, sdt, password, id_role, trangthai) 
                    VALUES ('$fullname', '$gender', '$email', '$phone', '$password', 4, 1)";

            $result = $obj->dangkytk($sql);

            if ($result == 1) {
                echo "<p style='color:green; text-align:center;'>Đăng ký thành công!</p>";
                header("Location: ../page/index.php?page=dangnhap"); // Chuyển hướng đến trang đăng nhập
                exit();
            } else {
                echo "<p style='color:red; text-align:center;'>Đăng ký thất bại, vui lòng thử lại!</p>";
            }
        }
    }
}
?>

<style>
  .container1 {
    background: url('https://noithatphacach.com/wp-content/uploads/2024/04/mau-nha-hang-dep-don-gian-hien-dai-6.jpg');
    background-size: cover;
    background-position: center;
  }
  .wrapper {
    min-height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  form {
    width: 350px; /* Giảm chiều rộng form */
    background: #F0F0F0;
    padding: 20px; /* Giảm padding */
    border-radius: 12px;
  }
  h3 {
    text-align: center;
    margin-bottom: 15px; /* Giảm khoảng cách dưới tiêu đề */
  }
  .input-group {
    margin-bottom: 12px; /* Giảm khoảng cách giữa các nhóm input */
    display: flex;
    align-items: center;
    border-bottom: 2px solid #d1d5db;
  }
  .input-group i {
    color: #4a5568;
    margin-right: 6px; /* Giảm khoảng cách giữa icon và input */
  }
  .input-group input, .input-group select {
    width: 100%;
    border: none;
    padding: 8px 0; /* Giảm padding của input */
    outline: none;
    background: #F0F0F0;
  }
  .input-group input:focus, .input-group select:focus {
    border-bottom-color: #3b82f6;
  }
  .button-group {
    display: flex;
    justify-content: center;
    margin-top: 12px; /* Giảm khoảng cách trên nút */
  }
  .button {
    padding: 8px 14px; /* Giảm padding của nút */
    border-radius: 8px;
    color: white;
    display: flex;
    align-items: center;
    border: none;
    cursor: pointer;
    font-size: 0.9rem; /* Giảm kích thước chữ */
  }
  .button-green {
    background-color: #10b981;
  }
</style>

<head>
</head>
<body>
  <div class="container1">
    <div class='wrapper' style="font-family: 'Trebuchet MS', sans-serif; font-family: 'block-pro', 'Helvetica Neue', Verdana, Arial, sans-serif;">
      <form method="POST" action="">
        <h3>ĐĂNG KÝ</h3>
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" name="fullname" placeholder="Họ và tên" required />
        </div>
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" required />
        </div>
        <div class="input-group">
          <i class="fas fa-phone"></i>
          <input type="text" name="phone" placeholder="Số điện thoại" required />
        </div>
        <div class="input-group">
          <i class="fas fa-venus-mars"></i>
          <select name="gender" required>
            <option value="" disabled selected>Giới tính</option>
            <option value="1">Nam</option>
            <option value="0">Nữ</option>
            <option value="other">Khác</option>
          </select>
        </div>
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Mật khẩu" required />
        </div>
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required />
        </div>
        <div class="button-group">
          <button type="submit" class="button button-green" name="btDangky">Đăng ký</button>
        </div>
      </form>
    </div>
  </div>
</body>