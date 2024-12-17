<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once './config/conn.php';
require './util/encrypt_helper.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $work_experience_id = decrypt_id($token);

    $query = "
            SELECT *
            FROM work_experience
            WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $work_experience_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $work_experience = $result->fetch_assoc();
        } else {
            echo "No record Found.";
            exit();
        }
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Experience</title>
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
                             Work Experience
                        </h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/update_workexp.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($work_experience['id']) ?>">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" value="<?= htmlspecialchars($work_experience['employee_no']) ?>" placeholder="Agency Employee Number" required>
                            </div>

                            <div class="col-md-12 mb-4" id="input-fields-container">
                                <div class="row">
                                    <!-- Career Service Fields -->
                                    <div class="col-md-6 mb-2">
                                        <label>28. Inclusive Date</label>
                                        <label>From</label>
                                        <input type="date" name="from[]" class="form-control" value="<?= htmlspecialchars($work_experience['from_date']) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>To</label>
                                        <input type="date" name="to[]" class="form-control" value="<?= htmlspecialchars($work_experience['to_date']) ?>" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Position Title:</label>
                                        <input type="text" name="position[]" class="form-control" value="<?= htmlspecialchars($work_experience['position']) ?>" placeholder="(Write in full/Do not abbreviate)" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Department/Agency/Office/Company:</label>
                                        <input type="text" name="department[]" class="form-control" value="<?= htmlspecialchars($work_experience['department']) ?>" placeholder="(Write in full/Do not abbreviate)" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Monthly Salary:</label>
                                        <input type="text" name="salary[]" class="form-control" value="<?= htmlspecialchars($work_experience['salary']) ?>" placeholder="Monthly Salary" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Salary/Job/Pay Grade:</label>
                                        <input type="text" name="salary_grade[]" class="form-control" value="<?= htmlspecialchars($work_experience['salary_grade']) ?>" placeholder="(if applicable) Step (format *00-0*)/Increment" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Status of Appointment:</label>
                                        <input type="text" name="status_appointment[]" class="form-control" value="<?= htmlspecialchars($work_experience['status_appointment']) ?>" placeholder="(if applicable) Step (format *00-0*)/Increment" required>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <label>Gov't Service:</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="gov[]" class="form-check-input" id="gov_yes" value="yes" <?= $work_experience['gov_service'] == 'yes' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="gov_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="gov[]" class="form-check-input" id="gov_no" value="no" <?= $work_experience['gov_service'] == 'no' ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="gov_no">No</label>
                                        </div>
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
<script src="./assets/js/script.js"></script>
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
