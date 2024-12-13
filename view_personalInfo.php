<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once './config/conn.php';

$employee_info = null; 
$family_info = null;
$educational_background = null;
$work_experience = null;
$civil_service_eligibility = null;
$voluntary_work = null;
$other_info = null;
$learning_development = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_no'])) {
    $employee_no = intval($_POST['employee_no']);
    
    // Personal Info Query
    $query = "SELECT * FROM personal_info WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $employee_info = $stmt->get_result()->fetch_assoc();

    // Family Info Query
    $query = "SELECT * FROM family_info WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $family_info = $stmt->get_result()->fetch_assoc();

    // Educational Background Query
    $query = "SELECT * FROM educational_background WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $educational_background = $stmt->get_result()->fetch_assoc();

    // Work Experience Query
    $query = "SELECT * FROM work_experience WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $work_experience = $stmt->get_result()->fetch_assoc();

    // Civil Service Eligibility Query
    $query = "SELECT * FROM civil_service_eligibility WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $civil_service_eligibility = $stmt->get_result()->fetch_assoc();

    // Voluntary Work Query
    $query = "SELECT * FROM voluntary_work WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $voluntary_work = $stmt->get_result()->fetch_assoc();

    // Other Info Query
    $query = "SELECT * FROM other_info WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $other_info = $stmt->get_result()->fetch_assoc();

    // Learning Development Query
    $query = "SELECT * FROM learning_development WHERE employee_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employee_no);
    $stmt->execute();
    $learning_development = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View PDS</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
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
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fas fa-id-card text-primary"></i> Personal Data Sheet</h4>
                <button class="btn btn-primary btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
         

                <?php if ($employee_info): ?>
                    <div class="row">
                        <!-- Personal Information Card -->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-user"></i> Personal Information</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Full Name:</strong> <?= htmlspecialchars($employee_info['fname'] . ' ' . $employee_info['mname'] . ' ' . $employee_info['sname'] . ' ' . $employee_info['extension']) ?></p>
                                    <p><strong>Sex:</strong> <?= htmlspecialchars($employee_info['sex']) ?></p>
                                    <p><strong>Date of Birth:</strong> <?= htmlspecialchars($employee_info['datebirth']) ?></p>
                                    <p><strong>Place of Birth:</strong> <?= htmlspecialchars($employee_info['placebirth']) ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($employee_info['status']) ?></p>
                                    <p><strong>Blood Type:</strong> <?= htmlspecialchars($employee_info['bloodtype']) ?></p>
                                    <p><strong>Height:</strong> <?= htmlspecialchars($employee_info['height']) ?></p>
                                    <p><strong>Weight:</strong> <?= htmlspecialchars($employee_info['weight']) ?></p>
                                    <p><strong>CSC NO:</strong> <?= htmlspecialchars($employee_info['csc']) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Family Information Card -->
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-users"></i> Family Information</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Spouse Name:</strong> <?= htmlspecialchars($family_info['spouse_sname'] . ', ' . $family_info['spouse_fname'] . ' ' . $family_info['spouse_mname']) ?></p>
                                    <p><strong>Father's Name:</strong> <?= htmlspecialchars($family_info['father_sname'] . ', ' . $family_info['father_fname'] . ' ' . $family_info['father_mname']) ?></p>
                                    <p><strong>Mother's Name:</strong> <?= htmlspecialchars($family_info['mothers_sname'] . ', ' . $family_info['mothers_fname'] . ' ' . $family_info['mothers_mname']) ?></p>
                                    <p><strong>Children:</strong>
                                        <ul>
                                            <li><?= htmlspecialchars($family_info['child1_name']) . ' - ' . htmlspecialchars($family_info['child1_birth']) ?></li>
                                            <li><?= htmlspecialchars($family_info['child2_name']) . ' - ' . htmlspecialchars($family_info['child2_birth']) ?></li>
                                            <li><?= htmlspecialchars($family_info['child3_name']) . ' - ' . htmlspecialchars($family_info['child3_birth']) ?></li>
                                            <li><?= htmlspecialchars($family_info['child4_name']) . ' - ' . htmlspecialchars($family_info['child4_birth']) ?></li>
                                            <li><?= htmlspecialchars($family_info['child5_name']) . ' - ' . htmlspecialchars($family_info['child5_birth']) ?></li>
                                            <li><?= htmlspecialchars($family_info['child6_name']) . ' - ' . htmlspecialchars($family_info['child6_birth']) ?></li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Cards (Educational, Work Experience, etc.) -->
                    <div class="row">
                        <!-- Educational Background Card -->
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-graduation-cap"></i> Educational Background</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Elementary:</strong> <?= htmlspecialchars($educational_background['elementary']) ?>, <?= htmlspecialchars($educational_background['elem_degree']) ?>, <?= htmlspecialchars($educational_background['elem_period']) ?>, <?= htmlspecialchars($educational_background['elem_year']) ?></p>
                                    <p><strong>Secondary:</strong> <?= htmlspecialchars($educational_background['secondary']) ?>, <?= htmlspecialchars($educational_background['sec_degree']) ?>, <?= htmlspecialchars($educational_background['sec_period']) ?>, <?= htmlspecialchars($educational_background['sec_year']) ?></p>
                                    <p><strong>College:</strong> <?= htmlspecialchars($educational_background['college']) ?>, <?= htmlspecialchars($educational_background['col_degree']) ?>, <?= htmlspecialchars($educational_background['col_period']) ?>, <?= htmlspecialchars($educational_background['col_year']) ?></p>
                                    <p><strong>Graduate:</strong> <?= htmlspecialchars($educational_background['graduate']) ?>, <?= htmlspecialchars($educational_background['grad_degree']) ?>, <?= htmlspecialchars($educational_background['grad_period']) ?>, <?= htmlspecialchars($educational_background['grad_year']) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Work Experience Card -->
                        <div class="col-md-6">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-briefcase"></i> Work Experience</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Position:</strong> <?= htmlspecialchars($work_experience['position']) ?></p>
                                    <p><strong>Department:</strong> <?= htmlspecialchars($work_experience['department']) ?></p>
                                    <p><strong>Salary:</strong> <?= htmlspecialchars($work_experience['salary']) ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($work_experience['status_appointment']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Civil Service Eligibility Card -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-flag"></i> Civil Service Eligibility</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Career:</strong> <?= htmlspecialchars($civil_service_eligibility['career']) ?></p>
                                    <p><strong>Rating:</strong> <?= htmlspecialchars($civil_service_eligibility['rating']) ?></p>
                                    <p><strong>Date of Exam:</strong> <?= htmlspecialchars($civil_service_eligibility['date_exam']) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Voluntary Work Card -->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-hands-helping"></i> Voluntary Work</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Organization:</strong> <?= htmlspecialchars($voluntary_work['org_name']) ?></p>
                                    <p><strong>From Date:</strong> <?= htmlspecialchars($voluntary_work['from_date']) ?></p>
                                    <p><strong>To Date:</strong> <?= htmlspecialchars($voluntary_work['to_date']) ?></p>
                                    <p><strong>Nature of Work:</strong> <?= htmlspecialchars($voluntary_work['nature_of_work']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Other Info Card -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Learning and Development</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Title:</strong> <?= htmlspecialchars($learning_development['title']) ?></p>
                                    <p><strong>From Date:</strong> <?= htmlspecialchars($learning_development['from_date']) ?></p>
                                    <p><strong>To Date:</strong> <?= htmlspecialchars($learning_development['to_date']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Other Information</h3>
                                </div>
                                <div class="card-body">
                                    <p><strong>Skills:</strong> <?= htmlspecialchars($other_info['skills']) ?></p>
                                    <p><strong>Memberships:</strong> <?= htmlspecialchars($other_info['membership']) ?></p>
                                    <p><strong>References:</strong>
                                        <ul>
                                            <li><?= htmlspecialchars($other_info['ref_nameq']) ?> - <?= htmlspecialchars($other_info['ref_tel1']) ?></li>
                                            <li><?= htmlspecialchars($other_info['ref_name2']) ?> - <?= htmlspecialchars($other_info['ref_tel2']) ?></li>
                                            <li><?= htmlspecialchars($other_info['ref_name3']) ?> - <?= htmlspecialchars($other_info['ref_tel3']) ?></li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="alert alert-warning">
                        <strong>No data found for the provided employee number.</strong>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

    <?php include './util/footer.php'; ?>

</div>

<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
