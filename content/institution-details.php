<?php
include "../backend/config.php"; // Database connection file

    try {
        $stmt = $conn->prepare("SELECT id, room_allocation	 FROM Institution");
        $stmt->execute();
        $affiliations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
?>

<div class="container">
    <!-- Breadcrumbs Section -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="institution.php">Instituion</a></li>
            <li class="breadcrumb-item">Institution Section</li>
        </ol>
    </nav>

    <h3>Instituion</h3>
    <p>Room Allocation</p>

    <!-- Form Container -->
    <form id="affiliation-form">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="affiliation" class="form-label">Room</label>
                <select class="form-select" id="affiliation" name="affiliation">
                    <option value="">Select Room</option>
                    <?php foreach ($affiliations as $affiliation) : ?>
                        <option value="<?= $affiliation['id'] ?>"><?= $affiliation['room_allocation'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4" id="academic-year-container" style="display:none;">
                <label for="academic-year" class="form-label">Academic Year</label>
                <select class="form-select" id="academic-year" name="academic-year">
                    <option value="">Select Academic Year</option>
                </select>
            </div>

            <div class="col-md-4" id="university-options-container" style="display:none;">
                <label for="university-options" class="form-label">University Options</label>
                <select class="form-select" id="university-options" name="university-options">
                    <option value="">Select Option</option>
                </select>
            </div>
        </div>

        <!-- Buttons: Submit + Add -->
        <div class="mt-3 d-flex align-items-center">
            <button type="button" class="btn btn-primary me-2" id="fetch-documents">
                <i class="fas fa-search"></i> Submit
            </button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>
    </form>

    <!-- Table for Showing Documents -->
    <div class="mt-4">
        <h4>Document List</h4>
        <table class="table table-bordered table-striped" id="documents-table">
            <thead class="table-dark">
                <tr>
                    <th>File Name</th>
                    <th>Last Modified</th>
                    <th>File View</th>
                    <th>Office Location</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center">No records found</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- 🔹 Modal with Dynamic Dropdowns -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add New Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="addDocumentForm" enctype="multipart/form-data" method="post">

                    <!-- 🔹 Dynamic Affiliation Type -->
                    <div class="mb-3">
                        <label class="form-label">Affiliation Type</label>
                        <select class="form-select" id="modal-affiliation" name="affiliation">
                            <option value="">Select Affiliation</option>
                        </select>
                    </div>

                    <!-- 🔹 Academic Year -->
                    <div class="mb-3">
                        <label class="form-label">Academic Year</label>
                        <select class="form-select" id="modal-academic-year" name="academic-year">
                            <option value="">Select Academic Year</option>
                        </select>
                    </div>

                    <!-- 🔹 University Options (Shown only when University is selected) -->
                    <div class="mb-3" id="modal-university-container" style="display:none;">
                        <label class="form-label">University Options</label>
                        <select class="form-select" id="modal-university-options" name="university-options">
                            <option value="">Select Option</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Name</label>
                        <input type="text" class="form-control" id="file-name" name="file-name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Location</label>
                        <input type="text" class="form-control" id="file-location" name="file-location" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="file-upload" name="file-upload" required>
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript (AJAX for Dynamic Dropdowns) -->
<script>
$(document).ready(function() {
    // Load Affiliation Types from Database
    function loadAffiliationTypes() {
        $.ajax({
            url: './backend/get_affiliations.php',
            type: 'GET',
            success: function(response) {
                var affiliations = JSON.parse(response);
                var affiliationSelect = $("#modal-affiliation");
                affiliationSelect.empty();
                affiliationSelect.append('<option value="">Select Affiliation</option>');
                $.each(affiliations, function(index, affiliation) {
                    affiliationSelect.append('<option value="'+affiliation.id+'">'+affiliation.affiliation_name+'</option>');
                });
            }
        });
    }

    // Load Academic Years
    function loadAcademicYears() {
        $.ajax({
            url: './backend/get_academic_year.php',
            type: 'GET',
            success: function(response) {
                var years = JSON.parse(response);
                var yearSelect = $("#modal-academic-year");
                yearSelect.empty();
                yearSelect.append('<option value="">Select Academic Year</option>');
                $.each(years, function(index, year) {
                    yearSelect.append('<option value="'+year.id+'">'+year.year+'</option>');
                });
            }
        });
    }

    loadAffiliationTypes(); // Call function to populate affiliations on page load
    loadAcademicYears(); // Call function to populate academic years on page load

    // Show University Options Based on Selection
    $("#modal-affiliation").change(function() {
        var selectedValue = $(this).val();
        if (selectedValue == "1") {
            $("#modal-university-container").show();
            loadUniversityOptions();
        } else {
            $("#modal-university-container").hide();
            $("#modal-university-options").empty();
        }
    });

    // Fetch University Options
    function loadUniversityOptions() {
        $.ajax({
            url: './backend/get_university_options.php',
            type: 'GET',
            success: function(response) {
                var options = JSON.parse(response);
                var universitySelect = $("#modal-university-options");
                universitySelect.empty();
                universitySelect.append('<option value="">Select Option</option>');
                $.each(options, function(index, option) {
                    universitySelect.append('<option value="'+option.id+'">'+option.option_name+'</option>');
                });
            }
        });
    }

    // Load Academic Year & University Options
    $("#affiliation").change(function() {
        var affiliationId = $(this).val();
        $("#academic-year-container, #university-options-container").hide();
        $("#academic-year, #university-options").empty();

        if (affiliationId) {
            $.ajax({
                url: './backend/get_academic_years.php',
                type: 'GET',
                data: { affiliation_id: affiliationId },
                success: function(data) {
                    if (data) {
                        var academicYears = JSON.parse(data);
                        $("#academic-year").append('<option value="">Select Academic Year</option>');
                        $.each(academicYears, function(i, year) {
                            $("#academic-year").append('<option value="' + year.id + '">' + year.year + '</option>');
                        });
                        $("#academic-year-container").show();

                        if (affiliationId == 1) {
                            $.ajax({
                                url: './backend/get_university_options.php',
                                type: 'GET',
                                success: function(optionsData) {
                                    var options = JSON.parse(optionsData);
                                    $("#university-options").append('<option value="">Select Option</option>');
                                    $.each(options, function(i, option) {
                                        $("#university-options").append('<option value="' + option.id + '">' + option.option_name + '</option>');
                                    });
                                    $("#university-options-container").show();
                                }
                            });
                        }
                    }
                }
            });
        }
    });

    // Fetch Documents on Submission
    $("#fetch-documents").click(function() {
        var affiliationId = $("#affiliation").val();
        var academicYearId = $("#academic-year").val();
        var universityOptionId = $("#university-options").val();

        $.ajax({
            url: './backend/get_documents.php',
            type: 'POST',
            data: { 
                affiliation_id: affiliationId, 
                academic_year_id: academicYearId, 
                university_option_id: universityOptionId 
            },
            success: function(response) {
                var documents = JSON.parse(response);
                var tableBody = $("#documents-table tbody");
                tableBody.empty();

                if (documents.length > 0) {
                    $.each(documents, function(i, doc) {
                        tableBody.append(
                            '<tr>' +
                                '<td>' + doc.file_name + '</td>' +
                                '<td>' + doc.last_modified + '</td>' +
                                '<td><a href="' + doc.file_path + '" target="_blank" class="btn btn-info btn-sm">View</a></td>' +
                                '<td>' + doc.office_location + '</td>' +
                            '</tr>'
                        );
                    });
                } else {
                    tableBody.append('<tr><td colspan="4" class="text-center">No records found</td></tr>');
                }
            }
        });
    });

    // Add New Document
    $('#addDocumentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: './backend/add_document.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === "success") {
                    alert(res.message);
                    $('#addModal').modal('hide');
                    $('#addDocumentForm')[0].reset();
                } else {
                    alert(res.message);
                }
            },
            error: function() {
                alert("Error uploading file. Please try again.");
            }
        });
    });
});
</script>