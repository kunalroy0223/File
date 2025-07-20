<?php
include "./config.php"; // PDO $conn

header('Content-Type: application/json');

$year = $_POST['academic_year'] ?? '';
$semester = $_POST['semester_type'] ?? '';
$category = $_POST['main_category'] ?? '';
$component = $_POST['component'] ?? '';
$subcomponent = $_POST['sub_component'] ?? '';

$where = "academic_year=? AND semester_type=? AND main_category=?";
$params = [$year, $semester, $category];

if ($category === 'Assessment Type') {
    $where .= " AND assessment_component=?";
    $params[] = $component;
}
if ($category === 'End Sem') {
    $where .= " AND endsem_component=?";
    $params[] = $component;
    if ($component === 'Theory' && $subcomponent) {
        $where .= " AND theory_subcomponent=?";
        $params[] = $subcomponent;
    }
}
if ($category === 'Enrollment') {
    $where .= " AND enrollment_type=?";
    $params[] = $component;
}
if ($category === 'Results') {
    $where .= " AND results_type=?";
    $params[] = $component;
}

$stmt = $conn->prepare("SELECT file_name, file_path, uploaded_at FROM examination_files WHERE $where ORDER BY uploaded_at DESC");
$stmt->execute($params);
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($files);
?>