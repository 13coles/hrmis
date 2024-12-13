<?php
session_start();
require_once './config/conn.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];

    // Fetch employee details, concatenating name fields
    $employeeQuery = $conn->prepare("
        SELECT 
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

    // Fetch leave card data
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
    ");
    $leaveCardQuery->bind_param("i", $employee_id);
    $leaveCardQuery->execute();
    $leaveCardResult = $leaveCardQuery->get_result();
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
    <title>Leave Card</title>
    <!-- Admin LTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include './util/head.php'; ?>

    <!-- Sidebar -->
    <?php include './util/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-2">
                            <!-- Employee Details -->
                            <div class="card-header">
                                <div class="row">
                                    <div class="col"><strong>Employee Name:</strong> <?= htmlspecialchars($employee['name']) ?></div>
                                    <div class="col"><strong>Sex:</strong> <?= htmlspecialchars($employee['sex']) ?></div>
                                    <div class="col"><strong>Civil Status:</strong> <?= htmlspecialchars($employee['civil_status']) ?></div>
                                    <div class="col"><strong>Date Started:</strong> <?= htmlspecialchars($employee['date_hired']) ?></div>
                                </div>
                            </div>

                            <!-- Leave Card Details -->
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Leave Card Details</h5>
                                    <div>
                                        <a href="addNewCredits.php" class="btn btn-primary"> Add New Credits</a>
                                        <a href="#" class="btn btn-outline-primary">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Leave Card Table -->
                                <table class="table table-bordered table-striped table-responsive-sm mt-3">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Year</th>
                                            <th colspan="2">Leaves Earned</th>
                                            <th rowspan="2">From - To</th>
                                            <th colspan="4">Leaves Taken</th>
                                            <th colspan="2">Undertime</th>
                                            <th colspan="2">Balance</th>
                                            <th colspan="2">Processor</th>
                                        </tr>
                                        <tr>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Vacation (With Pay)</th>
                                            <th>Sick (With Pay)</th>
                                            <th>Vacation (No Pay)</th>
                                            <th>Sick (No Pay)</th>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Initial</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($leaveCardResult->num_rows == 0): ?>
                                            <tr>
                                                <td colspan="14" class="text-center">No data available</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php while ($card = $leaveCardResult->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($card['year']) ?></td>
                                                    <td><?= htmlspecialchars($card['le_vac']) ?></td>
                                                    <td><?= htmlspecialchars($card['le_sck']) ?></td>
                                                    <td><?= htmlspecialchars($card['from_to']) ?>
                                                    <td><?= htmlspecialchars($card['lt_wp_vac']) ?></td>
                                                    <td><?= htmlspecialchars($card['lt_wp_sck']) ?></td>
                                                    <td><?= htmlspecialchars($card['lt_np_vac']) ?></td>
                                                    <td><?= htmlspecialchars($card['lt_np_sck']) ?></td>
                                                    <td><?= htmlspecialchars($card['u_vac']) ?></td>
                                                    <td><?= htmlspecialchars($card['u_sck']) ?></td>
                                                    <td><?= htmlspecialchars($card['b_vac']) ?></td>
                                                    <td><?= htmlspecialchars($card['b_sck']) ?></td>
                                                    <td><?= htmlspecialchars($card['p_initial']) ?></td>
                                                    <td><?= htmlspecialchars($card['p_date']) ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <?php include './util/footer.php'; ?>

</div>

<!-- JavaScript -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
