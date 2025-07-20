<?php
include "./config.php"; // Database connection

header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$response = ["status" => "error", "message" => "Unknown error"];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $affiliationId = $_POST['affiliation'] ?? '';
$academicyear = $_POST['academic-year'] ?? '';
$universityoptions = $_POST['university-options'] ?? null;
if ($universityoptions === '') {
    $universityoptions = null;
}
$officeLocation = $_POST['office-location'] ?? '';
$file = $_FILES['file-upload'] ?? null;
        // Fix: Convert empty string to null for integer column
        if ($universityoptions === '') {
            $universityoptions = null;
        }

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("No file uploaded or upload error!");
        }

        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['pdf'];
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("File type not allowed");
        }

        // Create directory structure
        $targetDir = __DIR__ . "/../uploads/affiliation/$affiliationId/$academicyear";
        if ($universityoptions) $targetDir .= "/$universityoptions";
        if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true)) {
            throw new Exception("Failed to create upload directory");
        }

        $savedFileName = basename($file['name']);
        $targetFile = $targetDir . "/" . $savedFileName;

        // Web-accessible path (NO leading slash)
        $webPath = "uploads/affiliation/$affiliationId/$academicyear";
        if ($universityoptions) $webPath .= "/$universityoptions";
        $filePath = $webPath . "/" . $savedFileName;
        $filePath = ltrim($filePath, '/');

        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            throw new Exception("Error uploading file");
        }

        $stmt = $conn->prepare("
            INSERT INTO documents 
            (affiliation_id, academic_year_id, university_option_id, file_name, office_location, file_path) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $affiliationId,
            $academicyear,
            $universityoptions, // this will be null if not set, fixing the SQL error
            $savedFileName,
            $officeLocation,
            $filePath
        ]);
        $response = ["status" => "success", "message" => "File uploaded successfully"];
    } else {
        throw new Exception("Invalid request");
    }
} catch (Exception $e) {
    $response = ["status" => "error", "message" => $e->getMessage()];
}
echo json_encode($response);
?>