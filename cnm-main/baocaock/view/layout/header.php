<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savoria Restaurant</title>
    <link rel="stylesheet" href="../layout/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    
</head>
<body>

<div class="nav-background">
    <div class="site-content-wrapper">       
        <div class="site-content">
            <header class="topbar">
                <div class="container flex justify-between items-center">                    
                    <div class="icons">
                        <a href=""><i class="fab fa-facebook-f"></i></a>
                        <a href=""><i class="fab fa-instagram"></i></a>
                        <a href=""><i class="fab fa-twitter"></i></a>
                        <?php
                                        // if (isset($_SESSION["dangnhap"]) && $_SESSION["dangnhap"]) {
                                        //     echo '<a href="index.php?page=dangxuat"><i ></i> ĐĂNG XUẤT</a>';
                                        // } else {
                                        //     echo '<a href="index.php?page=dangnhap"><i ></i> ĐĂNG NHẬP</a>';
                                        // }   
                        ?>
                    </div>
                    <div>
                        <h5>Working Hours: Mon - Sun (9.00 am - 22.00 pm)</h5>    
                    </div>    
                </div>
            </header>
            <?php
            $role = $_SESSION["dangnhap"]["id_role"];
            if($role == null || $role ==4  ){
                echo ' 
                        <nav>
                            <div class="top">
                                <div class="container flex justify-between">
                                    <div>
                                        <img src="../../img/logo2.png" alt="" style="width:120px;">
                                    </div>
                                    <div class="navbar magic-shadow">
                                        <div class="container flex justify-center">
                                            <a href="index.php?page=home" class="active">TRANG CHỦ</a>
                                            <a href="#">GIỚI THIỆU</a>
                                            <a href="#thucdon">THỰC ĐƠN</a>
                                            <a href="#datban">ĐẶT BÀN</a>                                 
                                            <a href="index.php?page=dangnhap"><i class="fas fa-user-alt"></i></a>';
                                        if (isset($_SESSION["dangnhap"]) && $_SESSION["dangnhap"]) {
                                           
                                            echo '<a href="index.php?page=dangxuat"><i ></i> ĐĂNG XUẤT</a>';
                                        } else {
                                            echo '<a href="index.php?page=dangnhap"><i ></i> ĐĂNG NHẬP</a>';
                                        }
                echo "                  
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </nav>";
            }
           ?>

</body>

</html>
