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
    <title>Quản lý đơn đặt bàn</title>
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
        <h2 class="d-flex justify-content-center style='color: #333;'">QUẢN LÝ ĐƠN ĐẶT BÀN</h2>
        
        <div style ="overflow: auto; height: 500px;">
        <?php
            include_once("../../controller/cDonDatBan.php");
            $p = new CDonDatBan();
            $tblDon = $p->getAllDon(); // Gọi hàm để lấy tất cả đơn đặt bàn (hoặc tên hàm tương ứng)

            
            // Kiểm tra và hiển thị kết quả           
            if ($tblDon && $tblDon->num_rows > 0) {
                echo '<table>';
                echo "
                    <thead style ='display: fixed; position: sticky; top: 0; z-index: 2'>
                        <tr>
                            <th>Mã đặt bàn</th>
                            <th>Tên khách hàng</th>
                            <th>Ngày đặt bàn</th>                          
                            <th>Số điện thoại</th>
                            <th>Email</th>                           
                            <th>Số lượng</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>                           
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                ";
                while ($r = $tblDon->fetch_assoc()) {
                    $statusText = ($r['trangthai'] == 'da_xac_nhan') ? 'Đã xác nhận' : 'Chờ xác nhận';
                    $statusClass = ($r['trangthai'] == 'da_xac_nhan') ? 'status-working' : 'status-probation';
                
                    echo "
                        <tr>
                            <td>{$r['idddb']}</td>
                            <td>{$r['tenkh']}</td>
                            <td>{$r['ngaydatban']}</td>                        
                            <td>{$r['sdt']}</td>
                            <td>{$r['email']}</td>
                            <td>{$r['soluong']}</td>
                            <td>{$r['ghichu']}</td>
                            <td><span class='{$statusClass}'>{$statusText}</span></td>                    
                            <td>
        <form method='POST' style='display:inline-block;'>
            <input type='hidden' name='idddb' value='{$r['idddb']}'>
            <button type='submit' name='duyet' style='background-color:green;color:white;border:none;padding:5px 10px;border-radius:4px;margin-right:5px;'>Duyệt</button>
        </form>
        <form method='POST' style='display:inline-block;'>
            <input type='hidden' name='idddb' value='{$r['idddb']}'>
            <button type='submit' name='tuchoi' style='background-color:red;color:white;border:none;padding:5px 10px;border-radius:4px;'>Từ chối</button>
        </form>
    </td>
                        </tr>";
                }
                
                            
                echo '</table>';
            } else {
                echo "<p>Không có đơn đặt bàn nào.</p>";
            }
        ?>
    </div>

    </div>
    
</div>


</body>
</html>
