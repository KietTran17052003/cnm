

<?php
    ob_start();
    //error_reporting(1);
    session_start();
    include_once("model/ketnoi.php");
    require __DIR__ . '/../../layout/header.php';
    
    if(isset($_GET["page"])){
        $page = $_GET["page"];

    }else{
        $page = "home";
    }
    
    if(file_exists("../page/".$page."/index.php")){
        include_once("../page/".$page."/index.php");
    } else {
        include_once("../page/404/index.php");
    }

    require __DIR__ . '/../../layout/footer.php';
    ob_end_flush();
?>
<?php


// Kiểm tra nếu người dùng chưa đăng nhập và đang cố truy cập vào trang 'quanly' hoặc các trang con của 'quanly'
// if (isset($_GET["page"])) {
//     // Kiểm tra nếu trang là 'quanly' hoặc bất kỳ trang con nào của 'quanly', yêu cầu đăng nhập
//     if (strpos($_GET["page"], 'quanly') === 0 && !isset($_SESSION['dangnhap'])) {
//         header("Location: index.php?page=dangnhap");
//         exit();
//     }

//     // Nếu người dùng đã đăng nhập hoặc không phải trang 'quanly', tiếp tục xử lý trang
//     $page = $_GET["page"];
// } else {
//     $page = 'trangchu';  // Trang mặc định nếu không có tham số 'page'
// }

// // Kiểm tra xem file trang có tồn tại không
// if (file_exists("view/page/".$page."/index.php")) {
//     include("view/page/".$page."/index.php");
// } else {
//     include("view/page/404/index.php");
// }

// include("view/layout/footer.php");
?>
