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
    <title>PDS Reports</title>
    <style>
        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .report-header h1, .report-header p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media print {
            body {
                font-family: Arial, sans-serif;
            }
            table {
                page-break-inside: avoid;
            }
        }
        .header1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header1 img {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="header1">
    <img src="assets/img/logo1.jpg" alt="City Logo">
                            <div>
                                <p>Republic of the Philippines<br>
                                Province of Negros Occidental<br>
                                <strong>City of Sagay</strong><br>
                                OFFICE OF THE HUMAN RESOURCE & MANAGEMENT<br>
                                Cell No. 09171194285<br>
                                Email add: <em>www.hrmosagaycity@gmail.com</em></p>
                            </div>
                            <img src="assets/img/SAGAY.png" alt="HR Logo">
    </div>

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
                                    <p><strong>Full Name:</strong> <?= htmlspecialchars(trim(($employee_info['fname'] ?? '') . ' ' . ($employee_info['mname'] ?? '') . ' ' . ($employee_info['sname'] ?? '') . ' ' . ($employee_info['extension'] ?? ''))) ?></p>
                                    <p><strong>Sex:</strong> <?= htmlspecialchars($employee_info['sex'] ?? '') ?></p>
                                    <p><strong>Date of Birth:</strong> <?= htmlspecialchars($employee_info['datebirth'] ?? '') ?></p>
                                    <p><strong>Place of Birth:</strong> <?= htmlspecialchars($employee_info['placebirth'] ?? '') ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($employee_info['status'] ?? '') ?></p>
                                    <p><strong>Blood Type:</strong> <?= htmlspecialchars($employee_info['bloodtype'] ?? '') ?></p>
                                    <p><strong>Height:</strong> <?= htmlspecialchars($employee_info['height'] ?? '') ?></p>
                                    <p><strong>Weight:</strong> <?= htmlspecialchars($employee_info['weight'] ?? '') ?></p>
                                    <p><strong>CSC NO:</strong> <?= htmlspecialchars($employee_info['csc'] ?? '') ?></p>
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
                                    <p><strong>Spouse Name:</strong> <?= htmlspecialchars(trim(($family_info['spouse_sname'] ?? '') . ', ' . ($family_info['spouse_fname'] ?? '') . ' ' . ($family_info['spouse_mname'] ?? ''))) ?></p>
                                    <p><strong>Father's Name:</strong> <?= htmlspecialchars(trim(($family_info['father_sname'] ?? '') . ', ' . ($family_info['father_fname'] ?? '') . ' ' . ($family_info['father_mname'] ?? ''))) ?></p>
                                    <p><strong>Mother's Name:</strong> <?= htmlspecialchars(trim(($family_info['mothers_sname'] ?? '') . ', ' . ($family_info['mothers_fname'] ?? '') . ' ' . ($family_info['mothers_mname'] ?? ''))) ?></p>
                                    <p><strong>Children:</strong>
                                        <ul>
                                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                                <?php if (!empty($family_info["child{$i}_name"]) || !empty($family_info["child{$i}_birth"])): ?>
                                                    <li><?= htmlspecialchars($family_info["child{$i}_name"] ?? '') . ' - ' . htmlspecialchars($family_info["child{$i}_birth"] ?? '') ?></li>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Educational Background Card -->
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-graduation-cap"></i> Educational Background</h3>
                              
                                </div>
                                <div class="card-body">
                                    <p><strong>Elementary:</strong> <?= htmlspecialchars($educational_background['elementary'] ?? '') ?>, <?= htmlspecialchars($educational_background['elem_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['elem_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['elem_year'] ?? '') ?></p>
                                    <p><strong>Secondary:</strong> <?= htmlspecialchars($educational_background['secondary'] ?? '') ?>, <?= htmlspecialchars($educational_background['sec_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['sec_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['sec_year'] ?? '') ?></p>
                                    <p><strong>College:</strong> <?= htmlspecialchars($educational_background['college'] ?? '') ?>, <?= htmlspecialchars($educational_background['col_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['col_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['col_year'] ?? '') ?></p>
                                    <p><strong>Graduate:</strong> <?= htmlspecialchars($educational_background['graduate'] ?? '') ?>, <?= htmlspecialchars($educational_background['grad_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['grad_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['grad_year'] ?? '') ?></p>
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
                                    <p><strong>Position:</strong> <?= htmlspecialchars($work_experience['position'] ?? '') ?></p>
                                    <p><strong>Department:</strong> <?= htmlspecialchars($work_experience['department'] ?? '') ?></p>
                                    <p><strong>Salary:</strong> <?= htmlspecialchars($work_experience['salary'] ?? '') ?></p>
                                    <p><strong>Status:</strong> <?= htmlspecialchars($work_experience['status_appointment'] ?? '') ?></p>
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
                                    <p><strong>Career:</strong> <?= htmlspecialchars($civil_service_eligibility['career'] ?? '') ?></p>
                                    <p><strong>Rating:</strong> <?= htmlspecialchars($civil_service_eligibility['rating'] ?? '') ?></p>
                                    <p><strong>Date of Exam:</strong> <?= htmlspecialchars($civil_service_eligibility['date_exam'] ?? '') ?></p>
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
                                    <p><strong>Organization:</strong> <?= htmlspecialchars($voluntary_work['org_name'] ?? '') ?></p>
                                    <p><strong>From Date:</strong> <?= htmlspecialchars($voluntary_work['from_date'] ?? '') ?></p>
                                    <p><strong>To Date:</strong> <?= htmlspecialchars($voluntary_work['to_date'] ?? '') ?></p>
                                    <p><strong>Nature of Work:</strong> <?= htmlspecialchars($voluntary_work['nature_of_work'] ?? '') ?></p>
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
                                    <p><strong>Title:</strong> <?= htmlspecialchars($learning_development['title'] ?? '') ?></p>
                                    <p><strong>From Date:</strong> <?= htmlspecialchars($learning_development['from_date'] ?? '') ?></p>
                                    <p><strong>To Date:</strong> <?= htmlspecialchars($learning_development['to_date'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Other Information</h3>
                                  
                                </div>
                                <div class="card-body">
                                    <p><strong>Skills:</strong> <?= htmlspecialchars($other_info['skills'] ?? '') ?></p>
                                    <p><strong>Memberships:</strong> <?= htmlspecialchars($other_info['membership'] ?? '') ?></p>
                                    <p><strong>References:</strong>
                                        <ul>
                                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                                <?php if (!empty($other_info["ref_name{$i}"])): ?>
                                                    <li><?= htmlspecialchars($other_info["ref_name{$i}"] ?? '') ?> - <?= htmlspecialchars($other_info["ref_tel{$i}"] ?? '') ?></li>
                                                <?php endif; ?>
                                            <?php endfor; ?>
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
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>
