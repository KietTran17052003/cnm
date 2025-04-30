<?php
session_start();
if (!isset($_SESSION["dangnhap"])) {
    header("Location: ../../index.php?page=dangnhap");
    exit();
}

?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật món ăn</title>
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
        height: 110vh;
    }
    .content {
        flex-grow: 1;
        padding: 20px;
        background-color: #F0F0F0;
        overflow-y: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-top: 10px;
    }

    .form-group label {
        font-weight: bold;
        text-align: right;
        padding-right: 15px;
        width: 25%; /* Điều chỉnh độ rộng của nhãn */
    }

    .form-control {
        width: 60%; /* Điều chỉnh độ rộng của ô nhập liệu */
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .form-actions button {
        font-size: 1rem;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        color: inherit;
    }

    .form-actions button a {
        text-decoration: none;
        color: inherit;
    }

    .form-actions button:hover {
        text-decoration: underline;
    }

    img {
        margin-top: 10px;
        max-width: 100%; /* Đảm bảo hình ảnh không vượt quá khung */
        height: auto;
        border-radius: 5px;
    }
</style>
</head>
<body>
<div class="wrapper">
    <?php
    
    include_once("xuly.php"); // Include file xử lý
    include_once("../../model/mMonAn.php");
    include_once(__DIR__ . "/../../layout/sidebar.php");
    include_once("../../controller/cMonAn.php");
    include_once("../../controller/cLoaiMonAn.php");
    $pMonAn = new CMonAN();
    $pLoaiMonAn = new CLoaiMonAN();
    
    $idMonAn = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$idMonAn) {
        echo "<script>alert('Không tìm thấy món ăn!'); window.location.href = '../quanlymonan';</script>";
        exit();
    }
    
    $monAn = $pMonAn->getMaMonAn($idMonAn);
    if (!$monAn) {
        echo "<script>alert('Không tìm thấy món ăn!'); window.location.href = '../quanlymonan';</script>";
        exit();
    }
    
    $loaiMonAnList = $pLoaiMonAn->getAllLoaiMonAn();
    if (!$loaiMonAnList || $loaiMonAnList->num_rows == 0) {
        echo "<script>alert('Không có dữ liệu loại món ăn!');</script>";
    }
    ?>
    <div class="content">
        <h2 style="text-align: center; padding-bottom: 10px;">CẬP NHẬT MÓN ĂN</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idmonan" value="<?php echo $monAn['idmonan']; ?>">

            <!-- Tên món ăn -->
            <div class="form-group">
                <label for="tenmonan">Tên món ăn</label>
                <input type="text" id="tenmonan" class="form-control" name="tenmonan" value="<?php echo $monAn['tenmonan']; ?>" required>
            </div>

            <!-- Loại món ăn -->
            <div class="form-group">
                <label for="idloaimonan">Loại món ăn</label>
                <select id="idloaimonan" class="form-control" name="idloaimonan" required>
                    <option value="">- Chọn loại món ăn -</option>
                    <?php
                    if ($loaiMonAnList && $loaiMonAnList->num_rows > 0) {
                        while ($row = $loaiMonAnList->fetch_assoc()) {
                            $selected = ($row['idloaimon'] == $monAn['idloaimonan']) ? 'selected' : '';
                            echo "<option value='{$row['idloaimon']}' $selected>{$row['tenloai']}</option>";
                        }
                    } else {
                        echo "<option value=''>Không có dữ liệu</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Giá bán -->
            <div class="form-group">
                <label for="giaban">Giá bán (VNĐ)</label>
                <input type="number" id="giaban" class="form-control" name="giaban" value="<?php echo $monAn['giaban']; ?>" required>
            </div>

            <!-- Mô tả -->
            <div class="form-group">
                <label for="mota">Mô tả</label>
                <textarea id="mota" class="form-control" name="mota" rows="3" required><?php echo $monAn['mota']; ?></textarea>
            </div>

            <!-- Trạng thái -->
            <div class="form-group">
                <label for="trangthai">Trạng thái</label>
                <select id="trangthai" class="form-control" name="trangthai" required>
                    <option value="1" <?php echo $monAn['trangthai'] == 1 ? 'selected' : ''; ?>>Đang có</option>
                    <option value="2" <?php echo $monAn['trangthai'] == 2 ? 'selected' : ''; ?>>Hết món</option>
                </select>
            </div>

            <!-- Hình ảnh -->
            <div class="form-group">
                <label for="hinhanh">Hình ảnh</label>
                <div class="col-sm-5">
                    <input type="file" id="hinhanh" class="form-control" name="hinhanh">
                    <div style="margin-top: 10px;">
                        <p>Hình ảnh hiện tại:</p>
                        <?php
                        $imagePath = "../../img/" . $monAn['hinhanh'];
                        if (!empty($monAn['hinhanh']) && file_exists($imagePath)) {
                            echo "<div style='text-align: center;'>";
                            echo "<img src='$imagePath' alt='Hình ảnh món ăn' style='width: 200px; height: auto; border-radius: 5px;'>";
                            echo "</div>";
                            echo "<input type='hidden' name='hinhanh_cu' value='{$monAn['hinhanh']}'>";
                        } else {
                            echo "<p style='color: red;'>Hình ảnh không tồn tại</p>";
                            echo "<input type='hidden' name='hinhanh_cu' value=''>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Hành động -->
            <div class="form-actions py-3">
                <button class="btn btn-primary" style="border: none; background: none; padding: 0;">
                    <a href="index.php?page=quanly/quanlymonan" style="text-decoration: none; color: inherit;">Quay lại</a>
                </button>

                <button type="reset" class="btn btn-secondary" style="border: none; background: none; padding: 0;">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button type="submit" class="btn btn-success" onclick="return validateForm()" name="btnUpdate" style="border: none; background: none; padding: 0;">
                    <i class="far fa-save"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>