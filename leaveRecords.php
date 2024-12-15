<?php 
session_start();
require_once './config/conn.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch employee records from the database
$query = "SELECT * FROM appleave";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Record</title>
   
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
                <h1 class="m-0 text-dark">Employee Leave Records</h1>
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
                            <a href="print-leaveRecords.php" class="btn btn-primary btn-md me-2"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="apple_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Number</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Type of Leave</th>
                                    <th>Number of Days</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Check if there are records
                                if (mysqli_num_rows($result) > 0) {
                                    // Loop through the results and display them
                                    while ($row = mysqli_fetch_assoc($result)) { 
                                ?>
                                    <tr>
                                        <td><?php echo $row['employee_no']; ?></td>
                                        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                        <td><?php echo $row['office']; ?></td>
                                        <td><?php echo $row['position']; ?></td>
                                        <td><?php echo $row['typeofLeave']; ?></td>
                                        <td><?php echo $row['numberofWork']; ?></td>
                                        
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                                }
                                ?>
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
<script>
$(document).ready(function () {
    $('#apple_table').DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
</body>
</html>
