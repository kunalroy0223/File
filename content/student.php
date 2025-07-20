<?php
include "../backend/config.php";
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="student.php">Students</a></li>
            <li class="breadcrumb-item">Manage Students</li>
        </ol>
    </nav>

    <h3>Manage Students</h3>
    <p>This page allows you to manage student lists, scholarships, and APAAR files. Select the Manage Type to begin.</p>

    <!-- Search/Filter Section -->
    <form id="searchForm" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="manage-type" class="form-label">Manage Type</label>
                <select class="form-select" id="manage-type" name="manage-type" required>
                    <option value="">Select Type</option>
                    <option value="student_list">Student List</option>
                    <option value="scholarship">Scholarship</option>
                    <option value="apaar">APAAR</option>
                </select>
            </div>
            <div class="col-md-2 d-none" id="batch-year-block">
                <label class="form-label">Batch Year</label>
                <select class="form-select" id="batch-year" name="batch-year">
                    <option value="">Select Year</option>
                </select>
            </div>
            <div class="col-md-3 d-none" id="department-block">
                <label class="form-label">School & Department</label>
                <select class="form-select" id="department" name="department">
                    <option value="">Select Department</option>
                </select>
            </div>
            <div class="col-md-3 d-none" id="scholarship-type-block">
                <label class="form-label">Scholarship Type</label>
                <select class="form-select" id="scholarship-type" name="scholarship-type">
                    <option value="">Select Scholarship Type</option>
                </select>
            </div>
            <div class="col-md-3 d-none" id="govt-scholarship-subtype-block">
                <label class="form-label">Government Scholarship</label>
                <select class="form-select" id="govt-scholarship-subtype" name="govt-scholarship-subtype">
                    <option value="">Select Option</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-primary" id="search-files">Search</button>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-success" id="add-file-btn" data-bs-toggle="modal" data-bs-target="#addFileModal" disabled>
                    <i class="fas fa-plus"></i> Add File
                </button>
            </div>
        </div>
    </form>

    <!-- File List Table (Dynamic) -->
    <div id="file-list-table" class="mb-4" style="display:none;">
        <h4>Files</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>File Name</th>
                    <th>Uploaded At</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody id="files-table-body">
                <tr><td colspan="3" class="text-center">No records found</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add File Modal -->
 <div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addFileForm" enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFileModalLabel">Add File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Your form fields remain unchanged -->
                     <form id="addFileForm" enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFileModalLabel">Add File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Manage Type</label>
                        <select class="form-select" id="add-manage-type" name="manage_type" required>
                            <option value="">Select Type</option>
                            <option value="student_list">Student List</option>
                            <option value="scholarship">Scholarship</option>
                            <option value="apaar">APAAR</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="add-batch-year-block">
                        <label class="form-label">Batch Year</label>
                       <select class="form-select" id="add-batch-year" name="batch_year">
                         <option value="">Select Year</option>
                       </select>
                    </div>
                    <div class="mb-3 d-none" id="add-department-block">
                        <label class="form-label">School & Department</label>
                        <select class="form-select" id="add-department" name="department">
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="add-scholarship-type-block">
                        <label class="form-label">Scholarship Type</label>
                        <select class="form-select" id="add-scholarship-type" name="scholarship_type">
                            <option value="">Select Scholarship Type</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="add-govt-scholarship-subtype-block">
                        <label class="form-label">Government Scholarship</label>
                        <select class="form-select" id="add-govt-scholarship-subtype" name="govt_scholarship_subtype">
                            <option value="">Select Option</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload File</label>
                        <input type="file" class="form-control" name="file_upload" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <span class="upload-text">Save</span>
                        <span class="upload-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Uploading...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add Bootstrap JS if not already on the page -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Helper: Capitalize for display
function capitalize(str) { return str.charAt(0).toUpperCase() + str.slice(1); }

// Loaders for dropdowns - FIXED to handle actual data vs IDs
function loadBatchYears(selector) {
    $.get('./backend/get_batch_years.php', function(response) {
        let years = response;
        if (typeof years === "string") years = JSON.parse(years);
        let select = $(selector);
        select.empty().append('<option value="">Select Year</option>');
        // Use the actual year value instead of ID for upload
        years.forEach(y => select.append(`<option value="${y.year}" data-id="${y.id}">${y.year}</option>`));
    });
}

function loadDepartments(selector) {
    $.get('./backend/get_departments.php', function(response) {
        let depts = response;
        if (typeof depts === "string") depts = JSON.parse(depts);
        let select = $(selector);
        select.empty().append('<option value="">Select Department</option>');
        // Use the department name instead of ID for upload
        depts.forEach(d => select.append(`<option value="${d.name}" data-id="${d.id}">${d.name}</option>`));
    });
}

