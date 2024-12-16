<?php
session_start();
require_once './config/conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Leave</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <!-- Logo/Image -->
                <a href="dashboard.php" class="navbar-brand">
                    <img src="assets/img/logo1.jpg" alt="Logo" class="brand-image" style="height: 50px; width: auto;">
                </a>
                
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <h4 class="m-0">Application for Leave</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <div class="container">
            <?php include './util/session-message.php'?>
                <form id="myForm" method="POST" action="forms/insert_appLeave.php" novalidate>
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h6 class="font-weight-bold text-primary">Personal Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Employee No:</label>
                                    <input type="text" name="employee_no" class="form-control" required placeholder="Enter Employee No">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Office/Department-District/School:</label>
                                    <input type="text" name="office" class="form-control" required placeholder="Enter Office">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Last Name:</label>
                                    <input type="text" name="lastname" class="form-control" requiredn placeholder="Enter Last Name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>First Name:</label>
                                    <input type="text" name="firstname" class="form-control" required placeholder="Enter First Name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Middle Name:</label>
                                    <input type="text" name="middlename" class="form-control" placeholder="Enter Middle Name" required>
                                </div>
                              
                                <div class="col-md-4 mb-3">
                                    <label>Position:</label>
                                    <input type="text" name="position" class="form-control" required placeholder="Enter your Position">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Salary:</label>
                                    <input type="text" name="salary" class="form-control" required placeholder="Enter Salary">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Date of Filing:</label>
                                    <input type="date" name="dateofFilling" class="form-control" required>
                                </div>
                                
                            </div>
                            <div class="card-header">
                             <h6 class="font-weight-bold text-primary">Details of Application</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Type of Leave:</label>
                                    <select name="typeofLeave" class="form-control input-sm">
                                        <option selected="" disabled="">Select Type of Leave</option>
                                        <option value="Vacation Leave (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)">Vacation Leave (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</option>
                                        <option value="Mandatory/Forced Leave (Sec. 25, Rule XVI, Omnibus Rules Implementing E.D. No. 292)">Mandatory/Forced Leave (Sec. 25, Rule XVI, Omnibus Rules Implementing E.D. No. 292)</option>
										<option value="Sick Leave (Sec. 43, Rule XVL Omritus. Rules Implementing E.D. No. 292)">Sick Leave (Sec. 43, Rule XVL Omritus. Rules Implementing E.D. No. 292)</option>
										<option value="Maternity Leave (RA. No 11210/IRR ssued by CSC. DOLE and SSS)">Maternity Leave (RA. No 11210/IRR ssued by CSC. DOLE and SSS)</option>
										<option value="Paternity Leave (RA. No. 8187/CSC MC No 71, s. 1960, as amended)">Paternity Leave (RA. No. 8187/CSC MC No 71, s. 1960, as amended)</option>
										<option value="Special Privilege Leave (Sec. 21, Rule XVI Omnibus Rules Implementing E.D. No. 292)">Special Privilege Leave (Sec. 21, Rule XVI Omnibus Rules Implementing E.D. No. 292)</option>
										<option value="Solo Parent Leave (RA No 8972/CSC MC No. 8. s. 2004)">Solo Parent Leave (RA No 8972/CSC MC No. 8. s. 2004)</option>
										<option value="Study Leave (Sec. 68, Rule XVI, Omnibus Rules Implementing E.Q. No. 292)">Study Leave (Sec. 68, Rule XVI, Omnibus Rules Implementing E.Q. No. 292)</option>
										<option value="10-Day VAWC Leave (RA No. 8262/CSC MC No. 15, s. 2005)">10-Day VAWC Leave (RA No. 8262/CSC MC No. 15, s. 2005)</option>
										<option value="Rehabilitation Privilege (Sec. 58, Rule XVI, Omnibus Rules implementing E.Q. No. 292)">Rehabilitation Privilege (Sec. 58, Rule XVI, Omnibus Rules implementing E.Q. No. 292)</option>
										<option value="Special Leave Benefits for Women (RA No. 3710/CSC MC No. 25, s 2010)">Special Leave Benefits for Women (RA No. 3710/CSC MC No. 25, s 2010)</option>
										<option value="Special Emergency (Calamity) Leave (CSC MC No. 2, s. 2012, as amendent)">Special Emergency (Calamity) Leave (CSC MC No. 2, s. 2012, as amendent)</option>
										<option value="Adoption Leave (R.A. No. 8552)">Adoption Leave (R.A. No. 8552)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Others (Specify):</label>
                                    <input type="text" name="others" class="form-control" placeholder="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label> Details of Leave<br><i>In case of Vacation/Special Privilege Leave:</i></label>
                                    <input type="text" name="vacationleave" class="form-control"  placeholder="Within the Philippines/Abroad (Specify)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><br><i>In case of Sick Leave:</i></label>
                                    <input type="text" name="sickleave" class="form-control" placeholder="In Hospital/Out Patient(Specify Illness)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><br><i>In case of Special Leave Benefits for Women:</i></label>
                                    <input type="text" name="specialleave" class="form-control" placeholder="(Specify Illness)">
                                </div>
                                <div class="col-md-6 mb-3">
                                     <label class="control-label"><br><i>In case of Study Leave:</i></label>
                                    <select name="studyleave" class="form-control input-sm">
                                        <option selected="" disabled="">Select Type of Study Leave</option>
                                        <option value="Completion of Master's Degree">Completion of Master's Degree</option>
                                        <option value="BAR/Board Examination Review">BAR/Board Examination Review</option>
										
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label"><i>Other Purpose:</i></label>
                                    <select name="otherpurpose" class="form-control input-sm">
                                        <option selected="" disabled="">Select Type of Purpose</option>
                                        <option value="Monetization of Leave Credits">Monetization of Leave Credits</option>
                                        <option value="Terminal Leave">Terminal Leave</option>
										
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Number of Working Days Applied for:</label>
                                    <input type="text" name="numberofWork" class="form-control" placeholder="Enter number of days applied for">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Inclusive Dates<br>From:</label>
                                    <input type="date" name="inclusiveDate_from" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label><br>To:</label>
                                    <input type="date" name="inclusiveDate_to" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label"><i>Commutation:</i></label>
                                    <select name="commutation" class="form-control input-sm">
                                        <option selected="" disabled="">Select</option>
                                        <option value="Not Requested">Not Requested</option>
                                        <option value="Requesred">Requesred</option>
										
                                    </select>
                                </div>
                                </div>
                            </div>
                                <div class="card-header">
                                    <h6 class="font-weight-bold text-primary">Details of Application</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label">Certification of Leave Credits:</label>
                                    <input type="date" name="certificationofLeave" class="form-control" placeholder="As of">
                                </div>
                                <div class="row m-1">
                                    <div class="col-md-4 mb-3">
                                        <label for="fname" class="control-label"></label>
                                        <input type="text" id="fname" name="fname" class="form-control" placeholder="Total Earned" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="vacationTotal" class="control-label">Vacation Leave</label>
                                        <input type="text" id="vacationTotal" name="vacationTotal" class="form-control" placeholder="Enter Vacation Leave">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sickTotal" class="control-label">Sick Leave</label>
                                        <input type="text" id="sickTotal" name="sickTotal" class="form-control" placeholder="Enter Sick Leave">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label"></label>
                                        <input type="text" name="fname" class="form-control" placeholder="Less this application" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="vacationLess" class="control-label"></label>
                                        <input type="text" id="vacationLess" name="vacationLess" class="form-control" placeholder="Enter Vacation Less">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sickLess" class="control-label"></label>
                                        <input type="text" id="sickLess" name="sickLess" class="form-control" placeholder="Enter Sick Less">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label"></label>
                                        <input type="text" name="fname" class="form-control" placeholder="Balance" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="vacationBalance" class="control-label"></label>
                                        <input type="text" id="vacationBalance" name="vacationBalance" class="form-control" placeholder="Enter Vacation Balance">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="sickBalance" class="control-label"></label>
                                        <input type="text" id="sickBalance" name="sickBalance" class="form-control" placeholder="Enter Sick Balance">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                    <label class="control-label">Recommendtion:</label>
                                        <select name="recommendation" class="form-control input-sm">
                                            <option selected="" disabled="">Select Type of Recommendation</option>
                                            <option value="For approval">For approval</option>
                                            <option value="For disapproval">For disapproval</option>	
                                        </select>
                                        <input type="text" name="forDisapproval" class="form-control" placeholder="For disapproval due to:">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label">Approved for:</label>
                                        <input type="text" name="approved" class="form-control" placeholder="days with pay / days without pay / others (specify)">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="control-label">Disapproved due to:</label>
                                        <input type="text" name="disapproved" class="form-control" placeholder="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="text-center m-3">
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Dependencies -->
    <script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
    <script src="./assets/js/script.js"></script>
</body>
</html>
