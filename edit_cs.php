<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once './config/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civil Service Eligibility</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include './util/head.php'; ?>

    <!-- Sidebar -->
    <?php include './util/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card mt-2">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">
                          Civil Service Eligibility
                        </h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/insert_civil_service.php" method="POST">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" placeholder="Agency Employee Number" required>
                            </div>

                            <div class="col-md-12 mb-4" id="input-fields-container">
                                <div class="row">
                                    <!-- Career Service Fields -->
                                    <div class="col-md-12 mb-2">
                                        <label>27. Career Service:</label>
                                        <input type="text" name="career[]" class="form-control" placeholder="RA 1080(BOARD/BAR)Under Special Laws/CES/CSEE/Barangay Eligibility/Drivers License">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Rating:</label>
                                        <input type="text" name="rating[]" class="form-control" placeholder="(if applicable)">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Date of Examination/Conferment:</label>
                                        <input type="date" name="date_exam[]" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Place of Examination/Conferment:</label>
                                        <input type="text" name="place_exam[]" class="form-control" placeholder="Place of Examination">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>License:</label>
                                        <input type="text" name="license_no[]" class="form-control" placeholder="Number & Date of Validity (if applicable)">
                                    </div>
                                </div>
                            </div>

                            <!-- Add/Remove Buttons -->
                            <div class="col-md-12 mb-2 text-right">
                                <button type="button" id="add-field" class="btn btn-success">Add Another</button>
                                <button type="button" id="remove-field" class="btn btn-danger" style="display:none;">Remove</button>
                            </div>

                            <!-- Submission Buttons -->
                            <div class="col-12 text-right mt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                           
                            </div>
                        </div>
                    </form>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <?php include './util/footer.php'; ?>

</div>

<!-- Scripts -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
<script>
    // Add and remove fields functionality
    const addButton = document.getElementById('add-field');
    const removeButton = document.getElementById('remove-field');
    const container = document.getElementById('input-fields-container');

    addButton.addEventListener('click', function() {
        // Clone the existing input fields and append them
        const newFields = container.children[0].cloneNode(true);
        container.appendChild(newFields);

        // Show remove button when there's more than one set of fields
        if (container.children.length > 1) {
            removeButton.style.display = 'inline-block';
        }
    });

    removeButton.addEventListener('click', function() {
        if (container.children.length > 1) {
            // Remove the last set of fields
            container.removeChild(container.lastElementChild);
        }

        // Hide remove button if only one set of fields remains
        if (container.children.length === 1) {
            removeButton.style.display = 'none';
        }
    });
</script>
</body>
</html>
