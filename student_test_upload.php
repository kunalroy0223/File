<!-- Place this minimal HTML+JS for quick testing -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student File Upload Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap (only needed for modal, not necessary for upload logic) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<button data-bs-toggle="modal" data-bs-target="#addFileModal" class="btn btn-primary">Open Upload</button>
<div class="modal fade" id="addFileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addFileForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Student File</h5>
                </div>
                <div class="modal-body">
                    <input type="text" name="batch_year" placeholder="Batch Year" class="form-control mb-2" required>
                    <input type="text" name="department" placeholder="Department" class="form-control mb-2" required>
                    <input type="text" name="manage_type" placeholder="Manage Type" class="form-control mb-2" required>
                    <input type="file" name="file_upload" class="form-control mb-2" required>
                    <div id="uploadResult"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#addFileForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $('#uploadResult').text('Uploading...');
    $.ajax({
        url: './backend/add_student_file.php', // MAKE SURE THIS FILE EXISTS AND IS CORRECT
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(res) {
            let data;
            try {
                data = typeof res === "object" ? res : JSON.parse(res);
            } catch (e) {
                $('#uploadResult').text('Server error or invalid response: ' + res).css('color', 'red');
                return;
            }
            if (data.status === "success") {
                $('#uploadResult').text(data.message).css('color', 'green');
                $('#addFileForm')[0].reset();
            } else {
                $('#uploadResult').text(data.message).css('color', 'red');
            }
        },
        error: function(xhr, status, error) {
            $('#uploadResult').text('AJAX error: ' + error).css('color', 'red');
        }
    });
});
</script>
</body>
</html>