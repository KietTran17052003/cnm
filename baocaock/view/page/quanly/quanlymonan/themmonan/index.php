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
    <title>Quản lý món ăn</title>
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
    <?php 
    include_once(__DIR__ . "/../../layout/sidebar.php"); 
    include_once("../../controller/cLoaiMonAn.php");
    $p = new CLoaiMonAN();
    include_once("xuly.php");
    ?>
    <div class="content">
    <form action="" method="post" enctype="multipart/form-data">
  <h2 style="text-align: center; padding-bottom: 10px;">THÊM MÓN ĂN</h2>

  <!-- Tên món ăn -->
  <div class="form-group row py-2">
    <label class="col-sm-2 col-form-label">Tên món ăn</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="tenmonan" placeholder="Nhập tên món ăn" required />
      <span class="error-message"></span>
    </div>
  </div>

  <!-- Giá bán -->
  <div class="form-group row py-2">
    <label class="col-sm-2 col-form-label">Giá bán (VNĐ)</label>
    <div class="col-sm-5">
      <input type="number" class="form-control" name="giaban" placeholder="Nhập giá bán" required />
      <span class="error-message"></span>
    </div>
  </div>

  <!-- Hình ảnh -->
  <div class="form-group row py-2">
    <label class="col-sm-2 col-form-label">Hình ảnh</label>
    <div class="col-sm-5">
      <input type="file" class="form-control" name="hinhanh" required />
      <span class="error-message"></span>
    </div>
  </div>

  <!-- Loại món ăn -->
  <div class="form-group row py-2">
    <label class="col-sm-2 col-form-label">Loại món ăn</label>
    <div class="col-sm-5">
      <select class="form-control" name="idloaimonan" required>
        <option value="">- Chọn loại món ăn -</option>
        <?php
        $loaimonan = $p->getAllLoaiMonAn();
        if ($loaimonan && $loaimonan !== -1 && $loaimonan !== 0) {
        while ($r = mysqli_fetch_array($loaimonan)) {
          echo '<option value="' . $r["idloaimon"] . '">' . $r["tenloai"] . '</option>';
        }
} else {
            echo '<option value="">Không có dữ liệu</option>';
        }
        ?> 
              </select>
      <span class="error-message"></span>
    </div>
  </div>

  <!-- Mô tả -->
  <div class="form-group row py-2">
    <label class="col-sm-2 col-form-label">Mô tả</label>
    <div class="col-sm-5">
      <textarea class="form-control" name="mota" rows="3" placeholder="Nhập mô tả món ăn" required></textarea>
      <span class="error-message"></span>
    </div>
  </div>

  <!-- Trạng thái -->
  <div class="form-group row py-2">
    <label class="col-sm-2 col-form-label">Trạng thái</label>
    <div class="col-sm-5">
      <select class="form-control" name="trangthai" required>
        <option value="">- Chọn trạng thái -</option>
        <option value="1">Đang có</option>
        <option value="0">Tạm hết</option>
      </select>
      <span class="error-message"></span>
    </div>
  </div>

  <!-- Hành động -->
  <div class="form-actions py-3">
        <button class="btn btn-primary">
          <a href="index.php?page=quanly/quanlymonan" style="text-decoration: none; color: inherit;">Quay lại</a>
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

<script>
  function validateField(field, message, validator) {
    const errorSpan = field.nextElementSibling;
    if (!validator(field.value.trim())) {
      errorSpan.textContent = message;
      field.classList.add("is-invalid");
    } else {
      errorSpan.textContent = "";
      field.classList.remove("is-invalid");
    }
  }

  function validateForm() {
    const tenmonan = document.getElementsByName("tenmonan")[0];
    const giaban = document.getElementsByName("giaban")[0];
    const hinhanh = document.getElementsByName("hinhanh")[0];
    const idloaimonan = document.getElementsByName("idloaimonan")[0];
    const mota = document.getElementsByName("mota")[0];
    const trangthai = document.getElementsByName("trangthai")[0];

    let isValid = true;

    // Kiểm tra tên món ăn
    validateField(tenmonan, "Tên món ăn không được để trống.", value => value.length > 0);

    // Kiểm tra giá bán
    validateField(giaban, "Giá bán phải là số dương.", value => !isNaN(value) && parseFloat(value) > 0);

    // Kiểm tra hình ảnh
    validateField(hinhanh, "Vui lòng chọn hình ảnh.", value => value.length > 0);

    // Kiểm tra loại món ăn
    validateField(idloaimonan, "Vui lòng chọn loại món ăn.", value => value !== "");

    // Kiểm tra mô tả
    validateField(mota, "Mô tả không được để trống.", value => value.length > 0);

    // Kiểm tra trạng thái
    validateField(trangthai, "Vui lòng chọn trạng thái.", value => value !== "");

    // Nếu tất cả hợp lệ, hiển thị xác nhận
    if (isValid) {
      return confirm("Bạn có chắc chắn muốn thêm món ăn này không?");
    }
    return false; // Ngăn gửi form nếu không hợp lệ
  }
</script>

</body>
</html>