function loadScholarshipTypes(selector) {
    $.get('./backend/get_scholarship_types.php', function(response) {
        let types = response;
        if (typeof types === "string") types = JSON.parse(types);
        let select = $(selector);
        select.empty().append('<option value="">Select Scholarship Type</option>');
        // Use the type value instead of ID for upload
        types.forEach(t => select.append(`<option value="${t.type}" data-id="${t.id}">${capitalize(t.type.replace('_',' '))}</option>`));
    });
}

function loadGovtScholarshipSubtypes(selector) {
    $.get('./backend/get_govt_scholarship_subtypes.php', function(response) {
        let subtypes = response;
        if (typeof subtypes === "string") subtypes = JSON.parse(subtypes);
        let select = $(selector);
        select.empty().append('<option value="">Select Option</option>');
        // Use the subtype name instead of ID for upload
        subtypes.forEach(opt => select.append(`<option value="${opt.name}" data-id="${opt.id}">${opt.name}</option>`));
    });
}

// --- Main Form Logic ---

// Show/hide filters based on manage type
$('#manage-type').on('change', function() {
    let type = $(this).val();
    $('#batch-year-block,#department-block,#scholarship-type-block,#govt-scholarship-subtype-block').addClass('d-none');
    $('#batch-year,#department,#scholarship-type,#govt-scholarship-subtype').val('');
    $('#add-file-btn').prop('disabled', !type);
    $('#file-list-table').hide();
    if(type === 'student_list') {
        $('#batch-year-block').removeClass('d-none'); loadBatchYears('#batch-year');
        $('#department-block').removeClass('d-none'); loadDepartments('#department');
    } else if(type === 'scholarship') {
        $('#scholarship-type-block').removeClass('d-none'); loadScholarshipTypes('#scholarship-type');
    }
});

// When scholarship type is selected, show government scholarship options if needed
$('#scholarship-type').on('change', function() {
    let type_text = $(this).val();
    $('#govt-scholarship-subtype-block').addClass('d-none');
    $('#govt-scholarship-subtype').val('');
    if(type_text === 'government' || type_text === 'govt') {
        $('#govt-scholarship-subtype-block').removeClass('d-none');
        loadGovtScholarshipSubtypes('#govt-scholarship-subtype');
    }
});

// --- Add File Modal Logic ---

$('#addFileModal').on('show.bs.modal', function() {
    // Copy current search filters to modal
    let type = $('#manage-type').val();
    $('#add-manage-type').val(type);

    // Hide all blocks first
    $('#add-batch-year-block,#add-department-block,#add-scholarship-type-block,#add-govt-scholarship-subtype-block').addClass('d-none');
    $('#add-batch-year,#add-department,#add-scholarship-type,#add-govt-scholarship-subtype').val('');

    // Show/hide blocks and load options as needed
    if(type === 'student_list') {
        $('#add-batch-year-block').removeClass('d-none'); 
        $('#add-department-block').removeClass('d-none'); 
        loadBatchYears('#add-batch-year');
        loadDepartments('#add-department');
        // Set current selection if available
        setTimeout(() => {
            $('#add-batch-year').val($('#batch-year').val());
            $('#add-department').val($('#department').val());
        }, 100);
    } else if(type === 'scholarship') {
        $('#add-scholarship-type-block').removeClass('d-none'); 
        loadScholarshipTypes('#add-scholarship-type');
        setTimeout(() => {
            $('#add-scholarship-type').val($('#scholarship-type').val());
            let schType = $('#scholarship-type').val();
            if(schType === 'government' || schType === 'govt') {
                $('#add-govt-scholarship-subtype-block').removeClass('d-none'); 
                loadGovtScholarshipSubtypes('#add-govt-scholarship-subtype');
                setTimeout(() => {
                    $('#add-govt-scholarship-subtype').val($('#govt-scholarship-subtype').val());
                }, 100);
            }
        }, 100);
    }
});

// In modal, dynamically show/hide sub-dropdowns
$('#add-manage-type').on('change', function() {
    let type = $(this).val();
    $('#add-batch-year-block,#add-department-block,#add-scholarship-type-block,#add-govt-scholarship-subtype-block').addClass('d-none');
    $('#add-batch-year,#add-department,#add-scholarship-type,#add-govt-scholarship-subtype').val('');
    if(type === 'student_list') {
        $('#add-batch-year-block').removeClass('d-none'); loadBatchYears('#add-batch-year');
        $('#add-department-block').removeClass('d-none'); loadDepartments('#add-department');
    } else if(type === 'scholarship') {
        $('#add-scholarship-type-block').removeClass('d-none'); loadScholarshipTypes('#add-scholarship-type');
    }
});

