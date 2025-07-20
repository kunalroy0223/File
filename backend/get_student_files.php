<?php
include "./config.php";
header('Content-Type: application/json');

// Collect filter params (IDs expected)
$manage_type = trim($_POST['manage_type'] ?? '');
$batch_year_id = trim($_POST['batch_year_id'] ?? '');
$department_id = trim($_POST['department_id'] ?? '');
$scholarship_type_id = trim($_POST['scholarship_type_id'] ?? '');
$govt_scholarship_subtype_id = trim($_POST['govt_scholarship_subtype_id'] ?? '');

// Build query
$query = "SELECT file_name, file_path, uploaded_at FROM student_files WHERE 1=1";
$params = [];

if ($manage_type) {
    $query .= " AND manage_type = ?";
    $params[] = $manage_type;
}
if ($batch_year_id) {
    $query .= " AND batch_year_id = ?";
    $params[] = $batch_year_id;
}
if ($department_id) {
    $query .= " AND department_id = ?";
    $params[] = $department_id;
}
if ($scholarship_type_id) {
    $query .= " AND scholarship_type_id = ?";
    $params[] = $scholarship_type_id;
}
if ($govt_scholarship_subtype_id) {
    $query .= " AND govt_scholarship_subtype_id = ?";
    $params[] = $govt_scholarship_subtype_id;
}

$query .= " ORDER BY uploaded_at DESC";

try {
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($files);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
}
?>