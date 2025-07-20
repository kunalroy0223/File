<?php
    include "./config.php"; // Database connection

    $stmt = $conn->prepare("SELECT id, year FROM academic_years ORDER BY year DESC");
    $stmt->execute();
    $academicYears = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($academicYears);
?>
