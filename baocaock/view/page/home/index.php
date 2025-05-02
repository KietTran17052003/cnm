<?php
session_start();
include_once("../../controller/cBan.php");
$p = new CBan();
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Múi giờ Việt Nam

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idBan = $_POST['idBan'];
    $action = $_POST['action'];

    if ($action === 'reserve') {
        // Xử lý đặt bàn
        $id_user = $_SESSION['dangnhap']['id_user']; // Lấy id_user từ session
        $ngaydatban = $_POST['ngaydatban']; // Giá trị datetime-local

        if (!empty($id_user) && !empty($ngaydatban)) {
            $sql = "UPDATE ban SET id_user = '$id_user', ngaydatban = '$ngaydatban', trangthai = 1 WHERE idban = $idBan";
            $result = $p->getSua($sql);

            if ($result) {
                echo "<script>
                window.onload = function() { alert('Đặt bàn thành công!'); 
                setTimeout(function() {
                window.location.href = 'index.php';
                }, 1);
                }
            </script>";
            } else {
                echo "<script>
                window.onload = function() { alert('Đặt bàn thất bại!'); 
                setTimeout(function() {
                window.location.href = 'index.php';
                }, 1);
                }
            </script>";
            }
        } else {
            echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
        }
    }
}

// Lấy danh sách bàn
$tblBan = $p->getAllBan();

// Kiểm tra dữ liệu trả về
if (!$tblBan || !is_array($tblBan)) {
    echo "<h3>Không có bàn nào được tìm thấy hoặc dữ liệu không hợp lệ!</h3>";
    $tblBan = array(); // Đảm bảo $tblBan là một mảng rỗng để tránh lỗi
}

// Nhóm bàn theo lầu
$groupedTables = array(); // Sử dụng array() thay vì []
foreach ($tblBan as $ban) {
    if (isset($ban['vitri'])) {
        $groupedTables[$ban['vitri']][] = $ban;
    }
}

