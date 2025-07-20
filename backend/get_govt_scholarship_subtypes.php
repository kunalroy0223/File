<?php
include "./config.php";
header('Content-Type: application/json');
$stmt = $conn->prepare("SELECT id, name FROM government_scholarship_subtypes");
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>