<?php
include "./config.php";
header('Content-Type: application/json');
$stmt = $conn->prepare("SELECT id, year FROM batch_years ORDER BY year DESC");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>