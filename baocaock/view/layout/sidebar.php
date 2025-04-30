<?php
  if (!isset($_SESSION["dangnhap"])) {
      header("Location: index.php?page=dangnhap");
      exit();
  }
  $nguoiDung = $_SESSION["dangnhap"]; 

?> 

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  .sidebar {
    width: 250px;
    background-color:rgb(57, 69, 85);
    color: white;
    min-height: 100vh;
    padding: 20px 20px;
    font-family: Arial, sans-serif;
  }

  .sidebar h2 {
    font-size: 18px;
    margin-bottom: 20px;
    color: #ffffff;
    border-bottom: 1px solid #374151;
    padding-bottom: 10px;
    padding-top: 10px;
  }

  .sidebar a {
    display: block;
    padding: 10px 15px;
    color: #d1d5db;
    text-decoration: none;
    border-radius: 6px;
    margin-bottom: 5px;
  }

  .sidebar a:hover, .sidebar a.active {
    background-color:rgb(87, 100, 123);
    color: #ffffff;
  }

  .sidebar a i {
    margin-right: 10px;
  }

  .submenu {
    padding-left: 20px;
  }

</style>

<div class="sidebar">
  <h2 style="text-align:center;"><i class="fas fa-utensils"></i> Quản Lý Nhà Hàng</h2>

  <a href="index.php?page=quanly"><i class="fas fa-home"></i> Trang chủ</a>
  <a href="index.php?page=quanly/quanlynhanvien"><i class="fas fa-users"></i> Quản lý nhân viên</a>
  
  <a href="index.php?page=quanly/quanlykhachhang"><i class="fas fa-user-tag"></i> Quản lý khách hàng</a>
  <a href="index.php?page=quanly/quanlymonan"><i class="fas fa-hamburger"></i> Quản lý món ăn</a>
  <a href="index.php?page=quanly/quanlyban"><i class="fas fa-chair"></i> Quản lý bàn</a>
  <a href="#"><i class="fas fa-receipt"></i> Quản lý đơn hàng</a>
  <a href="#"><i class="fas fa-chart-line"></i> Thống kê</a>
  <?php
    if (isset($_SESSION["dangnhap"]) && $_SESSION["dangnhap"]) {  
      echo '<a href="index.php?page=dangxuat"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>';
    } 
  ?>
</div>