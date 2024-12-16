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
    <title>Family Background</title>
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
                        <h3 class="card-title"><a href="PDS.php" class="text-white">Back</a> / Family Background</h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/insert_family.php" method="POST">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" placeholder="Agency Employee Number">
                            </div>
      
                            <!-- Name Details -->
                            <div class="col-md-3 mb-2">
                                <label>22. Spouse's Surname:</label>
                                <input type="text" name="spouse_sname" class="form-control" placeholder="Surname">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="spouse_fname" class="form-control" placeholder="First Name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="spouse_mname" class="form-control" placeholder="Middle Name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Name Extension:</label>
                                <select name="spouse_ext" class="form-control">
                                    <option value="" selected disabled>(Jr., Sr.)</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                </select>
                            </div>

                      
                            <div class="col-md-4 mb-2">
                                <label>Occupation:</label>
                                <input type="text" name="occupation" class="form-control" placeholder="Occupation">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Business Address:</label>
                                <input type="text" name="bussAdd" class="form-control" placeholder="Business Address">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Telephone No:</label>
                                <input type="text" name="telephone" class="form-control" placeholder="Tel no.">
                            </div>

                            <!-- Fathers Info-->
                            <div class="col-md-4 mb-2">
                                <label>23. Father's Surname:</label>
                                <input type="text" name="father_sname" class="form-control" placeholder="Surname" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="father_fname" class="form-control" placeholder="First Name" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="father_mname" class="form-control" placeholder="Middle Name">
                            </div>
                            <!--Mother's Info-->
                            <div class="col-md-4 mb-2">
                                <label>24. Mother's Surname:</label>
                                <input type="text" name="mothers_sname" class="form-control" placeholder="Surname" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="mothers_fname" class="form-control" placeholder="First Name" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="mothers_mname" class="form-control" placeholder="Middle Name">
                            </div>

                            <!-- Children Name -->
                            <div class="col-md-6 mb-2">
                                <label>25. Name of Children:</label>
                                <input type="text" name="child_1" class="form-control" placeholder="Child Full Name">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Date of Birth:</label>
                                <input type="date" name="child_1_birth" class="form-control">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="child_2" class="form-control" placeholder="Child Full Name">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="date" name="child_2_birth" class="form-control">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="child_3" class="form-control" placeholder="Child Full Name">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="date" name="child_3_birth" class="form-control">
                            </div>
                            <div class="col-md-12 mb-2">
                                 <label class="form-label" style="cursor: pointer;" onclick="toggleChildInputs()">Click this to add more child</label>
                            </div>

                            <div id="child-inputs" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child_4" class="form-control" placeholder="Child Full Name">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child_4_birth" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child_5" class="form-control" placeholder="Child Full Name">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child_5_birth" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child_6" class="form-control" placeholder="Child Full Name">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child_6_birth" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child_7" class="form-control" placeholder="Child Fulll Name">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child_7_birth" class="form-control">
                                    </div>
                                </div>
                            </div>
                            

                        <!-- Submission Buttons -->
                        <div class="row mt-3 float-right">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="educational.php" class="btn btn-secondary">Skip</a>
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
        function toggleChildInputs() {
            const childInputs = document.getElementById("child-inputs");
            childInputs.style.display = childInputs.style.display === "none" ? "block" : "none";
        }
    </script>
</body>
</html>

