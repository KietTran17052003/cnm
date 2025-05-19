<?php

include_once("ketnoi.php");
session_start();

header('Content-Type: application/json');

// Lấy dữ liệu từ fetch (POST dạng JSON)
$data = json_decode(file_get_contents("php://input"), true);

$cauhoi = $data['cauhoi'] ?? '';
$cautraloi = $data['cautraloi'] ?? '';
$id_user = $_SESSION['dangnhap']['id_user'] ?? null;
$id_role = $_SESSION['dangnhap']['id_role'] ?? null;
$thoigian = date('Y-m-d H:i:s');

file_put_contents('debug_chatbox.txt', print_r($_SESSION, true));

if ($id_user && $id_role && $cauhoi !== '') {
    $kn = new ketnoi();
    $conn = $kn->connect();
    $cauhoi = $conn->real_escape_string($cauhoi);
    $cautraloi = $conn->real_escape_string($cautraloi);

    $sql = "INSERT INTO chatbox (cauhoi, cautraloi, id_user, thoigian, id_role) 
            VALUES ('$cauhoi', '$cautraloi', '$id_user', '$thoigian', '$id_role')";
    $result = $conn->query($sql);

    $kn->dongketnoi($conn);

    echo json_encode(['success' => $result]);
} else {
    echo json_encode(['success' => false, 'error' => 'Thiếu thông tin']);
}
?>