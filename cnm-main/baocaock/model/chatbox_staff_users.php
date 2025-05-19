<?php
include_once("ketnoi.php");
header('Content-Type: application/json');
$kn = new ketnoi();
$conn = $kn->connect();

// Lấy thông tin khách hàng từ bảng nguoidung
$sql = "SELECT c.id_user, n.hoten, n.sdt, MAX(c.thoigian) as last_time
        FROM chatbox c
        LEFT JOIN nguoidung n ON c.id_user = n.id_user
        WHERE c.id_role = 4
        GROUP BY c.id_user
        ORDER BY last_time DESC";

$result = $conn->query($sql);
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
$kn->dongketnoi($conn);
echo json_encode(['success' => true, 'users' => $users]);
?>