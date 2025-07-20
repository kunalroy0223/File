<?php
include "./config.php"; // Your PDO connection

header('Content-Type: application/json');

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug: Log all received data
error_log("POST data: " . print_r($_POST, true));
error_log("FILES data: " . print_r($_FILES, true));

try {
    // Check if file was uploaded
    if (!isset($_FILES['file_upload'])) {
        echo json_encode(["status" => "error", "message" => "No file uploaded. Check form enctype='multipart/form-data'"]);
        exit;
    }

    // Check for upload errors
    $upload_error = $_FILES['file_upload']['error'];
    if ($upload_error !== UPLOAD_ERR_OK) {
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE in HTML form',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
        ];
        
        $error_msg = $error_messages[$upload_error] ?? "Unknown upload error: $upload_error";
        echo json_encode(["status" => "error", "message" => $error_msg]);
        exit;
    }

    // Get POST fields with validation (IDs expected)
    $manage_type = trim($_POST['manage_type'] ?? '');
    $batch_year_id = trim($_POST['batch_year_id'] ?? '');
    $department_id = trim($_POST['department_id'] ?? '');
    $scholarship_type_id = trim($_POST['scholarship_type_id'] ?? '');
    $govt_scholarship_subtype_id = trim($_POST['govt_scholarship_subtype_id'] ?? '');

    // Validate required fields
    if (empty($manage_type)) {
        echo json_encode(["status" => "error", "message" => "Required field missing: manage_type"]);
        exit;
    }

    // Get and validate filename
    $original_filename = $_FILES['file_upload']['name'];
    if (empty($original_filename)) {
        echo json_encode(["status" => "error", "message" => "No filename provided"]);
        exit;
    }

    // Sanitize filename
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($original_filename));
    
    // Check file size (optional - adjust as needed)
    $max_size = 10 * 1024 * 1024; // 10MB
    if ($_FILES['file_upload']['size'] > $max_size) {
        echo json_encode(["status" => "error", "message" => "File too large. Maximum size: 10MB"]);
        exit;
    }

    // Use absolute path to your specific uploads directory
    $base_upload_dir = "/opt/lampp/htdocs/f/uploads";
    
    // Create base uploads directory if it doesn't exist
    if (!is_dir($base_upload_dir)) {
        if (!mkdir($base_upload_dir, 0755, true)) {
            echo json_encode([
                "status" => "error", 
                "message" => "Failed to create base uploads directory: $base_upload_dir",
                "debug" => [
                    "directory" => $base_upload_dir,
                    "parent_exists" => is_dir(dirname($base_upload_dir)),
                    "parent_writable" => is_writable(dirname($base_upload_dir))
                ]
            ]);
            exit;
        }
    }

    // Directory structure for uploads (by type, year, etc.)
    $save_dir = $base_upload_dir . "/student/" . $manage_type;
    if ($batch_year_id) $save_dir .= "/$batch_year_id";
    if ($department_id) $save_dir .= "/$department_id";
    if ($scholarship_type_id) $save_dir .= "/$scholarship_type_id";
    if ($govt_scholarship_subtype_id) $save_dir .= "/$govt_scholarship_subtype_id";

    // Create directory with proper permissions
    if (!is_dir($save_dir)) {
        if (!mkdir($save_dir, 0755, true)) {
            echo json_encode([
                "status" => "error", 
                "message" => "Directory creation failed: $save_dir. Check permissions.",
                "debug" => [
                    "save_dir" => $save_dir,
                    "parent_writable" => is_writable(dirname($save_dir)),
                    "parent_exists" => is_dir(dirname($save_dir)),
                    "current_user" => get_current_user(),
                    "process_owner" => function_exists('posix_getpwuid') ? (posix_getpwuid(posix_geteuid())['name'] ?? 'unknown') : 'unknown'
                ]
            ]);
            exit;
        }
    }

    // Check if directory is writable
    if (!is_writable($save_dir)) {
        // Try to fix permissions
        chmod($save_dir, 0755);
        if (!is_writable($save_dir)) {
            echo json_encode([
                "status" => "error", 
                "message" => "Directory not writable: $save_dir",
                "debug" => [
                    "save_dir" => $save_dir,
                    "permissions" => substr(sprintf('%o', fileperms($save_dir)), -4),
                    "owner" => fileowner($save_dir),
                    "group" => filegroup($save_dir),
                    "current_user" => get_current_user()
                ]
            ]);
            exit;
        }
    }

    // Handle duplicate filenames
    $target_file = $save_dir . "/" . $filename;
    $counter = 1;
    $file_info = pathinfo($filename);
    $base_name = $file_info['filename'];
    $extension = isset($file_info['extension']) ? '.' . $file_info['extension'] : '';
    while (file_exists($target_file)) {
        $new_filename = $base_name . "_$counter" . $extension;
        $target_file = $save_dir . "/" . $new_filename;
        $filename = $new_filename;
        $counter++;
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_file)) {
        echo json_encode([
            "status" => "error", 
            "message" => "Failed to move uploaded file",
            "debug" => [
                "tmp_name" => $_FILES['file_upload']['tmp_name'],
                "target_file" => $target_file,
                "tmp_exists" => file_exists($_FILES['file_upload']['tmp_name']),
                "target_dir_writable" => is_writable($save_dir),
                "tmp_is_uploaded" => is_uploaded_file($_FILES['file_upload']['tmp_name']),
                "disk_free_space" => disk_free_space($save_dir)
            ]
        ]);
        exit;
    }

    // Build web path for database (relative path)
    $web_path = "uploads/student/$manage_type";
    if ($batch_year_id) $web_path .= "/$batch_year_id";
    if ($department_id) $web_path .= "/$department_id";
    if ($scholarship_type_id) $web_path .= "/$scholarship_type_id";
    if ($govt_scholarship_subtype_id) $web_path .= "/$govt_scholarship_subtype_id";
    $file_path = $web_path . "/" . $filename;

    // Insert record in database (IDs for foreign keys, match your table definition)
    $stmt = $conn->prepare("INSERT INTO student_files 
        (manage_type, batch_year_id, department_id, scholarship_type_id, govt_scholarship_subtype_id, file_name, file_path, uploaded_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    
    $stmt->execute([
        $manage_type,
        $batch_year_id ?: null,
        $department_id ?: null,
        $scholarship_type_id ?: null,
        $govt_scholarship_subtype_id ?: null,
        $filename,
        $file_path
    ]);

    echo json_encode([
        "status" => "success", 
        "message" => "File uploaded successfully!",
        "file_path" => $file_path,
        "file_name" => $filename,
        "full_path" => $target_file
    ]);

} catch(PDOException $e) {
    echo json_encode([
        "status" => "error", 
        "message" => "Database error: " . $e->getMessage()
    ]);
} catch(Exception $e) {
    echo json_encode([
        "status" => "error", 
        "message" => "Unexpected error: " . $e->getMessage()
    ]);
}
?>