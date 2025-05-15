<?php
include_once("../../controller/cMonAn.php");
$pp = new CMonAN();
if (isset($_POST["btnAdd"])) {
    $tenmonan = $_POST["tenmonan"];
    $idloaimonan = $_POST["idloaimonan"];
    $giaban = $_POST["giaban"];
    $mota = $_POST["mota"];
    $tinhtrang = $_POST["trangthai"];

    // Kiểm tra dữ liệu đầu vào
    if (empty($tenmonan) || empty($idloaimonan) || empty($giaban) || empty($mota) || empty($tinhtrang)) {
        echo "<script>
            window.onload = function() { alert('Vui lòng điền đầy đủ thông tin!'); 
            setTimeout(function() {
            window.location.href = 'index.php?page=quanly/quanlymonan/';
            }, 1);
        }
        </script>";
        exit();
    }

    // Xử lý upload hình ảnh
    $filename_new = rand(111, 999) . "_" . basename($_FILES["hinhanh"]["name"]);

    // Ensure the target directory exists
    $target_dir = __DIR__ . "/../../../img/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Update the target path
    $target_path = $target_dir . $filename_new;

    if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_path)) {
        // Sử dụng prepared statement để thêm dữ liệu
        $sql = "INSERT INTO monan (tenmonan, mota, giaban, hinhanh, trangthai, idloaimonan) VALUES ('$tenmonan', '$mota', '$giaban', '$filename_new', '$tinhtrang', '$idloaimonan')";

        if ($pp->them($sql)) {
            echo "<script>
                window.onload = function() { alert('Thêm món ăn thành công!'); 
                setTimeout(function() {
                window.location.href = 'index.php?page=quanly/quanlymonan/';
                }, 1);
            }
            </script>";
        } else {
error_log("Database insertion failed: " . json_encode($params));
            echo "<script>
                window.onload = function() { alert('Thêm món ăn thất bại! Vui lòng thử lại.'); 
                setTimeout(function() {
                window.location.href = 'index.php?page=quanly/quanlymonan/';
                }, 1);
            }
            </script>";
        }
    } else {
error_log("File upload failed: " . $_FILES["hinhanh"]["error"]);
        echo "<script>
            window.onload = function() { alert('Upload ảnh thất bại! Vui lòng thử lại.'); 
            setTimeout(function() {
            window.location.href = 'index.php?page=quanly/quanlymonan/';
            }, 1);
        }
        </script>";
    }
}


?>