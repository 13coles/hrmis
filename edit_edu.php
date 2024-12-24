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
    $educational_background_id = decrypt_id($token);
    
    // Query to fetch the educational background details
    $query = "
        SELECT *
        FROM educational_background
        WHERE id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $educational_background_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $educational_background = $result->fetch_assoc();
        } else {
            echo "No record Found.";
            header("Location: educational.php");
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
    <title>Educational Background</title>
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
                        <h3 class="card-title">Educational Background</h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/update_education.php" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($educational_background['id']) ?>">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" placeholder="Agency Employee Number" required value="<?= htmlspecialchars($educational_background['employee_no']) ?>" readonly>
                            </div>

                            <!-- Elementary Education -->
                            <div class="col-md-12 mb-4">
                                <h5>Elementary:</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Name of School</label>
                                        <input type="text" name="elementary" class="form-control" placeholder="Name of School" value="<?= htmlspecialchars($educational_background['elementary']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Degree</label>
                                        <input type="text" name="elem_degree" class="form-control" placeholder="Degree or Course" value="<?= htmlspecialchars($educational_background['elem_degree']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Period of Attendance</label>
                                        <input type="text" name="elem_period" class="form-control" placeholder="e.g., 2010-2014" value="<?= htmlspecialchars($educational_background['elem_period']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Highest Level</label>
                                        <input type="text" name="elem_level" class="form-control" placeholder="e.g., 4th Year" value="<?= htmlspecialchars($educational_background['elem_level']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Year Graduated</label>
                                        <input type="text" name="elem_year" class="form-control" placeholder="e.g., 2014" value="<?= htmlspecialchars($educational_background['elem_year']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Academic Honors</label>
                                        <input type="text" name="elem_acad" class="form-control" placeholder="e.g., Cum Laude" value="<?= htmlspecialchars($educational_background['elem_acad']) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Secondary Education -->
                            <div class="col-md-12 mb-4">
                                <h5>Secondary:</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Name of School</label>
                                        <input type="text" name="secondary" class="form-control" placeholder="Name of School" value="<?= htmlspecialchars($educational_background['secondary']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Degree</label>
                                        <input type="text" name="sec_degree" class="form-control" placeholder="Degree or Course" value="<?= htmlspecialchars($educational_background['sec_degree']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Period of Attendance</label>
                                        <input type="text" name="sec_period" class="form-control" placeholder="e.g., 2010-2014" value="<?= htmlspecialchars($educational_background['sec_period']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Highest Level</label>
                                        <input type="text" name="sec_level" class="form-control" placeholder="e.g., 4th Year" value="<?= htmlspecialchars($educational_background['sec_level']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Year Graduated</label>
                                        <input type="text" name="sec_year" class="form-control" placeholder="e.g., 2014" value="<?= htmlspecialchars($educational_background['sec_year']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Academic Honors</label>
                                        <input type="text" name="sec_acad" class="form-control" placeholder="e.g., Cum Laude" value="<?= htmlspecialchars($educational_background['sec_acad']) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Vocational Education -->
                            <div class="col-md-12 mb-4">
                                <h5>Vocational/Trade Course:</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Name of School</label>
                                        <input type="text" name="vocational" class="form-control" placeholder="Name of School" value="<?= htmlspecialchars($educational_background['vocational']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Degree</label>
                                        <input type="text" name="voc_degree" class="form-control" placeholder="Degree or Course" value="<?= htmlspecialchars($educational_background['voc_degree']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Period of Attendance</label>
                                        <input type="text" name="voc_period" class="form-control" placeholder="e.g., 2010-2014" value="<?= htmlspecialchars($educational_background['voc_period']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Highest Level</label>
                                        <input type="text" name="voc_level" class="form-control" placeholder="e.g., 4th Year" value="<?= htmlspecialchars($educational_background['voc_level']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Year Graduated</label>
                                        <input type="text" name="voc_year" class="form-control" placeholder="e.g., 2014" value="<?= htmlspecialchars($educational_background['voc_year']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Academic Honors</label>
                                        <input type="text" name="voc_acad" class="form-control" placeholder="e.g., Cum Laude" value="<?= htmlspecialchars($educational_background['voc_acad']) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- College Education -->
                            <div class="col-md-12 mb-4">
                                <h5>College:</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Name of School</label>
                                        <input type="text" name="college" class="form-control" placeholder="Name of School" value="<?= htmlspecialchars($educational_background['college']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Degree</label>
                                        <input type="text" name="col_degree" class="form-control" placeholder="Degree or Course" value="<?= htmlspecialchars($educational_background['col_degree']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Period of Attendance</label>
                                        <input type="text" name="col_period" class="form-control" placeholder="e.g., 2010-2014" value="<?= htmlspecialchars($educational_background['col_period']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Highest Level</label>
                                        <input type="text" name="col_level" class="form-control" placeholder="e.g., 4th Year" value="<?= htmlspecialchars($educational_background['col_level']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Year Graduated</label>
                                        <input type="text" name="col_year" class="form-control" placeholder="e.g., 2014" value="<?= htmlspecialchars($educational_background['col_year']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Academic Honors</label>
                                        <input type="text" name="col_acad" class="form-control" placeholder="e.g., Cum Laude" value="<?= htmlspecialchars($educational_background['col_acad']) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Graduate Education -->
                            <div class="col-md-12 mb-4">
                                <h5>Graduate Studies:</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Name of School</label>
                                        <input type="text" name="graduate" class="form-control" placeholder="Name of School" value="<?= htmlspecialchars($educational_background['graduate']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Degree</label>
                                        <input type="text" name="grad_degree" class="form-control" placeholder="Degree or Course" value="<?= htmlspecialchars($educational_background['grad_degree']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Period of Attendance</label>
                                        <input type="text" name="grad_period" class="form-control" placeholder="e.g., 2010-2014" value="<?= htmlspecialchars($educational_background['grad_period']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Highest Level</label>
                                        <input type="text" name="grad_level" class="form-control" placeholder="e.g., 4th Year" value="<?= htmlspecialchars($educational_background['grad_level']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Year Graduated</label>
                                        <input type="text" name="grad_year" class="form-control" placeholder="e.g., 2014" value="<?= htmlspecialchars($educational_background['grad_year']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Academic Honors</label>
                                        <input type="text" name="grad_acad" class="form-control" placeholder="e.g., Cum Laude" value="<?= htmlspecialchars($educational_background['grad_acad']) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
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
<script src="./assets/js/script.js"></script>
</body>
</html>
