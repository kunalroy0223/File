<?php
include "./config.php"; // Your PDO connection

header('Content-Type: application/json');

// Get POST fields
$year = $_POST['academic_year'] ?? '';
$semester = $_POST['semester_type'] ?? '';
$category = $_POST['main_category'] ?? '';
$component = $_POST['component'] ?? '';
$subcomponent = $_POST['sub_component'] ?? '';
$filename = basename($_FILES['file_upload']['name'] ?? '');

// This is the directory for moving the file (filesystem)
$save_dir = __DIR__ . "/../uploads/examination/$year/$semester/$category";
if ($component) $save_dir .= "/$component";
if ($subcomponent) $save_dir .= "/$subcomponent";
if (!is_dir($save_dir)) mkdir($save_dir, 0777, true);

$target_file = $save_dir . "/" . $filename;

// This is the web path to save in the database (NO leading slash)
$web_path = "uploads/examination/$year/$semester/$category";
if ($component) $web_path .= "/$component";
if ($subcomponent) $web_path .= "/$subcomponent";
$file_path = $web_path . "/" . $filename;

// Remove any accidental leading "/" from $file_path (defensive)
$file_path = ltrim($file_path, '/');

if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO examination_files 
        (academic_year, semester_type, main_category, assessment_component, endsem_component, theory_subcomponent, enrollment_type, results_type, file_name, file_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $year, $semester, $category,
        $category === 'Assessment Type' ? $component : null,
        $category === 'End Sem' ? $component : null,
        $category === 'End Sem' && $component === 'Theory' ? $subcomponent : null,
        $category === 'Enrollment' ? $component : null,
        $category === 'Results' ? $component : null,
        $filename, $file_path
    ]);
    echo json_encode(["status" => "success", "message" => "File uploaded successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "File upload failed!"]);
}
?>