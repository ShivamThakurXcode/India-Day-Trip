<?php
session_start();
require_once '../config.php';
checkAdminLogin();

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->execute([$id]);
$tour = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($tour);
?>