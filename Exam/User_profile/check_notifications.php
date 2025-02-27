<?php
session_start();
include '../../admin/config.php';
$user_id = $_SESSION['user_id'];
$sql = "UPDATE notifications SET status = 1 WHERE user_id = '$user_id'";
$conn->query($sql);

echo json_encode(['success' => true]);
?>
