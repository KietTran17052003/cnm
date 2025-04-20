<style>/*
    body {
      background-image: url('https://img.freepik.com/photos-premium/burger-classique-table-bois_235627-476.jpg');
      background-size: cover;
      background-position: center;
     
      justify-content: center;
      align-items: center;
      
      font-family: Arial, sans-serif;
    }
    .container {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
      margin-left: 60%;
      padding: 32px;
      height: 70%;
      margin-top: 10px;
      margin-bottom: 10px;
      width: 24rem;
      text-align: center;
      transform: translateX(20px); /* Di chuyển khối sang phải 
    }
    .logo-container {
      background-color: #ebf5ff;
      border-radius: 50%;
      padding: 10px;
      display: inline-block;
    }
    .logo {
      width: 50px;
      height: 50px;
    }
    h1 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-top: 12px;
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
      justify-content: space-between;
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
      margin-top: 30%;
    }
    .button i {
      margin-right: 8px;
    }
    .button-blue {
      background-color: #3b82f6;
    }
    .button-green {
      background-color: #10b981;
    }*/
    
  </style>
<head>
<link rel="stylesheet" href="../layout/css/style.css">
</head>
<body>
  <div class="container">
    <?php
            if (isset($_POST["btDangnhap"])) {
              include_once('../../controller/nguoidung.php');
                $obj = new CNguoiDung();
                $tenTK = $_POST["TenTK"];
                $password = $_POST["password"];
                
                $_SESSION["dangnhap"][] = $obj->dangnhaptaikhoan($tenTK, $password);

                if ($_SESSION["dangnhap"]) {
                  if($_SESSION["dangnhap"]["id_role"] == 4){
                    header("Location: index.php?page=home");
                  }else {
                    header("Location: index.php?page=quanly");
                  }
                    
                } else {
                    echo "<p style='color:red;'>Đăng nhập không thành công, vui lòng kiểm tra lại thông tin</p>";
                }
            }
        ?>
        <form method="POST" action="">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="TenTK" id="TenTK" placeholder="Tên đăng nhập" required />
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
</body>


