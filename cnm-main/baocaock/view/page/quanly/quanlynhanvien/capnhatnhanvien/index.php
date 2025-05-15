<?php
// session_start();
include_once("../../model/mVaiTro.php");
$mChucVu = new MVaiTro();
if (!isset($_SESSION["dangnhap"])) {
    header("Location: ../page/index.php?page=dangnhap");
    exit();
}

?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật nhân viên</title>
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
        height: 110vh;
    }
    .content {
        flex-grow: 1;
        padding: 20px;
        background-color: #F0F0F0;
        overflow-y: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

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
        width: 25%; /* Điều chỉnh độ rộng của nhãn */
    }

    .form-control {
        width: 80%; /* Điều chỉnh độ rộng của ô nhập liệu */
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
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
    .form-actions button {
        font-size: 1rem;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        color: inherit;
    }

    .form-actions button a {
        text-decoration: none;
        color: inherit;
    }

    .form-actions button:hover {
        text-decoration: underline;
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
</style>
</head>
<body>
<div class="wrapper">
    <?php
    include_once("../../controller/cNhanVien.php");
    include_once("../layout/sidebar.php");
    $id = $_GET['id'];
    $p = new CNhanVien();
    $NhanVien = $p->getMaNV($id);

    ?>
    <div class="content">
      <h2 style="text-align: center; padding-bottom: 10px;">CẬP NHẬT NHÂN VIÊN</h2>
      <form id="formNhanVien" action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="" class="col-sm-4 col-form-label">Họ Và Tên</label>       
        <div class="col-sm-5">
        <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            required
            value="<?php echo $NhanVien['hoten']?>"
            onblur="validateField(this, 'Họ và tên không được để trống.', value => value.length > 0)"
          />
          <div class="error-message"></div>      
        </div>         
      </div>

      <div class="form-group">
        <label for="" class="col-sm-4 col-form-label">Giới tính</label>              
        <div class="col-sm-5">
            <input
              type="radio"
              id="male"
              name="gender"
              value="1"
              <?php echo ($NhanVien['gioitinh'] == 1) ? 'checked' : '' ?>
            /> Nam
            <input
              type="radio"
              id="female"
              name="gender"
              value="0"
              <?php echo ($NhanVien['gioitinh'] == 0) ? 'checked' : '' ?>
            /> Nữ
          </div>
      </div>

      <div class="form-group">
        <label for="idrole" class="col-sm-4 col-form-label">Chức vụ</label>
        <div class="col-sm-5">
        <select name="chucvu" id="chucvu" class="form-control" required onblur="validateField(this, 'Vui lòng chọn chức vụ.', value => value !== '')">
            <?php
            
            $listChucVu = $mChucVu->selectVaiTroForNhanVien(); 

            if ($listChucVu && $listChucVu->num_rows > 0) {
              while ($row = $listChucVu->fetch_assoc()) {
                  $selected = ($row['id_role'] == $NhanVien['id_role']) ? 'selected' : '';
                  echo "<option value='{$row['id_role']}' $selected>{$row['tenvaitro']}</option>";
              }
          } else {
              echo "<option value=''>Không có dữ liệu</option>";
          }
           
            ?>
          </select>
          <div class="error-message"></div>
        </div>        
      </div>


      <div class="form-group">
        <label for="" class="col-sm-4 col-form-label">Số điện thoại</label>
        <div class="col-sm-5">
        <input
            type="tel"
            class="form-control"
            id="phone"
            name="phone"
            required
            value="<?php echo $NhanVien['sdt']?>"
            onblur="validateField(this, 'Số điện thoại không được để trống.', value => value.length > 0)"
          />
          <div class="error-message"></div>
        </div>          
      </div>

      <div class="form-group">
        <label for="" class="col-sm-4 col-form-label">Email</label>
        <div class="col-sm-5">
        <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
            value="<?php echo $NhanVien['email']?>"
            onblur="validateField(this, 'Email không được để trống.', value => value.length > 0)"
          /> 
          <div class="error-message"></div>
        </div>        
      </div>

      <div class="form-group">
        <label for="" class="col-sm-4 col-form-label">Trạng thái</label>
        <div class="col-sm-5">
        <select id="status" class="form-control" name="trangthai" required>
            <option value="Đang làm việc" <?php echo ($NhanVien['trangthai'] == 'Đang làm việc') ? 'selected' : '' ?>>
              Đang làm việc
            </option>
            <option value="Nghỉ việc" <?php echo ($NhanVien['trangthai'] == 'Nghỉ việc') ? 'selected' : '' ?>>
              Nghỉ việc
            </option>
          </select>
          <span class="error-message"></span>
        </div>
      </div>


      <div class="form-actions py-3">
        <label for="" class="col-sm-4 col-form-label"></label>
        <button class="btn btn-primary">
          <a href="index.php?page=quanly/quanlynhanvien" style="text-decoration: none; color: inherit;">Quay lại</a>
        </button>
        <button type="reset" class="btn btn-secondary">
          <i class="fas fa-times"></i> Hủy
        </button>
        <button type="submit" class="btn btn-success" name="btnSua" onclick="return validateForm()">
          <i class="far fa-save"></i> Lưu
        </button>
      </div>
    </form>
    </div>
</div>
<?php
// Nếu nhấn nút Lưu thì mới xử lý cập nhật
if (isset($_POST['btnSua'])) {
    include("xuly.php");
}
?>

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
    const status = document.getElementById("status");
    const chucvu = document.getElementsByName("chucvu")[0];

    let isValid = true;

    // Kiểm tra trường nhập liệu
    validateField(name, "Họ và tên không được để trống.", value => value.length > 0);
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
      return confirm("Bạn có chắc chắn muốn cập nhật nhân viên này không?");
        
    }
    return false; // If the form is invalid, prevent submission

  }
</script>
