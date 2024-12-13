<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once './config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    $employee_id = intval($_POST['employee_id']);
    
    // Updated query with full_name and proper aliases
    $query = "
        SELECT 
            e.id AS employee_id, 
            CONCAT(e.last_name, ', ', e.first_name, ' ', IFNULL(e.middle_name, ''), ' ', IFNULL(e.extension_name, '')) AS full_name,
            e.position,
            e.department_name AS department,
            a.street, a.barangay, a.city, a.province,
            ec.person_name, ec.relationship, ec.tel_no,
            ec.e_street, ec.e_barangay, ec.e_city, ec.e_province,
            g.gsis_number, g.sss_number, g.philhealth_number, 
            g.pagibig_number, g.eligibility, g.prc_number, g.prc_expiry_date
        FROM employees e
        LEFT JOIN address a ON e.id = a.employee_id
        LEFT JOIN emergency_contacts ec ON e.id = ec.employee_id
        LEFT JOIN government_ids g ON e.id = g.employee_id
        WHERE e.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "No employee record found.";
        exit();
    }
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
                <h4 class="m-0"><i class="fas fa-id-card text-primary"></i> Permanent Employee Record</h4>
                <button class="btn btn-primary btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user"></i> Personl Data Sheet</h3>
                </div>
                <div class="card-body">

                    <!-- Personal Information -->
                    <h5 class="text-info"><i class="fas fa-user-circle"></i> Personal Information</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Employee Name</th>
                                <td><?php echo isset($employee['full_name']) ? $employee['full_name'] : ''; ?></td>
                                <th>Photo</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>CS ID NO.</th>
                                <td></td>
                                <th>Place of Birth</th>
                                <td><?php echo isset($employee['place_of_birth']) ? $employee['place_of_birth'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>Sex</th>
                                <td><?php echo isset($employee['sex']) ? $employee['sex'] : ''; ?></td>
                                <th>Civil Status</th>
                                <td><?php echo isset($employee['civil_status']) ? $employee['civil_status'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>Height</th>
                                <td><?php echo isset($employee['height']) ? $employee['height'] : ''; ?></td>
                                <th>Weight</th>
                                <td><?php echo isset($employee['weight']) ? $employee['weight'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>GSIS ID NO.</th>
                                <td><?php echo isset($employee['gsis_number']) ? $employee['gsis_number'] : ''; ?></td>
                                <th>PAG-IBIG ID NO.</th>
                                <td><?php echo isset($employee['pagibig_number']) ? $employee['pagibig_number'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>PHILHEALTH ID NO.</th>
                                <td><?php echo isset($employee['philhealth_number']) ? $employee['philhealth_number'] : ''; ?></td>
                                <th>SSS ID NO.</th>
                                <td><?php echo isset($employee['sss_number']) ? $employee['sss_number'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>TIN ID NO.</th>
                                <td><?php echo isset($employee['tin_number']) ? $employee['tin_number'] : ''; ?></td>
                                <th>AGENCY EMPLOYEE NO.</th>
                                <td><?php echo isset($employee['agency_employee_number']) ? $employee['agency_employee_number'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>Citizenship</th>
                                <td><?php echo isset($employee['citizenship']) ? $employee['citizenship'] : ''; ?></td>
                                <th>Residential Address</th>
                                <td><?php echo isset($employee['street']) ? $employee['street'] . ', ' . $employee['barangay'] . ', ' . $employee['city'] . ', ' . $employee['province'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>Permanent Address</th>
                                <td><?php echo isset($employee['e_street']) ? $employee['e_street'] . ', ' . $employee['e_barangay'] . ', ' . $employee['e_city'] . ', ' . $employee['e_province'] : ''; ?></td>
                                <th>Telephone No.</th>
                                <td><?php echo isset($employee['tel_no']) ? $employee['tel_no'] : ''; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile No.</th>
                                <td><?php echo isset($employee['mobile_no']) ? $employee['mobile_no'] : ''; ?></td>
                                <th>Email Address</th>
                                <td><?php echo isset($employee['email_address']) ? $employee['email_address'] : ''; ?></td>
                            </tr>
                        </tbody>
                    </table>



                    <!-- Family Background -->
                    <h5 class="text-info mt-4"><i class="fas fa-users"></i>  Family Background</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Spouse's Fullname</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Occupation</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Employer/Business Name</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Business Address</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Telephone No.</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Father's Fullname</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Mother's Fullname</th>
                                <td></td>
                            </tr>
                        
                        </tbody>
                    </table>

                    <h5 class="text-info mt-4">Childrens Name</h5>
                    <table class="table table-bordered table-striped">
                         <thead>
                            <tr>
                                <th>Child's Name</th>
                                <th>Date of Birth (mm/dd/yyyy)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>01/15/2010</td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>06/25/2012</td>
                            </tr>
                            <!-- Add more rows as needed for each child -->
                        </tbody>
                    </table>

                    <!-- Educational Background -->
                    <h5 class="text-info mt-4"><i class="fas fa-graduation-cap"></i> Educational Background</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Name of School</th>
                                <th>Basic Education/Degree/Course</th>
                                <th>Period of Attendance</th>
                                <th>Highest Level/Units Earned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Elementary</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Secondary</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Vocational/Trade Course</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>College</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Graduate Studies</th>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>PRC Expiry Date</th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <!--Civil Service Eligibilty -->
                    <h5 class="text-info mt-4"><i class="fas fa-certificate"></i> Civil Service Eligibilty</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Career Service/RA 1080(BOARD/BAR)Under Special Laws/CES/CSEE/Barangay Eligibility/Drivers License</th>
                                <th>Rating (if applicable)</th>
                                <th>Date of Examination/Conferment</th>
                                <th>Date of Examination/Conferment</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>

                   <!-- Work Experience -->
                    <h5 class="text-info mt-4"><i class="fas fa-briefcase"></i> Work Experience</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Inclusive Dates (mm/dd/yyyy)</th>
                                <th>Position Title (Write in full)</th>
                                <th>Department/Agency/Office/Company (Write in full)</th>
                                <th>Salary/Job/Pay Grade (if applicable) & Step (Format *00-0*y Increment)</th>
                                <th>Status of Appointment</th>
                                <th>Govt Service (Y/N)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- Inclusive Dates From and To -->
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>From</th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>To</th>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                                <!-- Other columns for Work Experience -->
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <!--. Voluntary Work Or Involvement In Civic/People/Voluntary Organization/s -->
                    <h5 class="text-info mt-4"><i class="fas fa-handshake"></i> Voluntary Work Or Involvement In Civic/People/Voluntary Organization/s</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> Name & Address of Organization (Write in full)</th>
                                <th>Inclusive Dates (mm/dd/yyyy)</th>
                                <th>Number of Hours</th>
                                <th>Position/Nature of Work</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>

                    <!--Learning And Development (L&D) Interventions/Training Programs Attended --> 
                    <h5 class="text-info mt-4"><i class="fas fa-chalkboard-teacher"></i> Learning And Development (L&D) Interventions/Training Programs Attended</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title Of Learning and Development Interventions/Training Programs (Write in full)</th>
                                <th>Inclusive Dates (mm/dd/yyyy)</th>
                                <th>Number of Hours</th>
                                <th>Type of I.D (Managerial/Supervisory/ Technical/etc)</th>
                                <th>Conducted Sponsored By (Write in full)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    </table>


                     <!--Other Information-->
                     <h5 class="text-info mt-4"><i class="fas fa-info-circle"></i> Other Information</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> Special Skills and Hobbies</th>
                                <th>Non-Academic Distinctions/Recognition (Write in full)</th>
                                <th>Membership in Association/Organization (Write in full)</th>
                              
                              
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                               
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> Are you related by consaguinity or affinity to the appointing on recommending authority, or to the chief of bureau or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>a. within the third degree?</th>
                                <td></td>
                               
                            </tr>
                            <tr>
                                <th>b. within the fourth degree (for Local Government Unit-Career Employee)?</th>
                                <td></td>
                              
                            </tr>
                            
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">

                        <tbody>
                            <tr>
                                <th>Have you ever found guilty of any administrative offense?</th>
                                <td></td>
                               
                            </tr>
                            <tr>
                                <th>Have you been criminally charged before any court?</th>
                                <td></td>
                              
                            </tr>
                            <tr>
                                <th>Have you ever been convicted of any violation of any law,
                                decree ordinance or regulation by any court or tribunal?</th>
                                <td></td>
                               
                            </tr>
                            <tr>
                              <th>Have you ever been separated from the service in any of the following modes resignation,
                                retirement, dropped from the rolls, dissimal, termination, end of term,
                                finished contract or phased out (abolition) in the public or private sector?</th>
                              <td></td>
                             
                          </tr>
                          <tr>
                              <th>Have you been a candidate in a national or local election held within the last year (except Barangay election)?</th>
                              <td></td>
                             
                            </tr>
                            <tr>
                              <th> Have you resigned from the government service during the three(3)-month
                              period before the last election to promote/actively campaign for a national or local candidte?</th>
                              <td></td>
                             
                            </tr>
                            <tr>
                                <th>Have you acquired the status of an immigrant or permanent resident of another country?</th>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>  Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277) and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th> Are you a member of any indigenous group?</th>
                                <td></td>
                               
                            </tr>
                            <tr>
                                <th>Are you a person with dissability?</th>
                                <td></td>
                              
                            </tr>
                            <tr>
                                <th>Are you a solo parent?</th>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>
                    
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th> REFERENCES(Person not related by consaguinity or affinity to applicant/appointee)</th>
                               
                            </tr>
                            <tr>
                                <th>NAME</th>
                                <th>ADDRESS</th>
                                <th>TEL. NO.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                        </tbody>
                    </table>
                
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>
                                    I declare under oath I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated herein. I agree that any misrepresentation made in this document and its attachments shall cause the filling of administrative/criminal case/s against me.
                                </th>
                            </tr>
                            <tr>
                                <th>Government Issued ID (i.e Passport GSIS, SSS, PRC, Drivers License, etc.) PLEASE INDICATE ID Number and Date of Issuance</th>
                            </tr>
                            <tr>
                                <th>Goverment Issued ID:</th>
                                <th>D/License/Passport No.:</th>
                                <th>Date/Place of Inssurance:</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button class="btn btn-secondary btn-sm" onclick="window.history.back()"><i class="fas fa-arrow-left"></i> Go Back</button>
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