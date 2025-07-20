<?php
include "./config.php"; // Database connection

try {
    // Fetch university options (e.g., CWMS, CET, Registration)
    $stmt = $conn->prepare("SELECT id, option_name FROM university_options WHERE affiliation_id = 1");
    $stmt->execute();
    $options = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($options);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
