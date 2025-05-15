<?php
ob_start();
// session_start();
include_once("../../model/ketnoi.php");

// Lấy thông tin role
$role = isset($_SESSION["dangnhap"]) ? $_SESSION["dangnhap"]["id_role"] : null;

// Trang đang truy cập
$page = isset($_GET["page"]) ? $_GET["page"] : "home";

// Nếu là quản lý (role != 4) thì load giao diện sidebar
if ($role && $role != 4) {
    include_once("../layout/sidebar.php");

}

// Nếu là người dùng thường hoặc chưa login thì hiện header/footer
if ($role == null || $role == 4) {
    require __DIR__ . '/../../layout/header.php';
}

// Load nội dung trang
if (file_exists("../page/" . $page . "/index.php")) {
    include_once("../page/" . $page . "/index.php");
} else {
    include_once("../page/404/index.php");
}

// Nếu là người dùng thường thì có footer
if ($role == null || $role == 4) {
    require __DIR__ . '/../../layout/footer.php';
}

ob_end_flush();
?>