// Sắp xếp lầu theo thứ tự tăng dần
ksort($groupedTables);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "cancel") {
    // Logic xử lý xóa đặt bàn
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../layout/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
        .big-image{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 80%;
            position: relative;
            overflow: hidden;
        }
        .big-image::before{
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url("https://arcviet.vn/wp-content/webp-express/webp-images/uploads/2016/07/thiet-ke-noi-that-nha-hang3.jpg.webp");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            z-index: -2;
            animation: Inout 5s infinite;
        }
        @keyframes Inout {
            0%,100%{
                transform: scale(1);
            }
            50%{
                transform: scale(1.1);
            }
        }
        .big-image::after{
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: black;
            opacity: 0.3;
            z-index: -2;
        }
        .big-image .big-image-content{
            text-align: center;
        }
        .big-image .big-image-content h2{
            font-size: 50px;
            color: white;
            font-family: 'Dancing Script';
        }
        .big-image .big-image-content p{
            font-size: 20px;
            color: white;
            margin: 15px 0;
            
        }
        /* Slider */
.slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
}
.slide {
    min-width: 100%;
    height: 400px;
    background-color: #ddd;
}
.slider-container {
    position: relative;
    width: 100%;
    margin: auto;
    overflow: hidden;
}
.slides{
    display: flex;
    transition: transform 0.5s ease;
}
.slide {
    width: 100%;
    height: 500px;
    background-size: cover;
    background-position: center;
}
.slide-1 {
    background-image: url("https://arcviet.vn/wp-content/webp-express/webp-images/uploads/2016/07/thiet-ke-noi-that-nha-hang3.jpg.webp");
            
}
.slide-2 {
    background-image: url('../../img/nha-hang-2.jpeg');
}
.slide-3 {
    background-image: url('../../img/nha-hang-1.jpg');
}
.navigation {
    position: absolute;
    top: 50%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    transform: translateY(-50%);
}
button {
    background-color: rgba(255, 255, 255, 0.7);
    border: none;
    cursor: pointer;
    padding: 10px;
}
        /* .btn {
            background-color: transparent;
            padding: 15px 30px;
            border: 2px solid #EEBF00;
            border-radius: 50px;
            color: #EEBF00;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn:hover{
            background-color: #ffffff;

        } */
        .section-heading{
            color: #232B38;
        }
        .top-products{
            background: #F0F0F0;
        }
        .flex-container {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .table-container {
            flex: 2;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 58%; /* Giới hạn chiều rộng */
        }

        .table-details {
            flex: 1;
            width: 250px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 500px; /* Đặt chiều cao cố định */
            overflow-y: auto; /* Thêm thanh cuộn nếu nội dung vượt quá chiều cao */
            font-size: 14px;
            line-height: 1.5;
            height: 100%; /* Đặt chiều cao cố định */
        }

        .table-details h3 {
            font-size: 18px; /* Giảm kích thước tiêu đề */
            margin-bottom: 10px;
            text-align: center; /* Căn giữa tiêu đề */
        }

        .table-details p {
            margin: 5px 0; /* Giảm khoảng cách giữa các dòng */
        }

        .table-details label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        .table-details input[type="text"],
        .table-details input[type="date"] {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .table-details button {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .table-details button:hover {
            background-color: #0056b3;
        }
        .table-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Giảm khoảng cách giữa các bàn */
            justify-content: flex-start;
        }

        .table-card {
            width: 120px; /* Làm nhỏ danh sách bàn */
            border: 1px solid #bbb;
            border-radius: 10px;
            padding: 8px;
            text-align: center;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            font-size: 12px; /* Giảm kích thước chữ */
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
    
<div class="slider-container">
        <div class="slides">
            <div class="slide slide-1"></div>
            <div class="slide slide-2"></div>
            <div class="slide slide-3"></div>
        </div>
        <div class="navigation">
            <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
            <button class="next" onclick="changeSlide(1)">&#10095;</button>
        </div>
    </div>
    <section class="about-meal">
    <div class="container">
        <h1 class="section-heading">ĐẶT BÀN ONLINE</h1>
        <div class="flex-container">
            <!-- Danh sách bàn -->
            <div class="table-container">
                <?php if (empty($groupedTables)): ?>
                    <p>Không có bàn nào để hiển thị.</p>
                <?php else: ?>
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
                <?php endif; ?>
            </div>

            <!-- Thông tin bàn -->
            <div id="table-details" class="table-details" style="display: none;">
                <h3>Thông tin bàn</h3>
                <form method="POST" action="">
                    <p>ID Bàn: <span id="table-id-display"></span></p>
                    <input type="hidden" id="table-id" name="idBan">

                    <p>Số ghế: <span id="table-seats-display"></span></p>
                    <p>Lầu: <span id="table-floor-display"></span></p>
                    <p>Trạng thái: <span id="table-status-value"></span></p>

                    <label for="reservation-date">Ngày đặt bàn:</label>
                    <input type="datetime-local" id="reservation-date" name="ngaydatban">

                    <?php if (isset($_SESSION['dangnhap'])): ?>
                        <!-- Nếu đã đăng nhập, hiển thị nút Đặt bàn -->
                        <button type="submit" name="action" value="reserve" id="reserve-btn" style="display: none;">Đặt bàn</button>
                    <?php else: ?>
                        <!-- Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập -->
                        <button type="button" onclick="window.location.href='../../view/page/index.php?page=dangnhap';" id="reserve-btn" style="display: none;">Đăng nhập để đặt bàn</button>
                    <?php endif; ?>
                    <button type="button" onclick="clearDetails()">Hủy</button>
                </form>
            </div>
        </div>
    </div>
</section>
    <section class="top-products">
                    <div class="container">
                        <h1 class="section-heading">THỰC ĐƠN</h1>
                        
                        
                        <!-- <div class="text-center btn-wrapper">
                            <button class="btn btn-secondary">View More</button>
                        </div> -->
                    </div>
    </section>
</body>
</html>
<script>
let currentSlide = 0;

function showSlide(index) {
    const slides = document.querySelector('.slides');
    const totalSlides = document.querySelectorAll('.slide').length;

    if (index >= totalSlides) {
        currentSlide = 0;
    } else if (index < 0) {
        currentSlide = totalSlides - 1;
    } else {
        currentSlide = index;
    }

    slides.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function changeSlide(direction) {
    showSlide(currentSlide + direction);
}

// Tự động chuyển slide mỗi 3 giây
setInterval(() => {
    changeSlide(1);
}, 3000);

function showTableDetails(table) {
    document.getElementById('table-id-display').textContent = table.idban;
    document.getElementById('table-id').value = table.idban;

    document.getElementById('table-seats-display').textContent = table.soghe ? table.soghe : 'Không xác định';
    document.getElementById('table-floor-display').textContent = table.vitri;
    document.getElementById('table-status-value').textContent = table.trangthai == 0 ? 'Chưa sử dụng' : 'Đang sử dụng';

    const reserveBtn = document.getElementById('reserve-btn');
    const reservationDateInput = document.getElementById('reservation-date');

    if (table.trangthai == 0) {
        // Bàn chưa sử dụng
        reserveBtn.style.display = 'inline-block';
        reservationDateInput.value = ''; // Reset giá trị
        reservationDateInput.disabled = false;
    } else {
        // Bàn đang sử dụng
        reserveBtn.style.display = 'none';
        if (table.ngaydatban) {
            // Chuyển đổi thời gian từ cơ sở dữ liệu sang định dạng datetime-local
            const datetime = new Date(table.ngaydatban);
            const offset = datetime.getTimezoneOffset() * 60000; // Lấy offset múi giờ
            const localDatetime = new Date(datetime.getTime() - offset); // Chuyển sang giờ địa phương
            const formattedDatetime = localDatetime.toISOString().slice(0, 16); // Định dạng YYYY-MM-DDTHH:MM
            reservationDateInput.value = formattedDatetime;
        } else {
            reservationDateInput.value = '';
        }
        reservationDateInput.disabled = true;
    }

    document.getElementById('table-details').style.display = 'block';
}

function clearDetails() {
    document.getElementById('table-details').style.display = 'none';
}
</script>
<?php
$datetime = new DateTime($ngaydatban); // $ngaydatban là giá trị từ cơ sở dữ liệu
echo $datetime->format('d/m/Y H:i'); // Hiển thị định dạng ngày/tháng/năm giờ:phút
?>
