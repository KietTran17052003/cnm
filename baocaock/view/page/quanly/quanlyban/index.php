<?php
include_once("../../controller/cBan.php"); // Sửa đường dẫn
$p = new CBan();

// Lấy danh sách bàn
$tblBan = $p->getAllBan();

// Debug dữ liệu trả về
if (!$tblBan) {
    echo "<h3>Không có bàn nào được tìm thấy!</h3>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bàn</title>
    <style>
    * {
        box-sizing: border-box;
    }
    body {
        margin: 0;
        font-family: Arial, sans-serif; /* Sử dụng cùng font chữ */
    }
    .wrapper {
        display: flex;
        height: 130vh; /* Đồng bộ chiều cao */
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
        padding-bottom: 40px; /* Thêm khoảng cách 20px giữa tiêu đề và nội dung bên dưới */
        color: #333;
        font-weight: bold;
    }
    .floor-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px; /* Khoảng cách giữa các nhóm lầu */
    }
    .floor-group h3 {
        margin-bottom: 10px; /* Thêm khoảng cách giữa tiêu đề lầu và các bàn */
    }
    .table-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .table-card {
        width: 200px;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        font-family: Arial, sans-serif; /* Đồng bộ font chữ */
        font-size: 14px; /* Kích thước chữ giống trang quản lý món ăn */
    }
    .table-card h3 {
        margin: 10px 0;
        font-size: 16px; /* Đồng bộ kích thước chữ tiêu đề */
        font-weight: bold;
        color: #333;
    }
    .table-card p {
        margin: 5px 0;
        font-size: 14px;
        color: #374151; /* Màu chữ giống trang quản lý món ăn */
    }
    .table-card .status {
        font-weight: bold;
        color: green;
    }
    .table-card .status.unavailable {
        color: red;
    }
    .table-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>
<body>
    <div class="wrapper">
    <?php include_once(__DIR__ . "/../../layout/sidebar.php"); ?>
        <div class="content">
        <h2 class="d-flex justify-content-center style='color: #333; '">QUẢN LÝ BÀN</h2>
            <div class="table-container">
                <?php
                // Nhóm bàn theo lầu
                $groupedTables = array(); // Sử dụng cú pháp mảng dài
                foreach ($tblBan as $ban) {
                    $groupedTables[$ban['vitri']][] = $ban; // Nhóm theo 'vitri'
                }

                // Hiển thị từng nhóm
                foreach ($groupedTables as $lau => $tables): ?>
                    <div class="floor-group">
                        <h3 style="text-align: center;">Lầu: <?php echo htmlspecialchars($lau); ?></h3>
                        <div class="table-group">
                            <?php foreach ($tables as $ban): ?>
                                <div class="table-card">
                                    <h3>Bàn #<?php echo htmlspecialchars($ban['idban']); ?></h3>
                                    <p>Số ghế: <?php echo !empty($ban['soghe']) ? htmlspecialchars($ban['soghe']) : "Không xác định"; ?></p>
                                    <p>Lầu: <?php echo htmlspecialchars($ban['vitri']); ?></p>
                                    <p class="status <?php echo $ban['trangthai'] == 0 ? 'unavailable' : ''; ?>">
                                        <?php echo $ban['trangthai'] == 1 ? "Đang hoạt động" : "Chưa sử dụng"; ?>
                                    </p>
                                    <p>Người dùng: <?php echo !empty($ban['id_user']) ? "Người dùng #" . htmlspecialchars($ban['id_user']) : "Không có"; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>