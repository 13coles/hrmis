<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once './config/conn.php';
require './util/encrypt_helper.php';
$employee_info = null; 
$family_info = null;
$educational_background = null;
$work_experience = null;
$civil_service_eligibility = null;
$voluntary_work = null;
$other_info = null;
$learning_development = null;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $employee_no = decrypt_id($token);

    if ($employee_no !== false) {
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
} else {
    // Handle invalid or tampered token
    echo "Invalid token.";
    exit();
}
} else {
// Handle missing token
echo "Token is missing.";
exit();
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
        
        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
         

                <?php if ($employee_info): ?>
                    <section class="content-header">
                        <div class="container-fluid d-flex justify-content-between align-items-center">
                            <h4 class="m-0"><i class="fas fa-id-card text-primary"></i> Personal Data Sheet</h4>
                            <?php $token = encrypt_id($employee_info['employee_no']);?>
                            <a href="print-personalInfo.php?token=<?php echo $token; ?>" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
                        </div>
                    </section>

                    <div class="row">
                        <!-- Personal Information Card -->
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-user"></i> Personal Information</h3>
                                    <?php $token = isset($employee_info['id']) ? encrypt_id($employee_info['id']) : null;?>
                                    <a href="edit_personal_info.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                    <i class="fas fa-edit"></i></a>
                                </div>
                                <div class="card-body">
                                <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Full Name:</th>
                                                <td><?= htmlspecialchars(trim(($employee_info['fname'] ?? '') . ' ' . ($employee_info['mname'] ?? '') . ' ' . ($employee_info['sname'] ?? '') . ' ' . ($employee_info['extension'] ?? ''))) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Sex:</th>
                                                <td><?= htmlspecialchars($employee_info['sex'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth:</th>
                                                <td><?= htmlspecialchars($employee_info['datebirth'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Place of Birth:</th>
                                                <td><?= htmlspecialchars($employee_info['placebirth'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td><?= htmlspecialchars($employee_info['status'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Blood Type:</th>
                                                <td><?= htmlspecialchars($employee_info['bloodtype'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Height:</th>
                                                <td><?= htmlspecialchars($employee_info['height'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Weight:</th>
                                                <td><?= htmlspecialchars($employee_info['weight'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Citizenship:</th>
                                                <td><?= htmlspecialchars($employee_info['citizenship'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Permanent Address:</th>
                                                <td><?= htmlspecialchars(trim(($employee_info['permaAdd'] ?? '') . ' ' . ($employee_info['permastreet'] ?? '') . ' ' . ($employee_info['permaSub'] ?? '') . ' ' . ($employee_info['permaBarangay'] ?? '') . ' ' . ($employee_info['permaCity']) . ' ' . ($employee_info['permaProvince']) . ' ' . ($employee_info['permaZip']))) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Residential Address:</th>
                                                <td><?= htmlspecialchars(trim(($employee_info['resAdd'] ?? '') . ' ' . ($employee_info['street'] ?? '') . ' ' . ($employee_info['subdivision'] ?? '') . ' ' . ($employee_info['barangay'] ?? '') . ' ' . ($employee_info['city']) . ' ' . ($employee_info['province']) . ' ' . ($employee_info['zipcode']))) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tel No:</th>
                                                <td><?= htmlspecialchars($employee_info['telno'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Mobile No:</th>
                                                <td><?= htmlspecialchars($employee_info['mobileno'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email:</th>
                                                <td><?= htmlspecialchars($employee_info['email'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>GSIS No:</th>
                                                <td><?= htmlspecialchars($employee_info['gsis_id'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Pag-Ibig No:</th>
                                                <td><?= htmlspecialchars($employee_info['pagibig_id'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Philhealth No:</th>
                                                <td><?= htmlspecialchars($employee_info['philhealth_id'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>SSS No:</th>
                                                <td><?= htmlspecialchars($employee_info['sss_id'] ?? '') ?></td>
                                            </tr>
                                            <tr>
                                                <th>TIN No:</th>
                                                <td><?= htmlspecialchars($employee_info['tin_id'] ?? '') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                      
                    </div>
                    <div class="row">

                <!-- Family Information Table -->
                <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users"></i> Family Information</h3>
                                <?php $token = isset($family_info['id']) ? encrypt_id($family_info['id']) : null;?>
                                <a href="edit_fami.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                <i class="fas fa-edit"></i></a>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Spouse Name:</th>
                                            <td><?= htmlspecialchars(trim(($family_info['spouse_sname'] ?? '') . ', ' . ($family_info['spouse_fname'] ?? '') . ' ' . ($family_info['spouse_mname'] ?? ''))) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Occupation:</th>
                                            <td><?= htmlspecialchars(trim(($family_info['occupation'] ?? ''))) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Business Address:</th>
                                            <td><?= htmlspecialchars(trim(($family_info['bussAdd'] ?? ''))) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Telephone:</th>
                                            <td><?= htmlspecialchars(trim(($family_info['telephone'] ?? ''))) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Father's Name:</th>
                                            <td><?= htmlspecialchars(trim(($family_info['father_sname'] ?? '') . ', ' . ($family_info['father_fname'] ?? '') . ' ' . ($family_info['father_mname'] ?? ''))) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mother's Name:</th>
                                            <td><?= htmlspecialchars(trim(($family_info['mothers_sname'] ?? '') . ', ' . ($family_info['mothers_fname'] ?? '') . ' ' . ($family_info['mothers_mname'] ?? ''))) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Children:</th>
                                            <td>
                                                <ul>
                                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                                        <?php if (!empty($family_info["child{$i}_name"]) || !empty($family_info["child{$i}_birth"])): ?>
                                                            <li><?= htmlspecialchars($family_info["child{$i}_name"] ?? '') . ' - ' . htmlspecialchars($family_info["child{$i}_birth"] ?? '') ?></li>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-graduation-cap"></i> Educational Background</h3>
                                <?php $token = isset($educational_background['id']) ? encrypt_id($educational_background['id']) : null;?>
                                <a href="edit_edu.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Elementary:</th>
                                            <td>
                                                <?= htmlspecialchars($educational_background['elementary'] ?? '') ?><br>
                                                Degree: <?= htmlspecialchars($educational_background['elem_degree'] ?? '') ?><br>
                                                Period: <?= htmlspecialchars($educational_background['elem_period'] ?? '') ?><br>
                                                Year Graduated: <?= htmlspecialchars($educational_background['elem_year'] ?? '') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Secondary:</th>
                                            <td>
                                                <?= htmlspecialchars($educational_background['secondary'] ?? '') ?><br>
                                                Degree: <?= htmlspecialchars($educational_background['sec_degree'] ?? '') ?><br>
                                                Period: <?= htmlspecialchars($educational_background['sec_period'] ?? '') ?><br>
                                                Year Graduated: <?= htmlspecialchars($educational_background['sec_year'] ?? '') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>College:</th>
                                            <td>
                                                <?= htmlspecialchars($educational_background['college'] ?? '') ?><br>
                                                Degree: <?= htmlspecialchars($educational_background['col_degree'] ?? '') ?><br>
                                                Period: <?= htmlspecialchars($educational_background['col_period'] ?? '') ?><br>
                                                Year Graduated: <?= htmlspecialchars($educational_background['col_year'] ?? '') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Graduate:</th>
                                            <td>
                                                <?= htmlspecialchars($educational_background['graduate'] ?? '') ?><br>
                                                Degree: <?= htmlspecialchars($educational_background['grad_degree'] ?? '') ?><br>
                                                Period: <?= htmlspecialchars($educational_background['grad_period'] ?? '') ?><br>
                                                Year Graduated: <?= htmlspecialchars($educational_background['grad_year'] ?? '') ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                <?php $token = isset($civil_service_eligibility['id']) ? encrypt_id($civil_service_eligibility['id']) : null;?>
                                <a href="edit_cs.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Career:</th>
                                            <td><?= htmlspecialchars($civil_service_eligibility['career'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Rating:</th>
                                            <td><?= htmlspecialchars($civil_service_eligibility['rating'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Date of Exam:</th>
                                            <td><?= htmlspecialchars($civil_service_eligibility['date_exam'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Place of Exam:</th>
                                            <td><?= htmlspecialchars($civil_service_eligibility['place_exam'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>License No.:</th>
                                            <td><?= htmlspecialchars($civil_service_eligibility['license_no'] ?? '') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-hands-helping"></i> Voluntary Work</h3>
                                <?php $token = isset($voluntary_work['id']) ? encrypt_id($voluntary_work['id']) : null;?>
                                <a href="edit_voluntary.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Organization:</th>
                                            <td><?= htmlspecialchars($voluntary_work['org_name'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>From Date:</th>
                                            <td><?= htmlspecialchars($voluntary_work['from_date'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>To Date:</th>
                                            <td><?= htmlspecialchars($voluntary_work['to_date'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Number of Hours:</th>
                                            <td><?= htmlspecialchars($voluntary_work['hours'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nature of Work:</th>
                                            <td><?= htmlspecialchars($voluntary_work['nature_of_work'] ?? '') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Learning Development-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Learning and Development</h3>
                                <?php $token = isset($learning_development['id']) ? encrypt_id($learning_development['id']) : null;?>
                                <a href="edit_learning.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Title:</th>
                                            <td><?= htmlspecialchars($learning_development['title'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>From Date:</th>
                                            <td><?= htmlspecialchars($learning_development['from_date'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>To Date:</th>
                                            <td><?= htmlspecialchars($learning_development['to_date'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Type of ID:</th>
                                            <td><?= htmlspecialchars($learning_development['citizenship_type'] ?? '') ?></td>
                                        </tr>

                                        <tr>
                                            <th>Conducted / Sponsored by:</th>
                                            <td><?= htmlspecialchars($learning_development['conducted_by'] ?? '') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-briefcase"></i> Work Experience</h3>
                                <?php $token = isset($work_experience['id']) ? encrypt_id($work_experience['id']) : null;?>
                                <a href="edit_workexp.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Inclusive Date:</th>
                                            <td><?= htmlspecialchars($work_experience['from_date'] ?? '') ?> - <?= htmlspecialchars($work_experience['to_date'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Position:</th>
                                            <td><?= htmlspecialchars($work_experience['position'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Department:</th>
                                            <td><?= htmlspecialchars($work_experience['department'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Salary:</th>
                                            <td><?= htmlspecialchars($work_experience['salary'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td><?= htmlspecialchars($work_experience['status_appointment'] ?? '') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Government Service:</th>
                                            <td><?= htmlspecialchars($work_experience['gov_service'] ?? '') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Other Information -->
                <table class="table table-bordered bg-white">
                <thead>
                    <tr class="bg-info">
                        <th colspan="2"><i class="fas fa-info-circle"></i> Other Information
                        <?php $token = isset($other_info['id']) ? encrypt_id($other_info['id']) : null;?>
                                    <a href="edit_other_info.php?token=<?php echo $token; ?>" class="btn btn-primary-outline btn-sm float-right">
                                    <i class="fas fa-edit"></i></a>
                        </th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Special Skills & Hobbies</strong></td><td><?= htmlspecialchars($other_info['skills'] ?? '') ?></td></tr>
                    <tr><td><strong>Non-Academic Distinctions/Recognition</strong></td><td><?= htmlspecialchars($other_info['non_academic'] ?? '') ?> </td></tr>
                    <tr><td><strong>Membership in Association/Organization</strong></td><td><?= htmlspecialchars($other_info['membership'] ?? '') ?></td></tr>
                    <tr><td><strong>Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or to the person who has immediate supervision over you in the Office, Bureau, or Department where you will be appointed, a. within the third degree?
                    </strong></td><td><?= htmlspecialchars($other_info['if_third'] ?? '') ?></td></tr>
                    <tr><td><strong>b. within the fourth degree (for Local Government Unit-Career Employee)?</strong></td><td><?= htmlspecialchars($other_info['if_guilty'] ?? '') ?></td></tr>
                    <tr><td><strong> a. Have you been found guilty of any administrative offense?</strong></td><td><?= htmlspecialchars($other_info['if_fourth'] ?? '') ?> </td></tr>
                    <tr><td><strong>b. Have you been criminally charged before any court?</strong></td><td><?= htmlspecialchars($other_info['if_criminal'] ?? '') ?></td></tr>
                    <tr><td><strong> Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</strong></td><td><?= htmlspecialchars($other_info['if_convicted'] ?? '') ?></td></tr>
                    <tr><td><strong>Have you ever been convicted of any violation of any law, decree, ordinance or regulation by any court or tribunal?</strong></td><td><?= htmlspecialchars($other_info['if_separated'] ?? '') ?> </td></tr>
                    <tr><td><strong>a. Have you been a candidate in a national or local election held within the last year (except Barangay election)?</strong></td><td><?= htmlspecialchars($other_info['if_candidate'] ?? '') ?></td></tr>
                    <tr><td><strong>b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</strong></td><td><?= htmlspecialchars($other_info['if_resigned'] ?? '') ?></td></tr>
                    <tr><td><strong>Have you acquired the status of an immigrant or permanent resident of another country?</strong></td><td><?= htmlspecialchars($other_info['if_immigrant'] ?? '') ?> </td></tr>
                    <tr><td><strong> Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277) and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items: a. Are you a member of any indigenous group?</strong></td><td><?= htmlspecialchars($other_info['if_indigenous'] ?? '') ?></td></tr>
                </tbody>
                </table>
                    <!-- Other Information -->
                    <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-user-friends"></i> REFERENCES (Person not related by consanguinity or affinity to applicant/appointee)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Name:</strong></td><td><?= htmlspecialchars($other_info['ref_nameq'] ?? '') ?></td></tr>
                    <tr><td><strong>Address:</strong></td><td><?= htmlspecialchars($other_info['re_add1'] ?? '') ?> </td></tr>
                    <tr><td><strong>Tel No.
                    </strong></td><td><?= htmlspecialchars($other_info['ref_tel1'] ?? '') ?></td></tr>
                    <tr><td><strong>Name:</strong></td><td><?= htmlspecialchars($other_info['ref_name2'] ?? '') ?></td></tr>
                    <tr><td><strong>Address:</strong></td><td><?= htmlspecialchars($other_info['re_add2'] ?? '') ?> </td></tr>
                    <tr><td><strong>Tel. No.
                    </strong></td><td><?= htmlspecialchars($other_info['ref_tel2'] ?? '') ?></td></tr>
                    <tr><td><strong>Name:</strong></td><td><?= htmlspecialchars($other_info['ref_name3'] ?? '') ?></td></tr>
                    <tr><td><strong>Address:</strong></td><td><?= htmlspecialchars($other_info['re_add3'] ?? '') ?> </td></tr>
                    <tr><td><strong>Tel. No.
                    </strong></td><td><?= htmlspecialchars($other_info['ref_tel3'] ?? '') ?></td></tr>
                </tbody>
                </table>
                </table>
                    <!-- Other Information -->
                    <table class="table table-bordered bg-white">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas  fa-sticky-note"></i> I declare under oath I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines...</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Government ID:</strong></td><td><?= htmlspecialchars($other_info['title'] ?? '') ?></td></tr>
                    <tr><td><strong>assport or License ID:</strong></td><td><?= htmlspecialchars($other_info['from_date'] ?? '') ?> - <?= htmlspecialchars($other_info['to_date'] ?? '') ?></td></tr>
                    <tr><td><strong>Membership in Association/Organization</strong></td><td><?= htmlspecialchars($other_info['citezenship_type'] ?? '') ?></td></tr>
                    <tr><td><strong>EL. NO.Date of Issuance:
                    </strong></td><td><?= htmlspecialchars($other_info['conducted_by'] ?? '') ?></td></tr>
                </tbody>
                </table>


                <?php else: ?>
                <div class="alert alert-warning mt-5">
                    <strong>No data found for the provided employee number. Create PDS first click this link <a href="PDS.php">Go to</a></strong>
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
<script src="./assets/js/script.js"></script>
</body>
</html>