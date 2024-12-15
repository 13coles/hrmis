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
    <title>Educational Background</title>
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
                <div class="card mt-2">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">
                             Educational Background
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="PDS/insert_education.php" method="POST">
                            <div class="row">
                                <!-- Employee Details -->
                                <div class="col-md-12 mb-2">
                                    <label>Employee No:</label>
                                    <input type="text" name="employee_no" class="form-control" placeholder="Agency Employee Number" required>
                                </div>
                                
                                <!-- Educational Background -->
                                <?php
                                $educationLevels = [
                                    "Elementary" => "elementary",
                                    "Secondary" => "secondary",
                                    "Vocational/TradeCourse" => "vocational",
                                    "College" => "college",
                                    "Graduate Studies" => "graduate"
                                ];
                                foreach ($educationLevels as $levelName => $levelField) {
                                ?>
                                <div class="col-md-12 mb-4">
                                    <h5><?php echo $levelName; ?>:</h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label>Name of School</label>
                                            <input type="text" name="<?php echo $levelField; ?>" class="form-control" placeholder="Name of School">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Degree/Course</label>
                                            <input type="text" name="<?php echo $levelField; ?>Degree" class="form-control" placeholder="Degree or Course">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Period of Attendance</label>
                                            <input type="text" name="<?php echo $levelField; ?>Period" class="form-control" placeholder="e.g., 2010-2014">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Highest Level</label>
                                            <input type="text" name="<?php echo $levelField; ?>Level" class="form-control" placeholder="e.g., 4th Year">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Year Graduated</label>
                                            <input type="text" name="<?php echo $levelField; ?>Year" class="form-control" placeholder="e.g., 2014">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label>Academic Honors</label>
                                            <input type="text" name="<?php echo $levelField; ?>Acad" class="form-control" placeholder="e.g., Cum Laude">
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <!-- Submission Buttons -->
                                <div class="col-12 text-right mt-3">
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
</body>
</html>
