<?php
session_start();
include_once("../../controller/cBan.php");
$p = new CBan();
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Múi giờ Việt Nam



if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "cancel") {
    // Logic xử lý xóa đặt bàn
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_booking') {
    // Kiểm tra người dùng đã đăng nhập hay chưa
    if (!isset($_SESSION['dangnhap'])) {
        echo "<script>alert('Vui lòng đăng nhập để đặt bàn!'); window.location.href = 'index.php?page=dangnhap';</script>";
        exit();
    }

    $tenkh = $_POST['name'];
    $ngaydatban = $_POST['datetime'];
    $sdt = $_POST['phone'];
    $id_user = $_SESSION['dangnhap']['id_user'];
    $email = $_POST['email'];
    $ghichu = $_POST['message'];
    $soluong = $_POST['quantity'];

    if (!empty($tenkh) && !empty($ngaydatban) && !empty($sdt) && !empty($email) && !empty($soluong)) {
        // Tạo câu lệnh SQL để thêm đơn đặt bàn
        $sql = "INSERT INTO dondatban (tenkh, ngaydatban, sdt, id_user, email, ghichu, soluong) 
                VALUES ('$tenkh', '$ngaydatban', '$sdt', $id_user, '$email', '$ghichu', $soluong)";
        
        // Gọi phương thức getthemddb để thực hiện thêm
        $result = $p->getthemddb($sql);

        if ($result === 1) {
            echo "<script>alert('Đặt bàn thành công!'); window.location.href = 'index.php?page=home';</script>";
        } else {
            echo "<script>alert('Đặt bàn thất bại!');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="../layout/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
        .big-image {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 80%;
            position: relative;
            overflow: hidden;
        }
        .big-image::before {
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
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        .big-image::after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: black;
            opacity: 0.3;
            z-index: -2;
        }
        .big-image .big-image-content {
            text-align: center;
        }
        .big-image .big-image-content h2 {
            font-size: 50px;
            color: white;
            font-family: 'Dancing Script';
        }
        .big-image .big-image-content p {
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
        .slide-1 {
            background-image: url("https://arcviet.vn/wp-content/webp-express/webp-images/uploads/2016/07/thiet-ke-noi-that-nha-hang3.jpg.webp");
            background-size: cover;
            background-position: center;
        }
        .slide-2 {
            background-image: url('../../img/nha-hang-2.jpeg');
            background-size: cover;
            background-position: center;
        }
        .slide-3 {
            background-image: url('../../img/nha-hang-1.jpg');
            background-size: cover;
            background-position: center;
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
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        textarea {
            resize: none;
            height: 100px;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-submit:active {
            transform: scale(1);
        }

        .flex-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1.section-heading {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
            font-family: 'Arial', sans-serif;
            letter-spacing: 1px;
        }

        input::placeholder, textarea::placeholder {
            color: #aaa;
            font-style: italic;
        }

        section.about-meal {
            margin-bottom: 50px; /* Khoảng cách phía dưới phần "ĐẶT BÀN ONLINE" */
        }

        section.top-products {
            margin-bottom: 50px; /* Tạo khoảng cách giữa phần "THỰC ĐƠN" và footer */
        }

        footer {
            padding-top: 20px; /* Đảm bảo footer có khoảng cách bên trong */
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
            <!-- Form đặt bàn -->
            <form action="" method="POST">
                <input type="hidden" name="action" value="add_booking">
                <div class="form-group">
                    <label for="name">Tên của bạn</label>
                    <input type="text" id="name" name="name" placeholder="Nhập tên của bạn" required>
                </div>
                <div class="form-group">
                    <label for="datetime">Ngày giờ</label>
                    <input type="datetime-local" id="datetime" name="datetime" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Số lượng</label>
                    <input type="number" id="quantity" name="quantity" placeholder="Nhập số lượng" required>
                </div>
                <div class="form-group">
                    <label for="email">Email của bạn</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                </div>
                <div class="form-group">
                    <label for="message">Nội dung</label>
                    <textarea id="message" name="message" placeholder="Nhập nội dung"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-submit">ĐẶT LỊCH</button>
                </div>
            </form>
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
