<?php
include "../backend/config.php"; // Database connection file

// Fetch dynamic dropdown options (Example: Academic Years, Semester Types, Categories, Components, Subcomponents)
try {
    // Example: Fetch all academic years from the database (or generate them)
    $academic_years = [];
    $currentYear = date('Y');
    for ($i = 0; $i < 5; $i++) {
        $start = $currentYear + $i - 1;
        $end = $start + 1;
        $academic_years[] = "$start-$end";
    }
    // Static/Config data
    $semester_types = ['Odd', 'Even'];
    $main_categories = [
        'Assessment Type' => ['CA1', 'CA2', 'CA3', 'CA4', 'PCA1', 'PCA2'],
        'End Sem' => ['Theory', 'Practical', 'Exam Form Fill Up'],
        'Enrollment' => ['Regular', 'Backlog'],
        'Results' => ['Regular', 'Backlog']
    ];
    $theory_subcomponents = ['Seating Allotment','Attendance','Routine'];
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="academics.php">Academics</a></li>
            <li class="breadcrumb-item">Examination</li>
        </ol>
    </nav>

    <h3>Examination</h3>
    <p>Select examination options to search or add files.</p>

    <form id="examination-form">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label">Academic Year</label>
                <select class="form-select" id="academic_year" name="academic_year">
                    <option value="">Select Academic Year</option>
                    <?php foreach ($academic_years as $year): ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Semester Type</label>
                <select class="form-select" id="semester_type" name="semester_type">
                    <option value="">Select Semester</option>
                    <?php foreach ($semester_types as $type): ?>
                        <option value="<?= $type ?>"><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Main Category</label>
                <select class="form-select" id="main_category" name="main_category">
                    <option value="">Select Category</option>
                    <?php foreach ($main_categories as $cat => $opts): ?>
                        <option value="<?= $cat ?>"><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2" id="component-container" style="display:none;">
                <label class="form-label">Component</label>
                <select class="form-select" id="component" name="component"></select>
            </div>
            <div class="col-md-2" id="subcomponent-container" style="display:none;">
                <label class="form-label">Sub Component</label>
                <select class="form-select" id="sub_component" name="sub_component"></select>
            </div>
        </div>

        <div class="mt-3 d-flex align-items-center">
            <button type="button" class="btn btn-primary me-2" id="fetch-files">
                <i class="fas fa-search"></i> Search
            </button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Add
            </button>
        </div>
    </form>

    <div class="mt-4">
        <h4>File List</h4>
        <table class="table table-bordered table-striped" id="files-table">
            <thead class="table-dark">
                <tr>
                    <th>File Name</th>
                    <th>Uploaded At</th>
                    <th>File View</th>
                    <th>Location</th>
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

<!-- Add File Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addFileForm" enctype="multipart/form-data" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Examination File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label">Academic Year</label>
                        <select class="form-select" id="modal_academic_year" name="academic_year" required>
                            <option value="">Select Academic Year</option>
                            <?php foreach ($academic_years as $year): ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Semester Type</label>
                        <select class="form-select" id="modal_semester_type" name="semester_type" required>
                            <option value="">Select Semester</option>
                            <?php foreach ($semester_types as $type): ?>
                                <option value="<?= $type ?>"><?= $type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Main Category</label>
                        <select class="form-select" id="modal_main_category" name="main_category" required>
                            <option value="">Select Category</option>
                            <?php foreach ($main_categories as $cat => $opts): ?>
                                <option value="<?= $cat ?>"><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2" id="modal-component-container" style="display:none;">
                        <label class="form-label">Component</label>
                        <select class="form-select" id="modal_component" name="component"></select>
                    </div>
                    <div class="mb-2" id="modal-subcomponent-container" style="display:none;">
                        <label class="form-label">Sub Component</label>
                        <select class="form-select" id="modal_sub_component" name="sub_component"></select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="modal_file_upload" name="file_upload" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// JS dropdown logic, AJAX for search/add, and dynamic dependent fields
const mainOptions = <?= json_encode($main_categories) ?>;
const theoryOptions = <?= json_encode($theory_subcomponents) ?>;

function updateComponent(selId, compId, subCompId, compDiv, subCompDiv) {
    let mainCat = document.getElementById(selId).value;
    let comp = document.getElementById(compId);
    let subComp = document.getElementById(subCompId);
    let compDivElem = document.getElementById(compDiv);
    let subCompDivElem = document.getElementById(subCompDiv);

    comp.innerHTML = '<option value="">Select</option>';
    subComp.innerHTML = '<option value="">Select</option>';
    compDivElem.style.display = 'none';
    subCompDivElem.style.display = 'none';

    if (mainCat && mainOptions[mainCat]) {
        mainOptions[mainCat].forEach(function(opt) {
            comp.innerHTML += `<option value="${opt}">${opt}</option>`;
        });
        compDivElem.style.display = '';
    }
    if (mainCat === 'End Sem') {
        comp.onchange = function() {
            if (this.value === 'Theory') {
                theoryOptions.forEach(function(opt) {
                    subComp.innerHTML += `<option value="${opt}">${opt}</option>`;
                });
                subCompDivElem.style.display = '';
            } else {
                subComp.innerHTML = '<option value="">Select</option>';
                subCompDivElem.style.display = 'none';
            }
        };
    }
}

document.getElementById('main_category').addEventListener('change', function() {
    updateComponent('main_category', 'component', 'sub_component', 'component-container', 'subcomponent-container');
});
document.getElementById('modal_main_category').addEventListener('change', function() {
    updateComponent('modal_main_category', 'modal_component', 'modal_sub_component', 'modal-component-container', 'modal-subcomponent-container');
});

// Search files
document.getElementById('fetch-files').addEventListener('click', function() {
    let data = {
        academic_year: document.getElementById('academic_year').value,
        semester_type: document.getElementById('semester_type').value,
        main_category: document.getElementById('main_category').value,
        component: document.getElementById('component').value,
        sub_component: document.getElementById('sub_component').value
    };
    fetch('./backend/get_examination_files.php', {
        method: 'POST', body: new URLSearchParams(data)
    })
    .then(res=>res.json())
    .then(files=>{
        let tbody = document.querySelector("#files-table tbody");
        tbody.innerHTML = '';
        if (files.length) {
            files.forEach(file=>{
                tbody.innerHTML += `<tr>
                    <td>${file.file_name}</td>
                    <td>${file.uploaded_at}</td>
                    <td><a href="${file.file_path}" target="_blank" class="btn btn-info btn-sm">View</a></td>
                    <td>${file.file_path}</td>
                </tr>`;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No records found</td></tr>';
        }
    });
});

// Add file form
document.getElementById('addFileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let form = e.target;
    let formData = new FormData(form);
    fetch('./backend/add_examination_file.php', {
        method: 'POST', body: formData
    })
    .then(res=>res.json())
    .then(resp=>{
        alert(resp.message);
        if (resp.status === "success") {
            form.reset();
            var modal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
            modal.hide();
            document.getElementById('fetch-files').click();
        }
    })
    .catch(()=>alert("Error uploading file."));
});
</script>