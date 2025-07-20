<?php
include "./config.php"; // Database connection

if (isset($_GET['affiliation_id'])) {
    $affiliationId = $_GET['affiliation_id'];

    try {
        // Fetch academic years based on selected affiliation
        $stmt = $conn->prepare("SELECT id, year FROM academic_years WHERE affiliation_id = :affiliation_id");
        $stmt->bindParam(':affiliation_id', $affiliationId, PDO::PARAM_INT);
        $stmt->execute();
        $academicYears = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($academicYears);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
