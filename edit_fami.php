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
    $family_info_id = decrypt_id($token);
    
    $query = "
            SELECT *
            FROM family_info
            WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $family_info_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $family_info = $result->fetch_assoc();
        } else {
            echo "No record Found.";
            header("Location: famb.php");
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
                        <h3 class="card-title"> Family Background</h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/update_fami.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($family_info['id']) ?>">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control"  value="<?= htmlspecialchars($family_info['employee_no']) ?>" readonly>
                            </div>
      
                            <!-- Name Details -->
                            <div class="col-md-3 mb-2">
                                <label>22. Spouse's Surname:</label>
                                <input type="text" name="spouse_sname" class="form-control"  value="<?= htmlspecialchars($family_info['spouse_sname']) ?>" placeholder="Surname">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="spouse_fname" class="form-control"  value="<?= htmlspecialchars($family_info['spouse_fname']) ?>" placeholder="First Name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="spouse_mname" class="form-control"  value="<?= htmlspecialchars($family_info['spouse_mname']) ?>" placeholder="Middle Name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Name Extension:</label>
                                <select name="spouse_ext" class="form-control">
                                    <option value="" <?= $family_info['spouse_ext'] == "" ? "selected" : "" ?> disabled>(Jr., Sr.)</option>
                                    <option value="Jr." <?= $family_info['spouse_ext'] == "Jr." ? "selected" : "" ?>>Jr.</option>
                                    <option value="Sr." <?= $family_info['spouse_ext'] == "Sr." ? "selected" : "" ?>>Sr.</option>
                                </select>
                            </div>

                      
                            <div class="col-md-4 mb-2">
                                <label>Occupation:</label>
                                <input type="text" name="occupation" class="form-control" value="<?= htmlspecialchars($family_info['occupation']) ?>" placeholder="Occupation">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Business Address:</label>
                                <input type="text" name="bussAdd" class="form-control" value="<?= htmlspecialchars($family_info['bussAdd']) ?>" placeholder="Business Address">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Telephone No:</label>
                                <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($family_info['telephone']) ?>" placeholder="Tel no.">
                            </div>

                            <!-- Fathers Info-->
                            <div class="col-md-4 mb-2">
                                <label>23. Father's Surname:</label>
                                <input type="text" name="father_sname" class="form-control" value="<?= htmlspecialchars($family_info['father_sname']) ?>" placeholder="Surname" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="father_fname" class="form-control"value="<?= htmlspecialchars($family_info['father_fname']) ?>"  placeholder="First Name" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="father_mname" class="form-control" value="<?= htmlspecialchars($family_info['father_mname']) ?>" placeholder="Middle Name">
                            </div>
                            <!--Mother's Info-->
                            <div class="col-md-4 mb-2">
                                <label>24. Mother's Surname:</label>
                                <input type="text" name="mothers_sname" class="form-control" value="<?= htmlspecialchars($family_info['mothers_sname']) ?>" placeholder="Surname" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="mothers_fname" class="form-control" value="<?= htmlspecialchars($family_info['mothers_sname']) ?>" placeholder="First Name" >
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="mothers_mname" class="form-control" value="<?= htmlspecialchars($family_info['mothers_sname']) ?>" placeholder="Middle Name">
                            </div>

                          <!-- Children Name -->
                            <div class="col-md-6 mb-2">
                                <label>25. Name of Children:</label>
                                <input type="text" name="child1_name" class="form-control" placeholder="Child Full Name" value="<?php echo isset($family_info['child1_name']) ? $family_info['child1_name'] : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>Date of Birth:</label>
                                <input type="date" name="child1_birth" class="form-control" value="<?php echo isset($family_info['child1_birth']) ? $family_info['child1_birth'] : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="child2_name" class="form-control" placeholder="Child Full Name" value="<?php echo isset($family_info['child2_name']) ? $family_info['child2_name'] : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="date" name="child2_birth" class="form-control" value="<?php echo isset($family_info['child2_birth']) ? $family_info['child2_birth'] : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="child3_name" class="form-control" placeholder="Child Full Name" value="<?php echo isset($family_info['child3_name']) ? $family_info['child3_name'] : ''; ?>">
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="date" name="child3_birth" class="form-control" value="<?php echo isset($family_info['child3_birth']) ? $family_info['child3_birth'] : ''; ?>">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label" style="cursor: pointer;" onclick="toggleChildInputs()">Click this to add more child</label>
                            </div>

                            <div id="child-inputs" style="display: <?php echo isset($family_info['child4_name']) ? 'block' : 'none'; ?>;">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child4_ma,e" class="form-control" placeholder="Child Full Name" value="<?php echo isset($family_info['child4_name']) ? $family_info['child4_name'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child4_birth" class="form-control" value="<?php echo isset($family_info['child4_birth']) ? $family_info['child4_birth'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child5_name" class="form-control" placeholder="Child Full Name" value="<?php echo isset($family_info['child5_name']) ? $family_info['child5_name'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child5_birth" class="form-control" value="<?php echo isset($family_info['child5_birth']) ? $family_info['child5_birth'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child6_name" class="form-control" placeholder="Child Full Name" value="<?php echo isset($family_info['child6_name']) ? $family_info['child6_name'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child6_birth" class="form-control" value="<?php echo isset($family_info['child6_birth']) ? $family_info['child6_birth'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="child7_name" class="form-control" placeholder="Child Full Name" value="<?php echo isset($family_info['child7_name']) ? $family_info['child7_name'] : ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" name="child7_birth" class="form-control" value="<?php echo isset($family_info['child7_birth']) ? $family_info['child7_birth'] : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            

                        <!-- Submission Buttons -->
                        <div class="row mt-3 float-right">
                            <div class="col-12">
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
        function toggleChildInputs() {
            const childInputs = document.getElementById("child-inputs");
            childInputs.style.display = childInputs.style.display === "none" ? "block" : "none";
        }
    </script>
</body>
</html>

