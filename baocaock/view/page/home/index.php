<?php

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
                        <div class="about-meal-wrap flex">
                            <div class="flex-1">
                                <img src="../../img/nha-hang-tiec-cuoi-quan-1-hinh-anh-dep.jpg" alt="">
                            </div>
                            <div class="flex-1">
                                <h2>Đặt bàn dễ dàng – Đón tiếp trọn vẹn tại Savoria</h2>
                                <p style="margin-bottom: 2rem;">Bạn có thể chọn trước chỗ ngồi ưng ý, thời gian phù hợp và ghi chú mọi yêu cầu đặc biệt. 
                                    Đội ngũ Savoria sẽ chuẩn bị sẵn sàng để mang đến trải nghiệm ẩm thực tinh tế nhất dành riêng cho bạn.</p>
                                <p style="margin-bottom: 2rem;">Ưu đãi đặc biệt: Đặt bàn online trước 24h nhận ngay miễn phí món khai vị đặc trưng của nhà hàng.</p>
                                <p> <i class="fas fa-arrow-right"></i> Đặt bàn ngay hôm nay – tận hưởng không gian sang trọng – để mỗi khoảnh khắc tại Savoria thêm trọn vẹn.</p>
                                <!-- <button class="btn btn-secondary">Read More</button> -->
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
</script>