<?php
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include required files
require_once './config/conn.php';
require './util/encrypt_helper.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $employee_id = decrypt_id($token);

    // Fetch employee details
    $employeeQuery = $conn->prepare("
        SELECT 
            id AS employee_id,
            CONCAT(last_name, ', ', first_name, ' ', IFNULL(middle_name, ''), ' ', IFNULL(extension_name, '')) AS name,
            sex, 
            civil_status, 
            date_hired 
        FROM employees 
        WHERE id = ?
    ");
    $employeeQuery->bind_param("i", $employee_id);
    $employeeQuery->execute();
    $employeeResult = $employeeQuery->get_result();
    
    if ($employeeResult->num_rows > 0) {
        $employee = $employeeResult->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit;
    }

    // Fetch the most recent leave card data
    $leaveCardQuery = $conn->prepare("
        SELECT 
            year, 
            le_vac, 
            le_sck,
            from_to,
            lt_wp_vac,
            lt_wp_sck,
            lt_np_vac,
            lt_np_sck,
            u_vac,
            u_sck,
            b_vac,
            b_sck,
            p_initial,
            p_date
        FROM pelc 
        WHERE employee_id = ? 
        ORDER BY id DESC 
        LIMIT 1
    ");
    $leaveCardQuery->bind_param("i", $employee_id);
    $leaveCardQuery->execute();
    $leaveCardResult = $leaveCardQuery->get_result();

    $leaveCard = $leaveCardResult->num_rows > 0 ? $leaveCardResult->fetch_assoc() : null;

    // Free results and close statements
    $employeeQuery->close();
    $leaveCardQuery->close();
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Credits</title>
    <!-- AdminLTE and CSS -->
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
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="card-header w-100">
                        <div class="row p-2 bg-primary">
                            <div class="col">
                                <strong>Employee Name:</strong> <span><?= htmlspecialchars($employee['name']) ?></span>
                            </div>
                            <div class="col">
                                <strong>Sex:</strong> <span><?= htmlspecialchars($employee['sex']) ?></span>
                            </div>
                            <div class="col">
                                <strong>Civil Status:</strong> <span><?= htmlspecialchars($employee['civil_status']) ?></span>
                            </div>
                            <div class="col">
                                <strong>Date Hired:</strong> <span><?= htmlspecialchars($employee['date_hired']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <?php include './util/session-message.php'; ?>
                <div class="row">
                    <div class="col-lg-12 mt-2">
                        <form action="forms/insert_newCredits.php" method="post">
                            <input type="hidden" name="employee_id" value="<?= htmlspecialchars($employee['employee_id']) ?>">

                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h5>Add New Credits for Leave Card</h5>
                                </div>
                                <div class="card-body p-5">
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Leaves Earned</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Year:</label>
                                                <input type="number" name="year" class="form-control" value="<?= htmlspecialchars($leaveCard['year'] ?? '') ?>" placeholder="Enter Year">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Vacation:</label>
                                                <input type="number" step="0.01" name="le_vac" class="form-control" value="<?= htmlspecialchars($leaveCard['le_vac'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Sick:</label>
                                                <input type="number" step="0.01" name="le_sck" class="form-control" value="<?= htmlspecialchars($leaveCard['le_sck'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Credits From - To:</label>
                                                <input type="text" name="from_to" class="form-control" value="<?= htmlspecialchars($leaveCard['from_to'] ?? '') ?>" placeholder="From-To">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!-- Leaves Taken -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Leaves Taken</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">With Pay Vacation:</label>
                                                <input type="number" step="0.01" name="lt_wp_vac" class="form-control"  value="<?= htmlspecialchars($leaveCard['lt_wp_vac'] ?? '') ?>" placeholder="Enter Leave with Pay Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">With Pay Sick:</label>
                                                <input type="number" step="0.01" name="lt_wp_sck" class="form-control" value="<?= htmlspecialchars($leaveCard['lt_wp_sck'] ?? '') ?>" placeholder="Enter Leave with Pay Sick">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Without Pay Vacation:</label>
                                                <input type="number" step="0.01" name="lt_np_vac" class="form-control" value="<?= htmlspecialchars($leaveCard['lt_np_vac'] ?? '') ?>" placeholder="Enter Leave without Pay Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Without Pay Sick:</label>
                                                <input type="number" step="0.01" name="lt_np_sck" class="form-control" value="<?= htmlspecialchars($leaveCard['lt_np_sck'] ?? '') ?>" placeholder="Enter Leave without Pay Sick">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!-- Undertime -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Undertime</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Unpaid Vacation:</label>
                                                <input type="number" step="0.01" name="u_vac" class="form-control" value="<?= htmlspecialchars($leaveCard['u_vac'] ?? '') ?>" placeholder="Enter Unpaid Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Unpaid Sick:</label>
                                                <input type="number" step="0.01" name="u_sck" class="form-control" value="<?= htmlspecialchars($leaveCard['u_sck'] ?? '') ?>" placeholder="Enter Unpaid Sick">
                                            </div>
                                        </div>
                                    </fieldset>
                                     <!-- Balance -->
                                     <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Balance</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Vacation Balance:</label>
                                                <input type="number" step="0.01" name="b_vac" class="form-control" value="<?= htmlspecialchars($leaveCard['b_vac'] ?? '') ?>" placeholder="Enter Vacation Balance">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Sick Balance:</label>
                                                <input type="number" step="0.01" name="b_sck" class="form-control" value="<?= htmlspecialchars($leaveCard['b_sck'] ?? '') ?>" placeholder="Enter Sick Balance">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Processor -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Processor</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Initial:</label>
                                                <input type="text" name="p_initial" class="form-control" value="<?= htmlspecialchars($leaveCard['p_initial'] ?? '') ?>" placeholder="Enter Initial">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Date:</label>
                                                <input type="date" name="p_date" class="form-control" value="<?= htmlspecialchars($leaveCard['p_date'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button class="btn btn-primary mr-2" type="submit" name="submit">Submit</button>
                                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

    <!-- Footer -->
    <?php include './util/footer.php'; ?>

</div>

<!-- Scripts -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
