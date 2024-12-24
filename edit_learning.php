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
    $learning_development_id = decrypt_id($token);
    
    $query = "
            SELECT *
            FROM learning_development
            WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $learning_development_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $learning_development = $result->fetch_assoc();
        } else {
            echo "No record Found.";
            header("Location: learning.php");
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
    <title>Learning And Development</title>
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
                            Learning And Development (L&D) Interventions/Training Programs Attended 
                        </h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/update_learning.php" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($learning_development['id']) ?>">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" placeholder="Agency Employee Number" required value="<?= htmlspecialchars($learning_development['employee_no']) ?>" readonly>
                            </div>

                            <div class="col-md-12 mb-4" id="input-fields-container">
                                <div class="row">
                                    <!-- Career Service Fields -->
                                    <div class="col-md-12 mb-2">
                                        <label>30. Title Of Learning and Development Interventions/Training Programs (Write in full):</label>
                                        <input type="text" name="title[]" class="form-control" placeholder=" (Write in full)" value="<?= htmlspecialchars($learning_development['title']) ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>Inclusive Dates of Attendance:</label>
                                        <label>From</label>
                                        <input type="date" name="from_date[]" class="form-control" required value="<?= htmlspecialchars($learning_development['from_date']) ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>To</label>
                                        <input type="date" name="to_date[]" class="form-control" required value="<?= htmlspecialchars($learning_development['to_date']) ?>">
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label>Number of Hours:</label>
                                        <input type="number" name="hours[]" class="form-control" placeholder="Number of Hours" required value="<?= htmlspecialchars($learning_development['hours']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Type of I.D:</label>
                                        <select name="citizenship_type[]" class="form-control" required>
                                            <option ><?= htmlspecialchars($learning_development['citizenship_type']) ?></option>
                                            <option value="Managerial">Managerial</option>
                                            <option value="Supervisory">Supervisory</option>
                                            <option value="Technical">Technical</option>
                                            <option value="By Birth">By Birth</option>
                                            <option value="Other">Other</option>
                                        </select>

                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Conducted:</label>
                                        <input type="text" name="conducted_by[]" class="form-control" placeholder="Sponsored By (Write in full)" required value="<?= htmlspecialchars($learning_development['conducted_by']) ?>">
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
