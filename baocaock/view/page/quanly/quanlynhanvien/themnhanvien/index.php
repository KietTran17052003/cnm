<?php
session_start();
if (!isset($_SESSION["dangnhap"])) {
    header("Location: ../../index.php?page=dangnhap");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .wrapper {
            display: flex;
            height: 100vh;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #F0F0F0;
            overflow-y: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);    
        }

/* Nhãn và ô nhập liệu */
.form-group {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding-top: 10px;
}

.form-group label {
    font-weight: bold;
    text-align: right;
    padding-right: 15px;
}

.form-control {
    width: 80%;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

/* Hiệu ứng hover và focus */
.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
}

/* Nút radio và select */
input[type="radio"] {
    margin-right: 5px;
}

select.form-control {
    cursor: pointer;
}

/* Trạng thái lỗi */
.is-invalid {
    border-color: #dc3545;
}

.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 5px;
}

button {
    padding: 10px 10px;
    font-size: 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

button.btn-primary:hover {
    background-color: #0056b3;
}

button.btn-secondary:hover {
    background-color: #5a6268;
}

button.btn-success:hover {
    background-color: #218838;
}

button a {
    text-decoration: none;
    color: inherit;
}

button a:hover {
    text-decoration: underline;
}

/* Khoảng cách và căn chỉnh */
.form-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}

.row {
    margin: 0;
    padding: 5px;
}

.col-sm-2 {
    flex: 0 0 25%;
    max-width: 25%;
}

.col-sm-5 {
    flex: 0 0 75%;
    max-width: 75%;
}
    </style>
</head>
<body>

<div class="wrapper">
    <?php include_once(__DIR__ . "/../../layout/sidebar.php"); ?>
    <div class="content">
    <form action="" method="post" enctype="multipart/form-data">
      <h2 style="text-align: center; padding-bottom: 10px;">THÊM NHÂN VIÊN</h2>
      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Họ và tên</label>
        <div class="col-sm-5">
          <input
            type="text"
            class="form-control"
            id="name"
            placeholder="Nhập họ và tên"
            name="name" required
            onblur="validateField(this, 'Họ và tên không được để trống.', value => value.length > 0)"
          />
          <span class="error-message"></span>
        </div>
      </div>
      
      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Giới tính</label>
        <div class="col-sm-5">
          <div class="form-control">
            <input
              type="radio"
              class=""
              id="male"
              name="gender"
              value="1" checked
            />Nam
            <input
              type="radio"
              class=""
              id="female"
              name="gender"
              value="0"
            />Nữ
          </div>
        </div>
      </div>

      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Chức vụ</label>
        <div class="col-sm-5">
          <select name="idchucvu" class="form-control" required onblur="validateField(this, 'Vui lòng chọn chức vụ.', value => value !== '')">
              <option value="">- Chọn chức vụ -</option>
                            
          </select>
          <span class="error-message"></span>
        </div>
      </div>

      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-5">
          <input
            type="email"
            class="form-control"
            id=""
            placeholder="Nhập email"
            name="email"
            required
            onblur="validateField(this, 'Email không được để trống.', value => value.length > 0)"
          />
          <span class="error-message"></span>
        </div>
      </div>

      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Số điện thoại</label>
        <div class="col-sm-5">
          <input
            type="text"
            class="form-control"
            id="phone"
            placeholder="Nhập số điện thoại"
            name="phone"
            required
            onblur="validateField(this, 'Số điện thoại không được để trống.', value => value.length > 0)"
          />
          <span class="error-message"></span>
        </div>
      </div>

      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Trạng thái</label>
        <div class="col-sm-5">
          <select id="status" class="form-control" name="trangthai" required>
          <option value="">- Chọn trạng thái -</option>
            <option>Đang làm việc</option>
            <option>Thử việc</option>
            <option>Nghỉ việc</option>
          </select>
          <span class="error-message"></span>
        </div>
      </div>

      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Mật khẩu</label>
        <div class="col-sm-5">
          <input
            type="password"
            class="form-control"
            id=""
            placeholder="Nhập mật khẩu"
            name="password"
            required
            onblur="validateField(this, 'Mật khẩu không được để trống.', value => value.length > 0)"
          />
          <span class="error-message"></span>
        </div>
      </div>

      <div class="form-actions py-3">
        <button class="btn btn-primary">
          <a href="index.php?page=quanly/quanlynhanvien" style="text-decoration: none; color: inherit;">Quay lại</a>
        </button>
         
        <button type="reset" class="btn btn-secondary">
          <i class="fas fa-times"></i> Hủy
        </button>
        <button type="submit" class="btn btn-success" onclick="return validateForm()" name="btnAdd">
          <i class="far fa-save"></i> Lưu
        </button>
      </div>
    </form>
    </div>
    
</div>


</body>
</html>
