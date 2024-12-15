<?php 
session_start();
require_once './config/conn.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_no'])) {
    $employee_no = mysqli_real_escape_string($conn, $_POST['employee_no']);
    
    // Fetch employee record from the database using the provided employee_no
    $query = "SELECT * FROM appleave WHERE employee_no = '$employee_no'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
    } else {
        // If no record is found
        echo "No record found for Employee No: " . htmlspecialchars($employee_no);
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
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
   

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
            <?php include './util/session-message.php'?>
            <div id="printArea">
                <!-- Table for Employee Records -->
                <div class="card">
                    <div class="card-header">
                    <h4 >Employee Leave Records</h4>
                    <div class="card-tools">
                        <a href="print-employee-leave.php?employee_no=<?php echo urlencode($employee_no); ?>" class="btn btn-primary btn-md me-2">
                            <i class="fas fa-print"></i> Print
                        </a>

                    </div>

                    </div> 
                    <div class="card-header">
                            <h6 class="font-weight-bold text-primary">Personal Information</h6>
                        </div>
                    <div class="card-body">
               
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Employee No:</label>
                                    <input type="text" name="employee_no" class="form-control" placeholder="Enter Employee No"  value="<?php echo htmlspecialchars($employee['employee_no']); ?>" >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Office/Department-District/School:</label>
                                    <input type="text" name="office" class="form-control" placeholder="Enter Office"  value="<?php echo htmlspecialchars($employee['office']); ?>" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Last Name:</label>
                                    <input type="text" name="lastname" class="form-control" requiredn placeholder="Enter Last Name"   value="<?php echo htmlspecialchars($employee['lastname']); ?>" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>First Name:</label>
                                    <input type="text" name="firstname" class="form-control" placeholder="Enter First Name"  value="<?php echo htmlspecialchars($employee['firstname']); ?>" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Middle Name:</label>
                                    <input type="text" name="middlename" class="form-control" placeholder="Enter Middle Name"   value="<?php echo htmlspecialchars($employee['middlename']); ?>" >
                                </div>
                              
                                <div class="col-md-4 mb-3">
                                    <label>Position:</label>
                                    <input type="text" name="position" class="form-control" placeholder="Enter your Position"  value="<?php echo htmlspecialchars($employee['position']); ?>" >
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Salary:</label>
                                    <input type="text" name="salary" class="form-control" placeholder="Enter Salary"  value="<?php echo htmlspecialchars($employee['salary']); ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Date of Filing:</label>
                                    <input type="date" name="dateofFilling" class="form-control" value="<?php echo htmlspecialchars($employee['dateofFilling']); ?>">
                                </div>
                                
                            </div>
                            <div class="card-header">
                             <h6 class="font-weight-bold text-primary">Details of Application</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Type of Leave:</label>
                                    <input type="text" name="typeofLeave" class="form-control"  value="<?php echo htmlspecialchars($employee['typeofLeave']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Others (Specify):</label>
                                    <input type="text" name="others" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label> Details of Leave<br><i>In case of Vacation/Special Privilege Leave:</i></label>
                                    <input type="text" name="vacationleave" class="form-control"  placeholder="Within the Philippines/Abroad (Specify)" value="<?php echo htmlspecialchars($employee['vacationleave']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><br><i>In case of Sick Leave:</i></label>
                                    <input type="text" name="sickleave" class="form-control" placeholder="In Hospital/Out Patient(Specify Illness)"  value="<?php echo htmlspecialchars($employee['sickleave']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><br><i>In case of Special Leave Benefits for Women:</i></label>
                                    <input type="text" name="specialleave" class="form-control" placeholder="(Specify Illness)" value="<?php echo htmlspecialchars($employee['specialleave']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                     <label class="control-label"><br><i>In case of Study Leave:</i></label>
                                    <input type="text" name="studyleave" class="form-control"  value="<?php echo htmlspecialchars($employee['studyleave']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label"><i>Other Purpose:</i></label>
                                    <input type="text" name="otherpurpose" class="form-control"  value="<?php echo htmlspecialchars($employee['otherpurpose']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Number of Working Days Applied for:</label>
                                    <input type="text" name="numberofWork" class="form-control" placeholder="Enter number of days applied for" value="<?php echo htmlspecialchars($employee['numberofWork']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Inclusive Dates<br>From:</label>
                                    <input type="date" name="inclusiveDate_from" class="form-control" value="<?php echo htmlspecialchars($employee['inclusiveDate_from']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><br>To:</label>
                                    <input type="date" name="inclusiveDate_to" class="form-control" value="<?php echo htmlspecialchars($employee['inclusiveDate_to']); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label"><i>Commutation:</i></label>
                                    <input name="commutation" class="form-control" value="<?php echo htmlspecialchars($employee['commutation']); ?>">
                                    
                                </div>
                                </div>
                            </div>
                                <div class="card-header">
                                    <h6 class="font-weight-bold text-primary">Details of Application</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label">Certification of Leave Credits:</label>
                                    <input type="date" name="certificationofLeave" class="form-control" placeholder="As of" value="<?php echo htmlspecialchars($employee['certificationofLeave']); ?>">
                                </div>
                                <div class="row m-1">
                                    <div class="col-md-4 mb-3">
                                        <label for="fname" class="control-label"></label>
                                        <input type="text" id="fname" name="fname" class="form-control" placeholder="Total Earned" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="vacationTotal" class="control-label">Vacation Leave</label>
                                        <input type="text" id="vacationTotal" name="vacationTotal" class="form-control" placeholder="Enter Vacation Leave" value="<?php echo htmlspecialchars($employee['vacationTotal']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sickTotal" class="control-label">Sick Leave</label>
                                        <input type="text" id="sickTotal" name="sickTotal" class="form-control" placeholder="Enter Sick Leave" value="<?php echo htmlspecialchars($employee['sickTotal']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label"></label>
                                        <input type="text" name="fname" class="form-control" placeholder="Less this application" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="vacationLess" class="control-label"></label>
                                        <input type="text" id="vacationLess" name="vacationLess" class="form-control" placeholder="Enter Vacation Less" value="<?php echo htmlspecialchars($employee['vacationLess']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sickLess" class="control-label"></label>
                                        <input type="text" id="sickLess" name="sickLess" class="form-control" placeholder="Enter Sick Less" value="<?php echo htmlspecialchars($employee['sickLess']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label"></label>
                                        <input type="text" name="fname" class="form-control" placeholder="Balance" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="vacationBalance" class="control-label"></label>
                                        <input type="text" id="vacationBalance" name="vacationBalance" class="form-control" placeholder="Enter Vacation Balance"  value="<?php echo htmlspecialchars($employee['vacationBalance']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sickBalance" class="control-label"></label>
                                        <input type="text" id="sickBalance" name="sickBalance" class="form-control" placeholder="Enter Sick Balance"  value="<?php echo htmlspecialchars($employee['sickBalance']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                    <label class="control-label">Recommendtion:</label>
                                        <input type="text" name="recommendation" class="form-control" value="<?php echo htmlspecialchars($employee['recommendation']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label">Approved for:</label>
                                        <input type="text" name="approved" class="form-control" placeholder="days with pay / days without pay / others (specify)" value="<?php echo htmlspecialchars($employee['approved']); ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label">Disapproved due to:</label>
                                        <input type="text" name="disapproved" class="form-control" placeholder="" value="<?php echo htmlspecialchars($employee['disapproved']); ?>">
                                    </div>
                                </div>

                            </div>
           
                        </div>
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
function printContent(elementId) {
    const printContents = document.getElementById(elementId).innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    window.location.reload(); // Reload the page to restore the original content
}
</script>

</body>
</html>
