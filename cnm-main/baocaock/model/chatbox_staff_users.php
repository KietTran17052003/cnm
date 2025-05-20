<?php
include_once("ketnoi.php");
$kn = new ketnoi();
$conn = $kn->connect();

$sql = "SELECT u.id_user, u.hoten, u.sdt,
        (SELECT cautraloi FROM chatbox WHERE id_user=u.id_user AND cautraloi<>'' ORDER BY thoigian DESC LIMIT 1) as last_message,
        (SELECT COUNT(*) FROM chatbox WHERE id_user=u.id_user AND id_role=4 AND is_read=0) as unread_count
        FROM nguoidung u
        WHERE u.id_role=4
        ORDER BY u.id_user DESC";
$result = $conn->query($sql);

$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['unread_count'] = intval($row['unread_count']);
        $users[] = $row;
    }
}
$kn->dongketnoi($conn);
echo json_encode(['success' => true, 'users' => $users]);
?>