$('#add-scholarship-type').on('change', function() {
    let type_val = $(this).val();
    $('#add-govt-scholarship-subtype-block').addClass('d-none');
    $('#add-govt-scholarship-subtype').val('');
    if(type_val === 'government' || type_val === 'govt') {
        $('#add-govt-scholarship-subtype-block').removeClass('d-none');
        loadGovtScholarshipSubtypes('#add-govt-scholarship-subtype');
    }
});

// -- File Search and Table --

$('#search-files').on('click', function() {
    // Use IDs for search (database queries)
    let params = {
        manage_type: $('#manage-type').val(),
        batch_year_id: $('#batch-year option:selected').data('id') || $('#batch-year').val(),
        department_id: $('#department option:selected').data('id') || $('#department').val(),
        scholarship_type_id: $('#scholarship-type option:selected').data('id') || $('#scholarship-type').val(),
        govt_scholarship_subtype_id: $('#govt-scholarship-subtype option:selected').data('id') || $('#govt-scholarship-subtype').val()
    };
    loadFiles(params);
});

function loadFiles(params) {
    $.post('./backend/get_student_files.php', params, function(response) {
        let files = response;
        // Ensure files is an array, even if parsing fails or response is not an array
        if (typeof files === "string") {
            try {
                files = JSON.parse(files);
            } catch (e) {
                console.error("Failed to parse JSON response:", e);
                files = []; // Default to an empty array on parse failure
            }
        }
        // Explicitly check if files is an array before proceeding
        if (!Array.isArray(files)) {
             console.error("Expected an array response, but received:", files);
             files = []; // Default to an empty array if not an array
        }

        let tbody = $('#files-table-body');
        tbody.empty();
        if(files.length === 0) {
            tbody.append('<tr><td colspan="3" class="text-center">No records found</td></tr>');
            $('#file-list-table').show();
        } else {
            files.forEach(f => {
                tbody.append(
                    `<tr>
                        <td>${f.file_name}</td>
                        <td>${f.uploaded_at || f.created_at}</td>
                        <td><a href="${f.file_path}" target="_blank" class="btn btn-info btn-sm">View</a></td>
                    </tr>`
                );
            });
            $('#file-list-table').show();
        }
    }).fail(function() {
        alert('Error loading files. Please try again.');
    });
}

// --- FIXED File Upload ---


// --- FIXED File Upload ---
$('#addFileForm').on('submit', function(e) {
    e.preventDefault();

    const submitBtn = $(this).find('button[type="submit"]');
    const uploadText = submitBtn.find('.upload-text');
    const uploadLoading = submitBtn.find('.upload-loading');

    // Show loading state
    uploadText.addClass('d-none');
    uploadLoading.removeClass('d-none');
    submitBtn.prop('disabled', true);

    // Validate file input
    const fileInput = $('input[name="file_upload"]')[0];
    if (!fileInput || !fileInput.files.length) {
        alert('Please select a file to upload.');
        resetButton();
        return;
    }

    // Create form data
    const formData = new FormData();
    formData.append('manage_type', $('#add-manage-type').val());
    formData.append('batch_years', $('#add-batch-year').val());
    formData.append('department', $('#add-department').val());
    formData.append('scholarship_type', $('#add-scholarship-type').val());
    formData.append('govt_scholarship_subtype', $('#add-govt-scholarship-subtype').val());
    formData.append('file_upload', fileInput.files[0]);

    // Debug: Log form data
    console.log('Uploading:', {
        manage_type: $('#add-manage-type').val(),
        batch_years: $('#add-batch-year').val(),
        department: $('#add-department').val(),
        scholarship_type: $('#add-scholarship-type').val(),
        govt_scholarship_subtype: $('#add-govt-scholarship-subtype').val(),
        file: fileInput.files[0].name
    });

    $.ajax({
        url: './backend/store_student_file.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log('Server response:', response);
            let res;
            try {
                res = typeof response === 'object' ? response : JSON.parse(response);
            } catch (err) {
                alert('Server returned invalid JSON.');
                return;
            }

            if (res.status === 'success') {
                alert('File uploaded successfully!');
                const modalEl = document.getElementById('addFileModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                $('#addFileForm')[0].reset();
                $('#search-files').trigger('click'); // Reload file list
            } else {
                alert('Upload failed: ' + (res.message || 'Unknown error.'));
            }
        },
        error: function(xhr, status, error) {
            console.error('Upload failed:', xhr.responseText);
            alert('Error uploading file: ' + error);
        },
        complete: function() {
            resetButton();
        }
    });

    function resetButton() {
        uploadText.removeClass('d-none');
        uploadLoading.addClass('d-none');
        submitBtn.prop('disabled', false);
    }
});
</script>