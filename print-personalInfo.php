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
            <!-- Personal Information -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-user"></i> Personal Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Full Name</strong></td><td><?= htmlspecialchars(trim(($employee_info['fname'] ?? '') . ' ' . ($employee_info['mname'] ?? '') . ' ' . ($employee_info['sname'] ?? '') . ' ' . ($employee_info['extension'] ?? ''))) ?></td></tr>
                    <tr><td><strong>Sex</strong></td><td><?= htmlspecialchars($employee_info['sex'] ?? '') ?></td></tr>
                    <tr><td><strong>Date of Birth</strong></td><td><?= htmlspecialchars($employee_info['datebirth'] ?? '') ?></td></tr>
                    <tr><td><strong>Place of Birth</strong></td><td><?= htmlspecialchars($employee_info['placebirth'] ?? '') ?></td></tr>
                    <tr><td><strong>Status</strong></td><td><?= htmlspecialchars($employee_info['status'] ?? '') ?></td></tr>
                    <tr><td><strong>Blood Type</strong></td><td><?= htmlspecialchars($employee_info['bloodtype'] ?? '') ?></td></tr>
                    <tr><td><strong>Height</strong></td><td><?= htmlspecialchars($employee_info['height'] ?? '') ?></td></tr>
                    <tr><td><strong>Weight</strong></td><td><?= htmlspecialchars($employee_info['weight'] ?? '') ?></td></tr>
                    <tr><td><strong>Citizenship</strong></td><td><?= htmlspecialchars($employee_info['citizenship'] ?? '') ?></td></tr>
                    <tr><td><strong>Permanent Address</strong></td><td>
                    <?= htmlspecialchars(trim(($employee_info['permaAdd'] ?? '') . ' ' . ($employee_info['permastreet'] ?? '') . ' ' . ($employee_info['permaSub'] ?? '') . ' ' . ($employee_info['permaBarangay'] ?? '') . ' ' . ($employee_info['permaCity']) . ' ' . ($employee_info['permaProvince']) . ' ' . ($employee_info['permaZip']))) ?>
                    </td></tr>
                    <tr><td><strong>Redential Address</strong></td><td>
                    <?= htmlspecialchars(trim(($employee_info['resAdd'] ?? '') . ' ' . ($employee_info['street'] ?? '') . ' ' . ($employee_info['subdivision'] ?? '') . ' ' . ($employee_info['barangay'] ?? '') . ' ' . ($employee_info['city']) . ' ' . ($employee_info['province']) . ' ' . ($employee_info['zipcode']))) ?>
                    </td></tr>
                   
                    
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-user"></i> Goverment ID's & Contact Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>CSC NO</strong></td><td><?= htmlspecialchars($employee_info['csc'] ?? '') ?></td></tr>
                    <tr><td><strong>GSIS No</strong></td><td><?= htmlspecialchars($employee_info['gsis_id'] ?? '') ?></td></tr>
                    <tr><td><strong>Pag-Ibig No</strong></td><td><?= htmlspecialchars($employee_info['pagibig_id'] ?? '') ?></td></tr>
                    <tr><td><strong>Philhealth NO</strong></td><td><?= htmlspecialchars($employee_info['philhealth_id'] ?? '') ?></td></tr>
                    <tr><td><strong>SSS No</strong></td><td><?= htmlspecialchars($employee_info['sss_id'] ?? '') ?></td></tr>
                    <tr><td><strong>TIN NO</strong></td><td><?= htmlspecialchars($employee_info['tin_id'] ?? '') ?></td></tr>
                    <tr><td><strong>Tel No</strong></td><td><?= htmlspecialchars($employee_info['telno'] ?? '') ?></td></tr>
                    <tr><td><strong>Mobile NO</strong></td><td><?= htmlspecialchars($employee_info['mobileno'] ?? '') ?></td></tr>
                    <tr><td><strong>Email</strong></td><td><?= htmlspecialchars($employee_info['email'] ?? '') ?></td></tr>
                    
                </tbody>
            </table>

            <!-- Family Information -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-users"></i> Family Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Spouse Name</strong></td><td><?= htmlspecialchars(trim(($family_info['spouse_sname'] ?? '') . ', ' . ($family_info['spouse_fname'] ?? '') . ' ' . ($family_info['spouse_mname'] ?? ''))) ?></td></tr>
                    <tr><td><strong>Occupation</strong></td><td><?= htmlspecialchars(trim(($family_info['Occupation'] ?? ''))) ?></td></tr>
                    <tr><td><strong>Business Address</strong></td><td><?= htmlspecialchars(trim(($family_info['bussAdd'] ?? ''))) ?></td></tr>
                    <tr><td><strong>Telephone</strong></td><td><?= htmlspecialchars(trim(($family_info['telephone'] ?? ''))) ?></td></tr>
                    <tr><td><strong>Father's Name</strong></td><td><?= htmlspecialchars(trim(($family_info['father_sname'] ?? '') . ', ' . ($family_info['father_fname'] ?? '') . ' ' . ($family_info['father_mname'] ?? ''))) ?></td></tr>
                    <tr><td><strong>Mother's Name</strong></td><td><?= htmlspecialchars(trim(($family_info['mothers_sname'] ?? '') . ', ' . ($family_info['mothers_fname'] ?? '') . ' ' . ($family_info['mothers_mname'] ?? ''))) ?></td></tr>
                    <tr><td><strong>Children</strong></td>
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

            <!-- Educational Background -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i> Educational Background</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Elementary</strong></td><td><?= htmlspecialchars($educational_background['elementary'] ?? '') ?>, <?= htmlspecialchars($educational_background['elem_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['elem_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['elem_year'] ?? '') ?></td></tr>
                    <tr><td><strong>Secondary</strong></td><td><?= htmlspecialchars($educational_background['secondary'] ?? '') ?>, <?= htmlspecialchars($educational_background['sec_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['sec_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['sec_year'] ?? '') ?></td></tr>
                    <tr><td><strong>College</strong></td><td><?= htmlspecialchars($educational_background['college'] ?? '') ?>, <?= htmlspecialchars($educational_background['col_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['col_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['col_year'] ?? '') ?></td></tr>
                    <tr><td><strong>Graduate</strong></td><td><?= htmlspecialchars($educational_background['graduate'] ?? '') ?>, <?= htmlspecialchars($educational_background['grad_degree'] ?? '') ?>, <?= htmlspecialchars($educational_background['grad_period'] ?? '') ?>, <?= htmlspecialchars($educational_background['grad_year'] ?? '') ?></td></tr>
                </tbody>
            </table>

             <!-- Civil Service Eligibility -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i> Civil Service Eligibility</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Career</strong></td><td><?= htmlspecialchars($civil_service_eligibility['career'] ?? '') ?></td></tr>
                    <tr><td><strong>Rating</strong></td><td><?= htmlspecialchars($civil_service_eligibility['rating'] ?? '') ?></td></tr>
                    <tr><td><strong>Date of Exam</strong></td><td><?= htmlspecialchars($civil_service_eligibility['date_exam'] ?? '') ?></td></tr>
                    <tr><td><strong>Place of Exam</strong></td><td><?= htmlspecialchars($civil_service_eligibility['place_exam'] ?? '') ?></td></tr>
                    <tr><td><strong>License No.</strong></td><td><?= htmlspecialchars($civil_service_eligibility['license_no'] ?? '') ?></td></tr>
                </tbody>
            </table>

            <!-- Work Experience -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i> Work Experience</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Inclusive Date</strong></td><td><?= htmlspecialchars($work_experience['from_date'] ?? '') ?> - <?= htmlspecialchars($work_experience['to_date'] ?? '') ?></td></tr>
                    <tr><td><strong>Position / Title</strong></td><td><?= htmlspecialchars($work_experience['position'] ?? '') ?></td></tr>
                    <tr><td><strong>Department / Agency / Company</strong></td><td><?= htmlspecialchars($work_experience['department'] ?? '') ?></td></tr>
                    <tr><td><strong>Monthly Salary</strong></td><td><?= htmlspecialchars($work_experience['salary'] ?? '') ?></td></tr>
                    <tr><td><strong>Salary Grade</strong></td><td><?= htmlspecialchars($work_experience['salary_grade'] ?? '') ?></td></tr>
                    <tr><td><strong>Status Appointment</strong></td><td><?= htmlspecialchars($work_experience['status_appointment'] ?? '') ?></td></tr>
                    <tr><td><strong>Government Service</strong></td><td><?= htmlspecialchars($work_experience['gov_service'] ?? '') ?></td></tr>
                </tbody>
            </table>

            <!-- Voluntary Work Involvement -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i> Voluntary Work Involvement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Name of Organization</strong></td><td><?= htmlspecialchars($voluntary_work['org_name'] ?? '') ?></td></tr>
                    <tr><td><strong>Inclusive Date</strong></td><td><?= htmlspecialchars($voluntary_work['from_date'] ?? '') ?> - <?= htmlspecialchars($voluntary_work['to_date'] ?? '') ?></td></tr>
                    <tr><td><strong>Number of Hours</strong></td><td><?= htmlspecialchars($voluntary_work['hours'] ?? '') ?></td></tr>
                    <tr><td><strong>Nature of Work</strong></td><td><?= htmlspecialchars($voluntary_work['nature_of_work'] ?? '') ?></td></tr>
                </tbody>
            </table>
                <!-- LEARNING DEVELOPMENT -->
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i> Learning Development</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>Title of Learning Development Intervention Program</strong></td><td><?= htmlspecialchars($learning_development['title'] ?? '') ?></td></tr>
                    <tr><td><strong>Inclusive Date</strong></td><td><?= htmlspecialchars($learning_development['from_date'] ?? '') ?> - <?= htmlspecialchars($learning_development['to_date'] ?? '') ?></td></tr>
                    <tr><td><strong>Type of ID</strong></td><td><?= htmlspecialchars($learning_development['citizenship_type'] ?? '') ?></td></tr>
                    <tr><td><strong>Conducted / Sponsored by</strong></td><td><?= htmlspecialchars($learning_development['conducted_by'] ?? '') ?></td></tr>
                </tbody>
            </table>
                <!-- Other Information -->
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i> Other Information</th>
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
                       <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i>REFERENCES (Person not related by consanguinity or affinity to applicant/appointee)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>NAME:</strong></td><td><?= htmlspecialchars($other_info['ref_nameq'] ?? '') ?></td></tr>
                    <tr><td><strong>ADDRESS:</strong></td><td><?= htmlspecialchars($other_info['re_add1'] ?? '') ?> </td></tr>
                    <tr><td><strong>TEL. NO.
                    </strong></td><td><?= htmlspecialchars($other_info['ref_tel1'] ?? '') ?></td></tr>
                    <tr><td><strong>NAME:</strong></td><td><?= htmlspecialchars($other_info['ref_name2'] ?? '') ?></td></tr>
                    <tr><td><strong>ADDRESS:</strong></td><td><?= htmlspecialchars($other_info['re_add2'] ?? '') ?> </td></tr>
                    <tr><td><strong>TEL. NO.
                    </strong></td><td><?= htmlspecialchars($other_info['ref_tel2'] ?? '') ?></td></tr>
                    <tr><td><strong>NAME:</strong></td><td><?= htmlspecialchars($other_info['ref_name3'] ?? '') ?></td></tr>
                    <tr><td><strong>ADDRESS:</strong></td><td><?= htmlspecialchars($other_info['re_add3'] ?? '') ?> </td></tr>
                    <tr><td><strong>TEL. NO.
                    </strong></td><td><?= htmlspecialchars($other_info['ref_tel3'] ?? '') ?></td></tr>
                </tbody>
            </table>
            </table>
                       <!-- Other Information -->
                       <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"><i class="fas fa-graduation-cap"></i>I declare under oath I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines...</th>
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


            <!-- Additional tables for Work Experience, Civil Service Eligibility, Voluntary Work, Learning and Development, and Other Information can be added similarly -->
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
