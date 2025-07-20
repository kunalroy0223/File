
<div class="container mt-4">
    <h3>Institution Policies</h3>
    <p>Manage and upload policies.</p>

    <!-- Upload Policy Form -->
    <form id="addPolicyForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="policy-title" class="form-label">Policy Title</label>
            <input type="text" class="form-control" id="policy-title" name="policy_title" required>
        </div>
        <div class="mb-3">
            <label for="policy-file" class="form-label">Upload Policy Document</label>
            <input type="file" class="form-control" id="policy-file" name="policy_file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Policy</button>
    </form>

    <hr>

    <!-- Policy List -->
    <h4>Policy List</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Policy Title</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody id="policy-list">
            <tr>
                <td colspan="3" class="text-center">Loading...</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>