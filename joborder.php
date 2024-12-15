<?php 
session_start();
require_once './config/conn.php';
require './util/encrypt_helper.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch employee records from the database
$query = "SELECT id, employee_no, last_name, first_name, middle_name, extension_name, department_name, date_hired, position FROM employees WHERE employee_type = 'jo' ";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOB ORDER</title>
   
    <!-- Include Admin LTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/select2/css/select2.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include './util/head.php'; ?>

    <!-- Sidebar -->
    <?php include './util/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="m-0 text-dark">Employee Records</h1>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
            <?php include './util/session-message.php'?>
                <!-- Table for Employee Records -->
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Employee Records</h3>
                        <div class="card-tools">
                            <a href="addJO.php" class="btn btn-primary btn-sm me-2"><i class="fas fa-plus"></i> Add Record</a>
                            <a href="print-jo.php" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="employee_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Number</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Years In Service</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $employeeNumber = $row['employee_no'];

                                    $employeeName = $row['last_name'] . ', ' . $row['first_name'];
                                    if (!empty($row['middle_name'])) {
                                        $employeeName .= ' ' . $row['middle_name'];
                                    }
                                    if (!empty($row['extension_name'])) {
                                        $employeeName .= ' ' . $row['extension_name'];
                                    }

                                    $department = $row['department_name'];
                                    $dateHired = $row['date_hired'];
                                    $yearsInService = floor((strtotime(date('Y-m-d')) - strtotime($dateHired)) / (365*60*60*24));
                                    if ($yearsInService === 5) {
                                        $notificationMessage = "Congrats! You reached 5 years of service.";
                                        $createdAt = date('Y-m-d H:i:s');
                                        $notificationQuery = "INSERT INTO notifications (employee_no, notification_message, created_at) VALUES ('$employeeNumber', '$notificationMessage', '$createdAt')";
                                        mysqli_query($conn, $notificationQuery);
                                    }
                                    $position = $row['position'];
                                ?>
                                <tr>
                                    <td><?php echo $employeeNumber; ?></td>
                                    <td><?php echo $employeeName; ?></td>
                                    <td><?php echo $department; ?></td>
                                    <td><?php echo $yearsInService; ?></td>
                                    <td><?php echo $position; ?></td>
                                    <td>
                                        <div class="dropdown d-flex justify-content-center">
                                            <button type="button" class="btn btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <!-- View PDS -->
                                                <?php $token = encrypt_id($row['employee_no']);?>
                                                <a href="view_personalInfo.php?token=<?php echo $token; ?>" class="dropdown-item text-sm">
                                                    <i class="fas fa-file-alt text-primary me-2"></i> View PDS
                                                </a>

                                                <!-- View record-->
                                                <?php $token = encrypt_id($row['id']);?>
                                                <a href="viewRecord.php?token=<?php echo $token; ?>" class="dropdown-item text-sm">
                                                    <i class="fas fa-book text-info me-2"></i> View Record
                                                </a>

                                                <!-- View Certificates -->
                                                <form action="certificates.php" method="POST" class="mb-0">
                                                    <input type="hidden" name="employee_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="dropdown-item text-sm">
                                                        <i class="fas fa-book text-info me-2"></i> Certificates
                                                    </button>
                                                </form>

                                                
                                                <!-- Delete Employee -->
                                                <form action="forms/deleteEmployee.php" method="POST" class="mb-0" onsubmit="return confirmDelete();">
                                                    <input type="hidden" name="employee_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="dropdown-item text-sm text-danger">
                                                        <i class="fas fa-trash-alt text-danger me-2"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <?php include './util/footer.php'; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./assets/js/script.js"></script>
<script>
$(document).ready(function () {
    $('#employee_table').DataTable({
        "responsive": true,
        "autoWidth": false,
    });

    function confirmDelete() {
        return confirm("Are you sure you want to delete this employee?");
    }
});
</script>
</body>
</html>
