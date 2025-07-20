<?php
include "../backend/config.php";

// Fetch affiliations
$affiliations = $conn->query("SELECT id, affiliation_name FROM affiliation_data")->fetchAll(PDO::FETCH_ASSOC);
// Fetch academic years (normalized table assumed)
$academic_years = $conn->query("SELECT id, year FROM academic_years ORDER BY year DESC")->fetchAll(PDO::FETCH_ASSOC);
?><div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="academics.php">Academics</a></li>
            <li class="breadcrumb-item">Affiliation & Approval</li>
        </ol>
    </nav>

    <h3>Affiliation & Approval</h3>
    <p>Select affiliation details to view or add documents.</p>

    <form id="affiliation-form">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label">Affiliation Type</label>
                <select class="form-select" id="affiliation" name="affiliation">
                    <option value="">Select Affiliation</option>
                    <?php foreach ($affiliations as $aff): ?>
                        <option value="<?= $aff['id'] ?>"><?= htmlspecialchars($aff['affiliation_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Academic Year</label>
                <select class="form-select" id="academic-year" name="academic-year">
                    <option value="">Select Academic Year</option>
                    <?php foreach ($academic_years as $year): ?>
                        <option value="<?= $year['id'] ?>"><?= htmlspecialchars($year['year']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3" id="university-options-container" style="display:none;">
                <label class="form-label">University Options</label>
                <select class="form-select" id="university-options" name="university-options">
                    <option value="">Select Option</option>
                </select>
            </div>
        </div>

        <div class="mt-3 d-flex align-items-center">
            <button type="button" class="btn btn-primary me-2" id="fetch-documents">
                <i class="fas fa-search"></i> Show Documents
            </button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Add Document
            </button>
        </div>
    </form>

    <div class="mt-4">
        <h4>Document List</h4>
        <table class="table table-bordered table-striped" id="documents-table">
            <thead class="table-dark">
                <tr>
                    <th>File Name</th>
                    <th>Office Location</th>
                    <th>File View</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="3" class="text-center">No records found</td></tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Add File Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addDocumentForm" enctype="multipart/form-data" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add New Affiliation Document</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label class="form-label">Affiliation Type</label>
            <select class="form-select" id="modal-affiliation" name="affiliation" required>
              <option value="">Select Affiliation</option>
              <?php foreach ($affiliations as $aff): ?>
                  <option value="<?= $aff['id'] ?>"><?= htmlspecialchars($aff['affiliation_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">Academic Year</label>
            <select class="form-select" id="modal-academic-year" name="academic-year" required>
              <option value="">Select Academic Year</option>
              <?php foreach ($academic_years as $year): ?>
                  <option value="<?= $year['id'] ?>"><?= htmlspecialchars($year['year']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-2" id="modal-university-container" style="display:none;">
            <label class="form-label">University Options</label>
            <select class="form-select" id="modal-university-options" name="university-options">
              <option value="">Select Option</option>
            </select>
          </div>
          <div class="mb-2">
            <label class="form-label">Office Location</label>
            <input type="text" class="form-control" name="office-location" required>
          </div>
          <div class="mb-2">
            <label class="form-label">Upload File</label>
            <input type="file" class="form-control" name="file-upload" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
$('#affiliation').on('change', function() {
    if ($(this).val() == "1") {
        $('#university-options-container').show();
        $.get('./backend/get_university_options.php', function(response) {
            var options = JSON.parse(response);
            var sel = $("#university-options");
            sel.empty().append('<option value="">Select Option</option>');
            $.each(options, function(_, opt) {
                sel.append('<option value="' + opt.id + '">' + opt.option_name + '</option>');
            });
        });
    } else {
        $('#university-options-container').hide();
        $('#university-options').empty().append('<option value="">Select Option</option>');
    }
});
$('#modal-affiliation').on('change', function() {
    if ($(this).val() == "1") {
        $('#modal-university-container').show();
        $.get('./backend/get_university_options.php', function(response) {
            var options = JSON.parse(response);
            var sel = $("#modal-university-options");
            sel.empty().append('<option value="">Select Option</option>');
            $.each(options, function(_, opt) {
                sel.append('<option value="' + opt.id + '">' + opt.option_name + '</option>');
            });
        });
    } else {
        $('#modal-university-container').hide();
        $('#modal-university-options').empty().append('<option value="">Select Option</option>');
    }
});

$('#fetch-documents').on('click', function() {
    var data = {
        affiliation_id: $('#affiliation').val(),
        academic_year_id: $('#academic-year').val(),
        university_option_id: $('#university-options').val()
    };
    $.post('./backend/get_documents.php', data, function(resp) {
        var documents = JSON.parse(resp);
        var tbody = $("#documents-table tbody");
        tbody.empty();
        if (documents.length) {
            $.each(documents, function(i, doc) {
                tbody.append(
                    '<tr>'+
                        '<td>'+doc.file_name+'</td>'+
                        '<td>'+doc.office_location+'</td>'+
                        '<td><a href="/f/'+doc.file_path+'" target="_blank" class="btn btn-info btn-sm">View</a></td>'+
                    '</tr>'
                );
            });
        } else {
            tbody.append('<tr><td colspan="3" class="text-center">No records found</td></tr>');
        }
    });
});

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
            var res = (typeof response === "string") ? JSON.parse(response) : response;
            if (res && res.status && res.message) {
                alert(res.message);
                if (res.status === "success") {
                    $('#addModal').modal('hide');
                    $('#addDocumentForm')[0].reset();
                    $('#fetch-documents').click();
                }
            } else {
                alert("Unexpected server response. Please try again.");
            }
        },
        error: function(xhr) {
            alert("Error uploading file. Please try again.\n" + xhr.responseText);
        }
    });
});
</script>
