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
    $employee_id= decrypt_id($token);
    
    // Retrieve existing data for employee
    $query = "
            SELECT 
                e.id, e.employee_no, e.first_name, e.middle_name, e.last_name, 
                e.extension_name, e.position, e.department_name, e.salary_grade, e.step,
                e.date_hired, e.status, e.contact_number, e.height, e.weight, e.birth_date, 
                e.birth_place, e.educational_attainment, e.course, e.blood_type, e.nationality, 
                e.spouse_name, e.spouse_occupation, e.employee_type, 
                ec.person_name, ec.relationship, ec.tel_no, ec.e_street, ec.e_barangay, 
                ec.e_city, ec.e_province, g.gsis_number, g.sss_number, g.tin_number, 
                g.philhealth_number, g.pagibig_number, g.eligibility, g.prc_number, 
                g.prc_expiry_date, a.street, a.barangay, a.city, a.province
            FROM employees e
            LEFT JOIN emergency_contacts ec ON e.id = ec.employee_id
            LEFT JOIN government_ids g ON e.id = g.employee_id
            LEFT JOIN address a ON e.id = a.employee_id
            WHERE e.id = ?";


    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $employee = $result->fetch_assoc();
        } else {
            echo "No employee record found.";
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
    <title>Edit Record Permanent</title>
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


        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card-header">
                    <h4>Edit Record for Permanent Employee</h4>
                </div>

               <div class="row">
                    <div class="col-lg-12">
                        <form action="forms/updateemployee.php" method="post">
                        <input type="hidden" name="employee_type" value="<?= htmlspecialchars($employee['employee_type']) ?>">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($employee['id']) ?>">
                            <div class="card shadow mb-4 p-5"> 
                                <fieldset class="col-12">
                                        <legend class="text-primary">Employee ID</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Employee Number:</label>
                                                <input type="text" name="employee_no" class="form-control" placeholder="Enter Employee Number" value="<?= htmlspecialchars($employee['employee_no']) ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Date Hired:</label>
                                                <input type="date" name="date_hired" class="form-control" value="<?= htmlspecialchars($employee['date_hired']) ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Status:</label>
                                                <select name="status" class="form-control" >
                                                    <option value="Coterminous" <?= $employee['status'] == "Coterminous" ? "selected" : "" ?>>Coterminous</option>
                                                    <option value="Permanent" <?= $employee['status'] == "Permanent" ? "selected" : "" ?>>Permanent</option>
                                                    <option value="Elected" <?= $employee['status'] == "Elected" ? "selected" : "" ?>>Elected</option>
                                                    <option value="Temporary" <?= $employee['status'] == "Temporary" ? "selected" : "" ?>>Temporary</option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Personal Information -->
                                    <fieldset class="col-12">
                                        <legend class="text-primary">Personal Information</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Last Name:</label>
                                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" value="<?= htmlspecialchars($employee['last_name']) ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">First Name:</label>
                                                <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" value="<?= htmlspecialchars($employee['first_name']) ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Middle Name:</label>
                                                <input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name" value="<?= htmlspecialchars($employee['middle_name']) ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Extension Name:</label>
                                                <input type="text" name="extension_name" class="form-control" placeholder="Enter Extension Name" value="<?= htmlspecialchars($employee['extension_name']) ?>">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Sex:</label>
                                                <select name="sex" class="form-control" >
                                                    <option value="male" <?= isset($employee['sex']) && $employee['sex'] == "male" ? "selected" : "" ?>>Male</option>
                                                    <option value="female" <?= isset($employee['sex']) && $employee['sex'] == "female" ? "selected" : "" ?>>Female</option>
                                                </select>

                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Civil Status:</label>
                                                <select name="civil_status" class="form-control" >
                                                    <option value="" disabled>Select your Civil Status</option>
                                                    <option value="single" <?= ($employee['civil_status'] ?? '') === 'single' ? 'selected' : '' ?>>Single</option>
                                                    <option value="married" <?= ($employee['civil_status'] ?? '') === 'married' ? 'selected' : '' ?>>Married</option>
                                                    <option value="widowed" <?= ($employee['civil_status'] ?? '') === 'widowed' ? 'selected' : '' ?>>Widowed</option>
                                                    <option value="separated" <?= ($employee['civil_status'] ?? '') === 'separated' ? 'selected' : '' ?>>Separated</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Birth Date:</label>
                                                <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($employee['birth_date'] ?? '') ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Birth Place:</label>
                                                <input type="text" name="birth_place" class="form-control" placeholder="Enter Birth Place" value="<?= htmlspecialchars($employee['birth_place'] ?? '') ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Contact Number:</label>
                                                <input type="number" name="contact_number" class="form-control" placeholder="Enter Contact Number" value="<?= htmlspecialchars($employee['contact_number'] ?? '') ?>" >
                                            </div>
                                            <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Height (cm):</label>
                                            <input 
                                                type="number" 
                                                name="height" 
                                                class="form-control" 
                                                placeholder="Enter Height" 
                                                value="<?= htmlspecialchars($employee['height'] ?? '') ?>" 
                                                >
                                            </div>

                                            <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Weight (kg):</label>
                                            <input 
                                                type="number" 
                                                name="weight" 
                                                class="form-control" 
                                                placeholder="Enter Weight" 
                                                value="<?= htmlspecialchars($employee['weight'] ?? '') ?>" 
                                                >
                                            </div>

                                            <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Educational Attainment:</label>
                                            <select name="educational_attainment" class="form-control">
                                                <option value="" disabled>Select Educational Attainment</option>
                                                <option value="college_graduate" <?= isset($employee['educational_attainment']) && $employee['educational_attainment'] === 'college_graduate' ? 'selected' : '' ?>>College Graduate</option>
                                                <option value="vocational" <?= isset($employee['educational_attainment']) && $employee['educational_attainment'] === 'vocational' ? 'selected' : '' ?>>Vocational</option>
                                                <option value="highschool_graduate" <?= isset($employee['educational_attainment']) && $employee['educational_attainment'] === 'highschool_graduate' ? 'selected' : '' ?>>Highschool Graduate</option>
                                                <option value="masteral_graduate" <?= isset($employee['educational_attainment']) && $employee['educational_attainment'] === 'masteral_graduate' ? 'selected' : '' ?>>Masteral Graduate</option>
                                                <option value="vocational_trade_course" <?= isset($employee['educational_attainment']) && $employee['educational_attainment'] === 'vocational_trade_course' ? 'selected' : '' ?>>Vocational Trade Course</option>
                                            </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Course:</label>
                                            <input 
                                                type="text" 
                                                name="course" 
                                                class="form-control" 
                                                placeholder="Enter course" 
                                                value="<?= htmlspecialchars($employee['course'] ?? '') ?>">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary" for="blood_type">Blood Type:</label>
                                            <select name="blood_type" class="form-control" >
                                                <option value="" disabled>Select your blood type</option>
                                                <option value="A+" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'A+' ? 'selected' : '' ?>>A+</option>
                                                <option value="A-" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'A-' ? 'selected' : '' ?>>A-</option>
                                                <option value="B+" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'B+' ? 'selected' : '' ?>>B+</option>
                                                <option value="B-" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'B-' ? 'selected' : '' ?>>B-</option>
                                                <option value="O+" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'O+' ? 'selected' : '' ?>>O+</option>
                                                <option value="O-" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'O-' ? 'selected' : '' ?>>O-</option>
                                                <option value="AB+" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'AB+' ? 'selected' : '' ?>>AB+</option>
                                                <option value="AB-" <?= isset($employee['blood_type']) && $employee['blood_type'] === 'AB-' ? 'selected' : '' ?>>AB-</option>
                                            </select>
                                            </div>

                                            
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Nationality:</label>
                                                <input type="text" name="nationality" class="form-control" placeholder="Enter Nationality"  value="<?= htmlspecialchars($employee['nationality'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Spouse Name:</label>
                                                <input type="text" name="spouse_name" class="form-control" placeholder="Enter Spouse Name"  value="<?= htmlspecialchars($employee['spouse_name'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Spouse Occupation:</label>
                                                <input type="text" name="spouse_occupation" class="form-control" placeholder="Enter Spouse Occupation"  value="<?= htmlspecialchars($employee['spouse_occupation'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Address -->
                                    <fieldset class="col-12">
                                        <legend class="text-primary">Address</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Street:</label>
                                                <input type="text" name="street" class="form-control" placeholder="Enter Street"   value="<?= htmlspecialchars($employee['street'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Barangay:</label>
                                                <input type="text" name="barangay" class="form-control" placeholder="Enter Barangay"  value="<?= htmlspecialchars($employee['barangay'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">City:</label>
                                                <input type="text" name="city" class="form-control" placeholder="Enter City"   value="<?= htmlspecialchars($employee['city'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Province:</label>
                                                <input type="text" name="province" class="form-control" placeholder="Enter Province"  value="<?= htmlspecialchars($employee['province'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">Emergency Contact Information</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Person Name:</label>
                                            <input type="text" name="person_name" class="form-control" placeholder="Enter Person Name" value="<?= htmlspecialchars($employee['person_name'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Relationship:</label>
                                            <input type="text" name="relationship" class="form-control" placeholder="Enter Relationship" value="<?= htmlspecialchars($employee['relationship'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Tel No.:</label>
                                            <input type="number" name="tel_no" class="form-control" placeholder="Enter Telephone Number" value="<?= htmlspecialchars($employee['tel_no'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Street:</label>
                                            <input type="text" name="e_street" class="form-control" placeholder="Enter Street" value="<?= htmlspecialchars($employee['e_street'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Barangay:</label>
                                            <input type="text" name="e_barangay" class="form-control" placeholder="Enter Barangay" value="<?= htmlspecialchars($employee['e_barangay'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">City:</label>
                                            <input type="text" name="e_city" class="form-control" placeholder="Enter City" value="<?= htmlspecialchars($employee['e_city'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Province:</label>
                                            <input type="text" name="e_province" class="form-control" placeholder="Enter Province" value="<?= htmlspecialchars($employee['e_province'] ?? '') ?>">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">City Departments</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Department:</label>
                                            <select name="department_name" class="form-control" >
                                                <option value="" disabled>Select Department</option>
                                                <?php 
                                                // Array of department options
                                                $departments = [
                                                    "AEMSMDH", "City Accounting Office", "City Agriculture Office", 
                                                    "City Assessor's Office", "City Budget Office", "City Civil Registry Office",
                                                    "City Economics and Enterprises Office", "City Engineering Office",
                                                    "City Environment & Natural Resources Office", "City General Services Office",
                                                    "City Health Office", "City Legal Office", "City Mayor's Office",
                                                    "City Planning & Development Office", "City Social Welfare & Development Office",
                                                    "City Treasury Office", "City Veterinary Office", "City Vice Mayor & Sangguniang Panlungsod Office"
                                                ];

                                                // Loop through the department options and select the one that matches the current department name
                                                foreach ($departments as $department) {
                                                    $selected = ($department == $employee['department_name']) ? 'selected' : '';
                                                    echo "<option value=\"$department\" $selected>$department</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Position:</label>
                                            <input type="text" name="position" class="form-control" value="<?= htmlspecialchars($employee['position']); ?>" placeholder="Enter Position" >
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Salary Grade:</label>
                                            <input type="text" name="salary_grade" class="form-control" value="<?= htmlspecialchars($employee['salary_grade']); ?>" placeholder="Enter Salary Grade" >
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Step:</label>
                                            <input type="number" name="step" class="form-control" value="<?= htmlspecialchars($employee['step']); ?>" placeholder="Enter Step" >
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">Government ID</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">GSIS Number:</label>
                                            <input type="text" name="gsis_number" class="form-control" placeholder="Enter GSIS Number" value="<?= htmlspecialchars($employee['gsis_number']); ?>" >
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">SSS Number:</label>
                                            <input type="text" name="sss_number" class="form-control" placeholder="Enter SSS Number" value="<?= htmlspecialchars($employee['sss_number']); ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">PhilHealth Number:</label>
                                            <input type="text" name="philhealth_number" class="form-control" placeholder="Enter PhilHealth Number" value="<?= htmlspecialchars($employee['philhealth_number']); ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Pag-ibig Number:</label>
                                            <input type="text" name="pagibig_number" class="form-control" placeholder="Enter Pag-ibig Number" value="<?= htmlspecialchars($employee['pagibig_number']); ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">TIN Number:</label>
                                            <input type="text" name="tin_number" class="form-control" placeholder="Enter TIN Number" value="<?= htmlspecialchars($employee['tin_number']); ?>">
                                        </div>
                                        
                                    </div>
                                </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">Government Eligibility</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Eligibility:</label>
                                            <input type="text" name="eligibility" class="form-control" placeholder="Enter Eligibility" value="<?= htmlspecialchars($employee['eligibility']); ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">PRC Number:</label>
                                            <input type="text" name="prc_number" class="form-control" placeholder="Enter PRC Number" value="<?= htmlspecialchars($employee['prc_number']); ?>">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">PRC Expiry Date:</label>
                                            <input type="date" name="prc_expiry_date" class="form-control" value="<?= htmlspecialchars($employee['prc_expiry_date']); ?>">
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- Submit -->
                                <div class="col-12 mt-3">
                                    <div class="row float-right">
                                        <div class="col-12 text-end">
                                            
                                            <button type="submit" class="btn btn-primary me-2">Update</button>
                                            <?php $token = encrypt_id($employee['id']);?>
                                                <a href="viewRecord.php?token=<?php echo $token; ?>" class="btn btn-secondary">
                                                   Go Back
                                                </a>
                                            
                                        </div>
                                    </div>
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
