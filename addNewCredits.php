<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once './config/conn.php';


$query_balance = "SELECT b_vac, b_sck FROM pelc ORDER BY created_at DESC LIMIT 1"; 
$result_balance = $conn->query($query_balance);

if ($result_balance->num_rows > 0) {
    $row_balance = $result_balance->fetch_assoc();
    $b_vac = $row_balance['b_vac'];
    $b_sck = $row_balance['b_sck'];
} else {
    $b_vac = 0; 
    $b_sck = 0; 
}

$query = "SELECT employee_id, employee_no FROM pelc ORDER BY created_at DESC LIMIT 1"; 
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $employee_id = $row['employee_id'];
    $employee_no = $row['employee_no'];
} else {
    echo "No employee record found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credits</title>
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

        <!-- Breadcrumb -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Credits</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="permanent.php">Home</a></li>
                            <li class="breadcrumb-item active">Credits</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
            <?php include './util/session-message.php'?>
               <div class="row">
                    <div class="col-lg-12 mt-2">
                        <form action="forms/insert_newCredits.php" method="post">
                        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                        <input type="hidden" name="employee_no" value="<?php echo $employee_no; ?>">

                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h5 class="m-0">Add New Credits for Leave Card</h5>
                                </div>
                                <div class="card-body p-5">
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Leaves Earned</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-secondary">Year:</label>
                                                <input type="number" name="year" class="form-control" placeholder="Enter Year">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-secondary">Vacation:</label>
                                                <input type="number" step="0.01" name="le_vac" class="form-control" value="1.25">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-secondary">Sick:</label>
                                                <input type="number" step="0.01" name="le_sck" class="form-control" value="1.25">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-secondary">Credits From - To:</label>
                                                <input type="text" name="from_to" class="form-control" placeholder="Enter Leaves Credit From and To" required>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Leaves Taken -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Leaves Taken</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">With Pay Vacation:</label>
                                                <input type="number" step="0.01" name="lt_wp_vac" class="form-control" 
                                                    placeholder="Enter Leave with Pay Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">With Pay Sick:</label>
                                                <input type="number" step="0.01" name="lt_wp_sck" class="form-control" 
                                                    placeholder="Enter Leave with Pay Sick">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Without Pay Vacation:</label>
                                                <input type="number" step="0.01" name="lt_np_vac" class="form-control" 
                                                    placeholder="Enter Leave without Pay Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Without Pay Sick:</label>
                                                <input type="number" step="0.01" name="lt_np_sck" class="form-control" 
                                                    placeholder="Enter Leave without Pay Sick">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Undertime -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Undertime</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Unpaid Vacation:</label>
                                                <input type="number" step="0.01" name="u_vac" class="form-control" 
                                                    placeholder="Enter Unpaid Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Unpaid Sick:</label>
                                                <input type="number" step="0.01" name="u_sck" class="form-control" 
                                                    placeholder="Enter Unpaid Sick">
                                            </div>
                                        </div>
                                    </fieldset>

                                    
                                    
                                    <!-- Balance -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Balance</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Vacation Balance:</label>
                                                <input type="number" step="0.01" name="b_vac" class="form-control" value="<?php echo isset($b_vac) ? $b_vac : '0'; ?>" placeholder="Enter Vacation Balance">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Sick Balance:</label>
                                                <input type="number" step="0.01" name="b_sck" class="form-control" value="<?php echo isset($b_sck) ? $b_sck : '0'; ?>" placeholder="Enter Sick Balance">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Processor -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Processor</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Initial:</label>
                                                <input type="text" name="p_initial" class="form-control" 
                                                    placeholder="Enter Initial">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Date:</label>
                                                <input type="date" name="p_date" class="form-control">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                        <button type="button" class="btn btn-secondary ms-2" onclick="window.history.back()">Cancel</button>
                                    </div>

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
</body>
</html>
