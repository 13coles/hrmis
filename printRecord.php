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
    $employee_id = decrypt_id($token);
    $employeeQuery = "SELECT 
                        e.id AS employee_id, 
                        CONCAT(e.last_name, ', ', e.first_name, ' ', IFNULL(e.middle_name, ''), ' ', IFNULL(e.extension_name, '')) AS full_name,
                        e.position, e.department_name AS department, e.salary_grade, e.step, e.date_hired, e.status, e.contact_number, 
                        e.height, e.weight, e.educational_attainment, e.course, e.blood_type, e.nationality, e.spouse_name, 
                        e.spouse_occupation, e.employee_type
                      FROM employees e
                      WHERE e.id = ?";
    $stmt = $conn->prepare($employeeQuery);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $employeeResult = $stmt->get_result();
    if ($employeeResult->num_rows > 0) {
        $employee = $employeeResult->fetch_assoc();
    } else {
        echo "No employee record found.";
        exit();
    }
    $emergencyContactQuery = "SELECT 
                                ec.person_name, ec.relationship, ec.tel_no, ec.e_street, ec.e_barangay, ec.e_city, ec.e_province
                              FROM emergency_contacts ec
                              WHERE ec.employee_id = ?";
    $stmt = $conn->prepare($emergencyContactQuery);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $emergencyContactResult = $stmt->get_result();
    if ($emergencyContactResult->num_rows > 0) {
        $emergencyContact = $emergencyContactResult->fetch_assoc();
    } else {
        $emergencyContact = null; 
    }
    $governmentIdsQuery = "SELECT 
                            g.gsis_number, g.sss_number, g.tin_number, g.philhealth_number, g.pagibig_number, 
                            g.eligibility, g.prc_number, g.prc_expiry_date
                          FROM government_ids g
                          WHERE g.employee_id = ?";
    $stmt = $conn->prepare($governmentIdsQuery);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $governmentIdsResult = $stmt->get_result();
    if ($governmentIdsResult->num_rows > 0) {
        $governmentIds = $governmentIdsResult->fetch_assoc();
    } else {
        $governmentIds = null; 
    }
    $addressQuery = "SELECT 
                            a.street, a.barangay, a.city, a.province
                        FROM address a
                        WHERE a.employee_id = ?";
    $stmt = $conn->prepare($addressQuery);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $addressResult = $stmt->get_result();
    if ($addressResult->num_rows > 0) {
    $address = $addressResult->fetch_assoc();
    } else {
    $address = null; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Report</title>
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
                <?php if (!isset($employee)): ?>
                    <div class="alert alert-warning">No employee record found.</div>
                    <?php exit(); ?>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-user"></i> Employee Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-info"><i class="fas fa-user-circle"></i> Summary</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Employee Name</th>
                                            <td><?= htmlspecialchars($employee['full_name'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Position</th>
                                            <td><?= htmlspecialchars($employee['position'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td><?= htmlspecialchars($employee['department'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Salary Grade</th>
                                            <td><?= htmlspecialchars($employee['salary_grade'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Step</th>
                                            <td><?= htmlspecialchars($employee['step'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Date Hired</th>
                                            <td><?= htmlspecialchars($employee['date_hired'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><?= htmlspecialchars($employee['status'] ?? 'N/A'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-info"><i class="fas fa-phone-alt"></i> Personal Information</h5>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th>Contact Number</th>
                                            <td><?= htmlspecialchars($employee['contact_number'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Height</th>
                                            <td><?= htmlspecialchars($employee['height'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Weight</th>
                                            <td><?= htmlspecialchars($employee['weight'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Educational Attainment</th>
                                            <td><?= htmlspecialchars($employee['educational_attainment'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Course</th>
                                            <td><?= htmlspecialchars($employee['course'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Blood Type</th>
                                            <td><?= htmlspecialchars($employee['blood_type'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nationality</th>
                                            <td><?= htmlspecialchars($employee['nationality'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Spouse Name</th>
                                            <td><?= htmlspecialchars($employee['spouse_name'] ?? 'N/A'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Spouse Occupation</th>
                                            <td><?= htmlspecialchars($employee['spouse_occupation'] ?? 'N/A'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-home"></i> Address</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Address -->
                                <?php if ($address): ?>
                                    <h5 class="text-info"><i class="fas fa-home mb2"></i> Home Address</h5>
                                    <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Street</th>
                                                    <td><?= htmlspecialchars($address['street'] ?? 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Baramgay</th>
                                                    <td><?= htmlspecialchars($address['barangay'] ?? 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>City/Municipal</th>
                                                    <td><?= htmlspecialchars($address['city'] ?? 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Province</th>
                                                    <td><?= htmlspecialchars($address['province'] ?? 'N/A'); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                <?php endif; ?>

                            </div>
                            <div class="col-md-6">
                                <!-- Emergency Contact -->
                                <?php if ($emergencyContact): ?>
                                    <h3 class="card-title"><i class="fas fa-phone-alt mb-2"></i> Emergency Contact</h3>
                                    <table class="table table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th>Contact Name</th>
                                                        <td><?= htmlspecialchars($emergencyContact['person_name'] ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Relationship</th>
                                                        <td><?= htmlspecialchars($emergencyContact['relationship'] ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Number</th>
                                                        <td><?= htmlspecialchars($emergencyContact['tel_no'] ?? 'N/A'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td><?= htmlspecialchars($emergencyContact['e_street'] ?? 'N/A') . ', ' . htmlspecialchars($emergencyContact['e_barangay'] ?? 'N/A') . ', ' . htmlspecialchars($emergencyContact['e_city'] ?? 'N/A') . ', ' . htmlspecialchars($emergencyContact['e_province'] ?? 'N/A'); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </div>
                                <?php endif; ?>

                            </div>
                                
                        </div>
                    </div>
                </div>

                <!-- Government IDs -->
                <?php if ($governmentIds): ?>
                    <div class="card mt-4">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title"><i class="fas fa-id-badge"></i> Government IDs</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>GSIS Number</th>
                                        <td><?= htmlspecialchars($governmentIds['gsis_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>SSS Number</th>
                                        <td><?= htmlspecialchars($governmentIds['sss_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>TIN Number</th>
                                        <td><?= htmlspecialchars($governmentIds['tin_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>PhilHealth Number</th>
                                        <td><?= htmlspecialchars($governmentIds['philhealth_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>PAG-IBIG Number</th>
                                        <td><?= htmlspecialchars($governmentIds['pagibig_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Eligibility</th>
                                        <td><?= htmlspecialchars($governmentIds['eligibility'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>PRC Number</th>
                                        <td><?= htmlspecialchars($governmentIds['prc_number'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>PRC Expiry Date</th>
                                        <td><?= htmlspecialchars($governmentIds['prc_expiry_date'] ?? 'N/A'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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