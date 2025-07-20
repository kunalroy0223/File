<?php
    include "./config.php"; // Database connection

    $affiliationId = $_POST['affiliation_id'];
    $academicYearId = $_POST['academic_year_id'];
    $universityOptionId = $_POST['university_option_id'];

    $query = "SELECT file_name, last_modified, file_path, office_location 
            FROM documents 
            WHERE affiliation_id = :affiliation_id 
            AND academic_year_id = :academic_year_id";

    $params = [':affiliation_id' => $affiliationId, ':academic_year_id' => $academicYearId];

    if ($universityOptionId) {
        $query .= " AND university_option_id = :university_option_id";
        $params[':university_option_id'] = $universityOptionId;
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($documents);
?>
