<?php
include_once("ketnoi.php");
header('Content-Type: application/json');
$id_user = $_GET['id_user'] ?? 0;
$kn = new ketnoi();
$conn = $kn->connect();
$sql = "SELECT cauhoi, cautraloi, id_role, thoigian FROM chatbox WHERE id_user = '$id_user' ORDER BY thoigian ASC";
$result = $conn->query($sql);
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
$kn->dongketnoi($conn);
echo json_encode(['success' => true, 'messages' => $messages]);
?>