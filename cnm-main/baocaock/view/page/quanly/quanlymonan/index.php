<?php
// session_start();
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
        h2 {
            margin-top: 0;
            text-align: center;
            padding-bottom: 10px;
        }
        button {   
            border: none;
        cursor: pointer;
        color: white;
        font-weight: bold;
        transition: background-color 0.3s ease;
}
button a {
    text-decoration: none;
    color: white;
}
.search input {
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    width: 250px;
    height: 30px;
    margin-right: 10px;
    padding-left: 10px;
}
.search-container {
    display: flex;
    justify-content: flex-end;
    margin-top: 10px;
    margin-right: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

thead {
    background-color: rgb(57, 69, 85);
    color: white;
    font-size: 16px;
    text-align: center;
}

thead th {
    padding: 10px;
    position: sticky;
    top: 0;
    z-index: 10;
}

tbody tr:nth-child(odd) {
    background-color: #f2f2f2;
}

tbody tr:nth-child(even) {
    background-color: #ffffff;
}

tbody td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.status-working {
    color: green;
    font-weight: bold;
}

.status-probation {
    color: blue;
    font-weight: bold;
}

.status-left {
    color: red;
    font-weight: bold;
}

td a {
    color: #374151;
    text-decoration: none;
    font-size: 18px;
}

td a:hover {
    color: rgb(87, 100, 123);
}
    </style>
</head>
<body>

<div class="wrapper">
    <?php include_once("../layout/sidebar.php"); ?>

    <div class="content">
        <h2 class="d-flex justify-content-center style='color: #333;'">QUẢN LÝ MÓN ĂN</h2>
        <div style= "display: flex; justify-content: center;align-items: center;">
            <button style="background-color: rgb(57, 69, 85);border-radius: 10px; width: 150px; height: 30px;"><a href="index.php?page=quanly/quanlymonan/themmonan" class="d-flex justify-content-center" style="color: white;">Thêm món ăn</a></button>      
        </div>
        <!-- search -->
        <div class="search-container">
            <form action="" method="post" name="frmSearch">
                <div class="search">
                <input name="txtTK" placeholder="Tìm theo tên món ăn..." type="text"
                    value="<?php echo isset($_POST['txtTK']) ? $_POST['txtTK'] : ''; ?>" />
                <button name="btnTK" type="submit" style="background: rgb(57, 69, 85); color: white; width: 40px; height: 30px;">
                    <i class="fas fa-search"></i>
                </button>
                </div>
            </form>
        </div>
        <div style ="overflow: auto; height: 500px;">
        <?php
            include_once("../../controller/cMonAn.php");
            $p = new CMonAN();
            
            // Kiểm tra nếu có tìm kiếm theo tên nhân viên
            if (isset($_POST['btnTK']) && !empty($_POST['txtTK'])) {
                $tblMonAN = $p->getAllSPbyName($_POST['txtTK']);
            } else {
                $tblMonAN = $p->getAllMonAN();
            }

            
            // Kiểm tra và hiển thị kết quả           
            if ($tblMonAN && $tblMonAN->num_rows > 0) {
                echo '<table>';
                echo "
                    <thead style ='display: fixed; position: sticky; top: 0; z-index: 2'>
                        <tr>
                            <th>Mã món ăn</th>
                            <th>Tên món ăn</th>
                            <th>Giá bán</th>
                            <th>Hình ảnh</th>                          
                            <th>Loại món ăn</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>                           
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                ";
                while ($r = $tblMonAN->fetch_assoc()) {                   
                    $statusClass = $r['trangthai'] == 1 
                        ? 'status-working' 
                        : ($r['trangthai'] == 2 
                            ? 'status-left' 
                            : ''); // Thêm giá trị mặc định khi không phải 1 hoặc 2

                    $statusText = $r['trangthai'] == 1 
                        ? 'Đang có' 
                        : ($r['trangthai'] == 2 
                            ? 'Hết món' 

                            : ''); // Thêm giá trị mặc định khi không phải 1 hoặc 2
                    $loaimonan = array(
                        1 => 'Khai vị',
                        2 => 'Món chính',
                        3 => 'Tráng miệng',
                        4 => 'Đồ uống',
                        5 => 'Ăn nhẹ'
                    );
                    echo "
                    <tr>
                        <td>{$r['idmonan']}</td>
                        <td>{$r['tenmonan']}</td>
                        <td>{$r['giaban']}</td>
                        <td><img src='../../img/".$r["hinhanh"]."' width='100' height='150'></td>
                        <td>" . (isset($loaimonan[$r['idloaimonan']]) ? $loaimonan[$r['idloaimonan']] : 'Không xác định') . "</td>
                        <td>{$r['mota']}</td>
                        <td><span class='{$statusClass}'>{$statusText}</span></td>
                        <td><a href='index.php?page=quanly/quanlymonan/capnhatmonan&id={$r['idmonan']}'><i class='fas fa-edit'></i></a></td>
                    </tr>";
                }              
                echo '</table>';
            } else {
                echo "<p>Không có món ăn nào.</p>";
            }
        ?>
    </div>

    </div>
    
</div>


</body>
</html>
