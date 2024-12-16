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
    <title>Add PDS</title>
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
            <?php include './util/session-message.php'?>
        

                <!-- Card with Nav List -->
                <div class="card mt-2">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Personal Data Sheet (PDS)</h3>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="personal_info.php" class="nav-link">
                                    <i class="fas fa-user"></i> I. Personal Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="famb.php" class="nav-link">
                                    <i class="fas fa-users"></i> II. Family Background
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="educational.php" class="nav-link">
                                    <i class="fas fa-graduation-cap"></i> III. Educational Background
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="civil_service.php" class="nav-link">
                                    <i class="fas fa-certificate"></i> IV. Civil Service Eligibility
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="work_exp.php" class="nav-link">
                                    <i class="fas fa-briefcase"></i> V. Work Experience
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="voluntary.php" class="nav-link">
                                    <i class="fas fa-hand-holding-heart"></i> VI. Voluntary Work Or Involvement In Civic/People/Voluntary Organization/s
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="learning.php" class="nav-link">
                                    <i class="fas fa-book-reader"></i> VII. Learning And Development (L&D) Interventions/Training Programs Attended
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="other.php" class="nav-link">
                                    <i class="fas fa-info-circle"></i> VIII. Other Information
                                </a>
                            </li>
                        </ul>
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

