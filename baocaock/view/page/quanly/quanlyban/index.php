<?php
include_once("../../controller/cBan.php");
$p = new CBan();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idBan = $_POST['idBan'];
    $action = $_POST['action'];

    if ($action === 'reserve') {
        // Xử lý đặt bàn
        $tenkh = $_POST['tenkh'];
        $ngaydatban = $_POST['ngaydatban'];

        if (!empty($tenkh) && !empty($ngaydatban)) {
            $sql = "UPDATE ban SET tenkh = '$tenkh', ngaydatban = '$ngaydatban', trangthai = 1 WHERE idban = $idBan";
            $result = $p->getSua($sql);

            if ($result) {
                echo "<script>
                window.onload = function() { alert('dặt bàn thành công!'); 
                setTimeout(function() {
                window.location.href = 'index.php?page=quanly/quanlyban/';
                }, 1);
                }
            </script>";
            } else {
                echo "<script>
                window.onload = function() { alert('dặt bàn thất bại!'); 
                setTimeout(function() {
                window.location.href = 'index.php?page=quanly/quanlyban/';
                }, 1);
                }
            </script>";
            }
        } else {
            echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
        }
    } elseif ($action === 'cancel') {
        // Xử lý xóa đặt bàn
        $sql = "UPDATE ban SET id_user = NULL, tenkh = NULL, ngaydatban = NULL, trangthai = 0 WHERE idban = $idBan";
        $result = $p->getSua($sql);

        if ($result) {
            echo "<script>alert('Xóa đặt bàn thành công!');</script>";
        } else {
            echo "<script>alert('Xóa đặt bàn thất bại!');</script>";
        }
    }
}

// Lấy danh sách bàn
$tblBan = $p->getAllBan();

// Kiểm tra dữ liệu trả về
if (!$tblBan) {
    echo "<h3>Không có bàn nào được tìm thấy!</h3>";
    exit();
}

if (!is_array($tblBan)) {
    echo "<h3>Dữ liệu không hợp lệ!</h3>";
    exit();
}


