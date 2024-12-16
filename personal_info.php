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
    <title>Personal Info</title>
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
        

                <!-- Card with Nav List -->
                <div class="card mt-2">
                    <div class="card-header bg-primary">
                        <h3 class="card-title"><a href="PDS.php" class="text-white">Back</a> / Personal Information</h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/insert_personal_info.php" method="POST">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-6 mb-2">
                                <label>1. Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" placeholder="Agency Employee Number">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>2. CS ID No:</label>
                                <input type="text" name="csc" class="form-control" placeholder="(Do not fill up. For CSC use only)">
                            </div>

                            <!-- Name Details -->
                            <div class="col-md-3 mb-2">
                                <label>3. Surname:</label>
                                <input type="text" name="sname" class="form-control" placeholder="Surname" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="mname" class="form-control" placeholder="Middle Name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Name Extension:</label>
                                <select name="xtension" class="form-control">
                                    <option value="" selected disabled>(Jr., Sr.)</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                </select>
                            </div>

                            <!-- Birth Details -->
                            <div class="col-md-4 mb-2">
                                <label>4. Date of Birth:</label>
                                <input type="date" name="datebirth" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>5. Place of Birth:</label>
                                <input type="text" name="placebirth" class="form-control" placeholder="Place of Birth">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>6. Sex:</label>
                                <select name="sex" class="form-control" required>
                                    <option value="" selected disabled>Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <!-- Civil Status -->
                            <div class="col-md-4 mb-2">
                                <label>7. Civil Status:</label>
                                <select name="status" class="form-control" required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Other">Other/s</option>
                                </select>
                            </div>

                            <!-- Physical Details -->
                            <div class="col-md-4 mb-2">
                                <label>8. Height (cm):</label>
                                <input type="text" name="height" class="form-control" placeholder="Height (cm)" pattern="\d+(\.\d{1,2})?" title="Enter a valid height in centimeters (e.g., 175)">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>9. Weight (kg):</label>
                                <input type="text" name="weight" class="form-control" placeholder="Weight (kg)" pattern="\d+(\.\d{1,2})?" title="Enter a valid weight in kilograms (e.g., 70)">
                            </div>

                            <!-- Identification Numbers -->
                            <div class="col-md-4 mb-2">
                                <label>10. Blood Type:</label>
                                <input type="text" name="bloodtype" class="form-control" placeholder="Blood Type">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>11. GSIS ID No:</label>
                                <input type="text" name="gsis_id" class="form-control" placeholder="GSIS ID No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>12. PAG-IBIG ID No:</label>
                                <input type="text" name="pagibig_id" class="form-control" placeholder="PAG-IBIG ID No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>13. PHILHEALTH No:</label>
                                <input type="text" name="philhealth_id" class="form-control" placeholder="PHILHEALTH No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>14. SSS No:</label>
                                <input type="text" name="sss_id" class="form-control" placeholder="SSS No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>15. TIN No:</label>
                                <input type="text" name="tin_id" class="form-control" placeholder="TIN No">
                            </div>

                            <!-- Citizenship -->
                            <div class="col-md-4 mb-2">
                                <label>16. Citizenship:</label>
                                <select name="citizenship" class="form-control" required>
                                    <option value="" selected disabled>Select Citizenship</option>
                                    <option value="Filipino">Filipino</option>
                                    <option value="Dual Citizenship">Dual Citizenship</option>
                                    <option value="By Birth">By Birth</option>
                                    <option value="By Naturalization">By Naturalization</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Country:</label>
                                <input type="text" name="country" class="form-control" placeholder="Please indicate country">
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-4 mb-2">
                                <label>17. Residential Address:</label>
                                <input type="text" name="resAdd" class="form-control" placeholder="House/Block/Lot No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Street:</label>
                                <input type="text" name="street" class="form-control" placeholder="Street">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Subdivision:</label>
                                <input type="text" name="subdivision" class="form-control" placeholder="Subdivision">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Barangay:</label>
                                <input type="text" name="barangay" class="form-control" placeholder="Barangay">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>City:</label>
                                <input type="text" name="city" class="form-control" placeholder="City">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Province:</label>
                                <input type="text" name="province" class="form-control" placeholder="Province">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Zipcode:</label>
                                <input type="text" name="zipcode" class="form-control" placeholder="Zipcode">
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-4 mb-2">
                                <label>18. Permanent Address:</label>
                                <input type="text" name="permaAdd" class="form-control" placeholder="House/Block/Lot No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Street:</label>
                                <input type="text" name="permaStreet" class="form-control" placeholder="Street">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Subdivision:</label>
                                <input type="text" name="permaSub" class="form-control" placeholder="Subdivision">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Barangay:</label>
                                <input type="text" name="permaBarangay" class="form-control" placeholder="Barangay">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>City:</label>
                                <input type="text" name="permaCity" class="form-control" placeholder="City">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Province:</label>
                                <input type="text" name="permaPovince" class="form-control" placeholder="Province">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Zipcode:</label>
                                <input type="text" name="permaZip" class="form-control" placeholder="Zipcode">
                            </div>

                            <!-- Contact Details -->
                            <div class="col-md-4 mb-2">
                                <label>19. Telephone No.:</label>
                                <input type="text" name="telno" class="form-control" placeholder="Telephone No.">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>20. Mobile No.:</label>
                                <input type="text" name="mobileno" class="form-control" placeholder="Mobile No.">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>21. Email Address:</label>
                                <input type="email" name="email" class="form-control" placeholder="Email Address">
                            </div>
                        </div>

                        <!-- Submission Buttons -->
                        <div class="row mt-3 float-right">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="PDS.php" class="btn btn-secondary">Cancel</a>
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
</body>
</html>

