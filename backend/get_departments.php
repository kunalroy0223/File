<?php
include "config.php";
header('Content-Type: application/json');
$stmt = $conn->prepare("SELECT id, name FROM departments");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>