// Nhóm bàn theo lầu
$groupedTables = array();
foreach ($tblBan as $ban) {
    if (isset($ban['vitri'])) {
        $groupedTables[$ban['vitri']][] = $ban;
    }
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
        }
        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
            font-weight: bold;
        }
        .main-container {
            display: flex;
            gap: 20px;
        }
        .table-container {
            flex: 2;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-details {
            flex: none; /* Không cho phép tự động giãn */
            width: 300px; /* Đặt bề rộng cố định */
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-height: 400px;
            overflow-y: auto;
        }
        .table-details h3 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }
        .table-details p {
            margin: 5px 0;
            font-size: 14px;
        }
        .table-details input {
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .table-details label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .table-group {
            display: flex;
            flex-wrap: wrap; /* Cho phép xuống dòng nếu không đủ chỗ */
            gap: 15px; /* Khoảng cách giữa các bàn */
            justify-content: center; /* Căn giữa các bàn */
        }
        .table-card {
            width: 150px;
            border: 1px solid #bbb;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            font-size: 13px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .table-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
        }
        .status.unavailable {
            color: red;
        }
        .status {
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include_once(__DIR__ . "/../../layout/sidebar.php"); ?>
        <div class="content">
            <h2>QUẢN LÝ BÀN</h2>
            <div class="main-container">
                <div class="table-container">
                    <?php foreach ($groupedTables as $lau => $tables): ?>
                        <div class="floor-group">
                            <h3>Lầu: <?php echo htmlspecialchars($lau); ?></h3>
                            <div class="table-group">
                                <?php foreach ($tables as $ban): ?>
                                    <div class="table-card" onclick="showTableDetails(<?php echo htmlspecialchars(json_encode($ban)); ?>)">
                                        <h3>Bàn #<?php echo htmlspecialchars($ban['idban']); ?></h3>
                                        <p>Số ghế: <?php echo !empty($ban['soghe']) ? htmlspecialchars($ban['soghe']) : "Không xác định"; ?></p>
                                        <p class="status <?php echo $ban['trangthai'] == 0 ? 'unavailable' : ''; ?>">
                                            <?php echo $ban['trangthai'] == 0 ? 'Chưa sử dụng' : 'Đang sử dụng'; ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="table-details" class="table-details" style="display: none;">
                    <h3>Thông tin bàn</h3>
                    <form method="POST" action="">
                        <p>ID Bàn: <span id="table-id-display"></span></p>
                        <input type="hidden" id="table-id" name="idBan">

                        <p>Số ghế: <span id="table-seats-display"></span></p>
                        <p>Lầu: <span id="table-floor-display"></span></p>
                        <p>Trạng thái: <span id="table-status-value"></span></p>

                        <!-- Hiển thị thông tin khách hàng nếu có -->
                        <div id="customer-info" style="display: none;">
                            <p>Họ tên KH: <span id="customer-name-display"></span></p>
                            <p>Số điện thoại: <span id="customer-phone-display"></span></p>
                        </div>

                        <!-- Input Họ tên khách hàng -->
                        <label for="customer-name">Họ tên KH:</label>
                        <input type="text" id="customer-name" name="tenkh" placeholder="Nhập họ tên khách hàng">

                        <!-- Input Ngày đặt bàn -->
                        <label for="reservation-date">Ngày đặt bàn:</label>
                        <input type="date" id="reservation-date" name="ngaydatban">

                        <!-- Nút Đặt bàn -->
                        <button type="submit" name="action" value="reserve" id="reserve-btn" style="display: none;">Đặt bàn</button>

                        <!-- Nút Xóa đặt bàn -->
                        <button type="submit" name="action" value="cancel" id="cancel-reservation-btn" style="display: none;">Xóa đặt bàn</button>

                        <!-- Nút Hủy -->
                        <button type="button" onclick="clearDetails()">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showTableDetails(table) {
            document.getElementById('table-id-display').textContent = table.idban;
            document.getElementById('table-id').value = table.idban;

            document.getElementById('table-seats-display').textContent = table.soghe ? table.soghe : 'Không xác định';
            document.getElementById('table-floor-display').textContent = table.vitri;
            document.getElementById('table-status-value').textContent = table.trangthai == 0 ? 'Chưa sử dụng' : 'Đang sử dụng';

            const reserveBtn = document.getElementById('reserve-btn');
            const cancelReservationBtn = document.getElementById('cancel-reservation-btn');
            const customerNameInput = document.getElementById('customer-name');
            const reservationDateInput = document.getElementById('reservation-date');
            const customerInfo = document.getElementById('customer-info');
            const customerNameDisplay = document.getElementById('customer-name-display');
            const customerPhoneDisplay = document.getElementById('customer-phone-display');

            if (table.trangthai == 0) {
                // Bàn chưa sử dụng
                reserveBtn.style.display = 'inline-block';
                cancelReservationBtn.style.display = 'none';
                customerNameInput.value = '';
                reservationDateInput.value = '';
                customerNameInput.disabled = false;
                reservationDateInput.disabled = false;
                customerInfo.style.display = 'none';
            } else {
                // Bàn đang sử dụng
                reserveBtn.style.display = 'none';
                cancelReservationBtn.style.display = 'inline-block';
                if (table.tenkhachhang) {
                    customerNameInput.value = table.tenkhachhang || '';;
                } else{
                    customerNameInput.value = table.tenkh || '';
                }
                reservationDateInput.value = table.ngaydatban || '';
                customerNameInput.disabled = true;
                reservationDateInput.disabled = true;

            }

            document.getElementById('table-details').style.display = 'block';
        }

        function clearDetails() {
            document.getElementById('table-details').style.display = 'none';
        }
    </script>
</body>
</html>