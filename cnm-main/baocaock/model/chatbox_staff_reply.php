<?php
include_once("ketnoi.php");
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$id_user = $data['id_user'] ?? 0;
$cautraloi = $data['cautraloi'] ?? '';
$id_nv = $_SESSION['dangnhap']['id_user'] ?? null;
$thoigian = date('Y-m-d H:i:s');
file_put_contents('debug_reply.txt', print_r($data, true) . "\n", FILE_APPEND);

if ($id_nv && $cautraloi !== '' && $id_user) {
    $kn = new ketnoi();
    $conn = $kn->connect();
    $cautraloi = $conn->real_escape_string($cautraloi);
    $sql = "INSERT INTO chatbox SET cauhoi='', cautraloi='$cautraloi', id_user='$id_user', thoigian='$thoigian', id_role=1";
    file_put_contents('debug_reply.txt', $sql . "\n", FILE_APPEND);
    $result = $conn->query($sql);
    $kn->dongketnoi($conn);
    echo json_encode(['success' => $result]);
} else {
    echo json_encode(['success' => false, 'error' => 'Thiếu thông tin']);
}
?>