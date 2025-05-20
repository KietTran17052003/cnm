<?php
include_once("ketnoi.php");
$data = json_decode(file_get_contents("php://input"), true);
$id_user = intval($data['id_user'] ?? 0);

if ($id_user > 0) {
    $kn = new ketnoi();
    $conn = $kn->connect();
    $sql = "UPDATE chatbox SET is_read=1 WHERE id_user=$id_user AND id_role=4 AND is_read=0";
    $conn->query($sql);
    $kn->dongketnoi($conn);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>