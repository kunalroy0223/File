<?php
    include "./config.php"; // Database connection

$year = $_POST['year'] ?? '';
$semester = $_POST['semester'] ?? '';
$assessment = $_POST['assessment'] ?? '';
$component = $_POST['component'] ?? '';

if (!$year || !$semester || !$assessment || !$component) {
    echo "<p class='text-danger'>All fields are required.</p>";
    exit;
}

$stmt = $conn->prepare("
    SELECT student_name, marks 
    FROM examination_results 
    WHERE academic_year = :year 
    AND semester = :semester 
    AND assessment_type = :assessment 
    AND component = :component
");
$stmt->execute([
    ':year' => $year,
    ':semester' => $semester,
    ':assessment' => $assessment,
    ':component' => $component
]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    echo "<table class='table table-bordered mt-3'>
            <thead class='table-dark'><tr><th>Student Name</th><th>$component</th></tr></thead><tbody>";
    foreach ($results as $r) {
        echo "<tr><td>{$r['student_name']}</td><td>{$r['marks']}</td></tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<p class='text-warning'>No records found for the selected criteria.</p>";
}
?>
