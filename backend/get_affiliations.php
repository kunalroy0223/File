<?php
    include "./config.php";     // Database connection

    $stmt = $conn->prepare("SELECT id, affiliation_name FROM affiliation_data");
    $stmt->execute();
    $affiliations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($affiliations);
?>
