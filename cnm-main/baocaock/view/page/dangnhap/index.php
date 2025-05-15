<?php
session_start();
?>

<style>
  .container1{
    background: url('https://noithatphacach.com/wp-content/uploads/2024/04/mau-nha-hang-dep-don-gian-hien-dai-6.jpg');
    background-size: cover;
    background-position: center;
  }
  .wrapper{
    min-height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
    
  }
  form{
    width: 400px;
    background: #F0F0F0;
    padding: 30px 30px 30px;
    border-radius: 12px;
  }
  h3{
    text-align: center;
    margin-bottom: 20px;
    
  }
  .input-group {
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      border-bottom: 2px solid #d1d5db;
      margin-top: 10%;
      
    }
    .input-group i {
      color: #4a5568;
      margin-right: 8px;
    }
    .input-group input {
      width: 100%;
      border: none;
      padding: 10px 0;
      outline: none;
      background: #F0F0F0;
    }
    .input-group input:focus {
      border-bottom-color: #3b82f6;
    }
    .forgot-password {
      color: #3b82f6;
      text-decoration: none;
      font-size: 0.875rem;
      display: block;
      text-align: right;
      margin-bottom: 16px;
      margin-top: 10%;
    }
    .button-group {
      display: flex;
      justify-content: center; /* Căn giữa nút */
      margin-top: 16px; /* Thêm khoảng cách trên */
    }
    .button {
      padding: 10px 16px;
      border-radius: 8px;
      color: white;
      display: flex;
      align-items: center;
      border: none;
      cursor: pointer;
      font-size: 1rem;
      margin-top: 1 0%;
    }
    .button i {
      margin-right: 20px;
    }
    .button-blue {
      background-color: #3b82f6;
    }
    .button-green {
      background-color: #10b981;
    }

  </style>
<head>

</head>
<body>
  <div class="container1">
  <?php
      if (isset($_POST["btDangnhap"])) {
          include('../../controller/cnguoidung.php');
          $obj = new CNguoiDung();

          $email = $_POST["email"];
          $password = $_POST["password"];
          
          $user = $obj->dangnhaptaikhoan($email, $password);
      
          if ($user) {
              $_SESSION["dangnhap"] = $user;

              if ($user["id_role"] == 4) {
                  header("Location: index.php?page=home");
              } else {
                  header("Location: index.php?page=quanly");
              }
              exit();
          } else {
              // Thông báo lỗi đăng nhập
              echo "<p style='color:red; text-align:center;'>Đăng nhập không thành công, vui lòng kiểm tra lại email và mật khẩu</p>";
          }
      }
    ?>
        <div class='wrapper' style="font-family: 'Trebuchet MS', sans-serif;font-family: 'block-pro', 'Helvetica Neue', Verdana, Arial, sans-serif; ">
          <form method="POST" action="">
              <h3>ĐĂNG NHẬP</h3>
              <div class="input-group">
                  <i class="fas fa-user"></i>
                  <input type="email" name="email" placeholder="Email" required />
              </div>
              <div class="input-group">
                  <i class="fas fa-lock"></i>
                  <input type="password" name="password" id="password" placeholder="Mật khẩu" required />
              </div>
              <a href="#" class="forgot-password">Quên mật khẩu?</a>
              <div class="button-group">
                  <button type="submit" class="button button-green" name="btDangnhap">Đăng nhập</button>
              </div>
          </form>
        </div>
    </div>
</body>


