<?php
include_once("ketnoi.php");
session_start();

header('Content-Type: application/json');

$id_user = $_SESSION['dangnhap']['id_user'] ?? null;
$id_role = $_SESSION['dangnhap']['id_role'] ?? null;

if ($id_user && $id_role) {
    $kn = new ketnoi();
    $conn = $kn->connect();

    // Lấy tất cả tin nhắn của user này
    $sql = "SELECT cauhoi, cautraloi, id_user, id_role, thoigian FROM chatbox WHERE id_user = '$id_user' ORDER BY thoigian ASC";
    $result = $conn->query($sql);

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    $kn->dongketnoi($conn);

    echo json_encode(['success' => true, 'messages' => $messages]);
} else {
    echo json_encode(['success' => false, 'error' => 'Chưa đăng nhập']);
}
?>