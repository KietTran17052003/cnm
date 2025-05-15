<?php
// session_start();
include_once("../../controller/cVaiTro.php");
$p = new CVaiTro();
include_once("xuly.php");
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

.toast-message {
  visibility: hidden;
  min-width: 300px;
  background-color: #333;
  color: #fff;
  text-align: left;
  border-radius: 8px;
  padding: 12px 16px;
  position: fixed;
  z-index: 9999;
  right: 20px;
  top: 20px;
  font-size: 15px;
  opacity: 0;
  transition: opacity 0.5s ease-in-out, top 0.5s ease-in-out;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.toast-message.show {
  visibility: visible;
  opacity: 1;
  top: 40px;
}
.toast-success {
  background-color: #28a745;
}
.toast-error {
  background-color: #dc3545;
}

    </style>
</head>
<body>

<div class="wrapper">
    <?php include_once("../layout/sidebar.php"); ?>
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
          <div class="error-message"></div>
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
      <?php
    // Lấy danh sách vai trò từ cơ sở dữ liệu
    $dsVaiTro = $p->getVaiTroForNhanVien(); // Sử dụng đúng đối tượng $p
    if ($dsVaiTro && mysqli_num_rows($dsVaiTro) > 0) { // Kiểm tra nếu có dữ liệu
        while ($r = mysqli_fetch_array($dsVaiTro)) {
            echo "<option value='{$r['id_role']}'>{$r['tenvaitro']}</option>";
        }
    } else {
        echo '<option value="">Không có dữ liệu</option>';
    }
    ?>
</select>

          <div class="error-message"></div>
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
          <div class="error-message"></div>
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
          <div class="error-message"></div>
        </div>
      </div>

      <div class="form-group row py-2">
        <label for="" class="col-sm-2 col-form-label">Trạng thái</label>
        <div class="col-sm-5">
          <select id="status" class="form-control" name="trangthai" required onblur="validateField(this, 'Vui lòng chọn trạng thái.', value => value !== '')">
          <option value="">- Chọn trạng thái -</option>
            <option>Đang làm việc</option>
            <option>Nghỉ việc</option>
          </select>
          <div class="error-message"></div>
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
          <div class="error-message"></div>
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
<div id="toast" class="toast-message"></div>

</body>
</html>

<script>
  function validateField(field, message, validator) {
    const errorSpan = field.nextElementSibling;
    if (!validator(field.value.trim())) {
      errorSpan.textContent = message;
      field.classList.add("is-invalid"); // Thêm class để làm nổi bật lỗi
    } else {
      errorSpan.textContent = "";
      field.classList.remove("is-invalid");
    }
  }

  function validateForm(){
    // Kiểm tra lại toàn bộ form trước khi gửi
    const name = document.getElementById("name");
    const phone = document.getElementById("phone");
    const email = document.getElementsByName("email")[0];
    const password = document.getElementsByName("password")[0];
    const status = document.getElementById("status");
    const chucvu = document.getElementsByName("idchucvu")[0];

    let isValid = true;

    // Kiểm tra trường nhập liệu
    validateField(name, "Họ và tên không được để trống.", value => value.length > 0);
    validateField(password, "Mật khẩu không được để trống.", value => value.length > 0);
    validateField(chucvu, "Vui lòng chọn chức vụ.", value => value !== "");
    validateField(status, "Vui lòng chọn trạng thái.", value => value !== "");


    function validateName(name) {
    const nameRegex = /^[a-zA-ZÀ-ỹ\s]+$/; // Cho phép ký tự alphabet (bao gồm có dấu) và dấu cách
    if (name.trim() === "") {
        return { valid: false, message: "Họ và tên không được để trống." };
    }
    if (!nameRegex.test(name)) {
        return { valid: false, message: "Họ và tên chỉ được chứa ký tự chữ cái và dấu cách." };
    }
    return { valid: true, message: "" };
    }

    function validatePhoneNumber(phoneNumber) {
  // Kiểm tra số bắt đầu bằng mã vùng hợp lệ ở Việt Nam và có 10 chữ số
  const phoneRegex = /^(03|05|07|08|09)\d{8}$/; 
  if (phoneNumber.trim() === "") {
    return { valid: false, message: "Số điện thoại không được để trống." };
  }
  if (!phoneRegex.test(phoneNumber)) {
    return { 
      valid: false, 
      message: "Số điện thoại không hợp lệ. Số điện thoại phải gồm 10 chữ số và bắt đầu là 03, 05, 07, 08, 09." 
    };
  }
  return { valid: true, message: "" };
}


    function validateEmail(email) {
      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/; // Định dạng email chuẩn
      if (email.trim() === "") {
        return { valid: false, message: "Email không được để trống." };
      }
      if (!emailRegex.test(email)) {
        return { valid: false, message: "Email không hợp lệ. Email có định dạng là abc@xxx.yy" };
      }
      return { valid: true, message: "" };
    }

    function validatepassword(password) {
  if (password.trim() === "") {
    return { valid: false, message: "Mật khẩu không được để trống." };
  }
  if (password.length < 6) {
    return { valid: false, message: "Mật khẩu phải có ít nhất 6 ký tự." };
  }
  return { valid: true, message: "" };
}


    // Kiểm tra họ tên
    const nameValidation = validateName(name.value);
    if (!nameValidation.valid) {
        const nameError = name.nextElementSibling;
        nameError.textContent = nameValidation.message;
        name.classList.add("is-invalid");
        isValid = false;
    } else {
        name.nextElementSibling.textContent = "";
        name.classList.remove("is-invalid");
    }

    // Kiểm tra số điện thoại
    const phoneValidation = validatePhoneNumber(phone.value);
      if (!phoneValidation.valid) {
        const phoneError = phone.nextElementSibling;
        phoneError.textContent = phoneValidation.message;
        phone.classList.add("is-invalid");
        isValid = false;
      } else {
        phone.nextElementSibling.textContent = "";
        phone.classList.remove("is-invalid");
      }

    // Kiểm tra email
    const emailValidation = validateEmail(email.value);
    if (!emailValidation.valid) {
      const emailError = email.nextElementSibling;
      emailError.textContent = emailValidation.message;
      email.classList.add("is-invalid");
      isValid = false;
    } else {
      email.nextElementSibling.textContent = "";
      email.classList.remove("is-invalid");
    }

    // Kiểm tra mật khẩu
    const passwordValidation = validatepassword(password.value);
    if (!passwordValidation.valid) {
      const passwordError = password.nextElementSibling;
      passwordError.textContent = passwordValidation.message;
      password.classList.add("is-invalid");
      isValid = false;
    } else {
      password.nextElementSibling.textContent = "";
      password.classList.remove("is-invalid");
    }

    // Kiểm tra các trường select
    if (status.value === "") {
      const statusError = status.nextElementSibling;
      statusError.textContent = "Vui lòng chọn trạng thái.";
      status.classList.add("is-invalid");
      isValid = false;
    } else {
      status.nextElementSibling.textContent = "";
      status.classList.remove("is-invalid");
    }

    if (chucvu.value === "") {
      const chucvuError = chucvu.nextElementSibling;
      chucvuError.textContent = "Vui lòng chọn chức vụ.";
      chucvu.classList.add("is-invalid");
      isValid = false;
    } else {
      chucvu.nextElementSibling.textContent = "";
      chucvu.classList.remove("is-invalid");
    }

    // If the form is valid, show the confirmation prompt
    if (isValid) {
      return confirm("Bạn có chắc chắn muốn thêm nhân viên này không?");
        
    }
    return false; // If the form is invalid, prevent submission

  }
</script>
