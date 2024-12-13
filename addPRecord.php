<?php
session_start();
require_once './config/conn.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permanent</title>
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

        <section class="content">
            <div class="container-fluid">
               <div class="row">
                    <div class="col-lg-12">
                        <form action="forms/insert_employee.php" method="post">
                        <input type="hidden" name="employee_type" value="Permanent">
                        <div class="card-header">
                                    <h4>Add Record for Permanent Employee</h4>
                                </div>
                            <div class="card shadow mb-4 p-5">
                                <fieldset class="col-12">
                                        <legend class="text-primary">Employee ID</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Employee Number:</label>
                                                <input type="text" name="employee_no" class="form-control" placeholder="Enter Employee Number" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Date Hired:</label>
                                                <input type="date" name="date_hired" class="form-control" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Status:</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="" disabled selected>Select employment status</option>
                                                    <option value="Coterminous">Coterminous</option>
                                                    <option value="Permanent">Permanent</option>
                                                    <option value="Elected">Elected</option>
                                                    <option value="Temporary"></option>
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
                                                <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">First Name:</label>
                                                <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Middle Name:</label>
                                                <input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Extension Name:</label>
                                                <input type="text" name="extension_name" class="form-control" placeholder="Enter Extension Name">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Sex:</label>
                                                <select name="sex" class="form-control" required>
                                                    <option value="" disabled selected>Select your Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Civil Status:</label>
                                                <select name="civil_status" class="form-control" required>
                                                <option value="" disabled selected>Select your Civil Status</option>
                                                    <option value="single">Single</option>
                                                    <option value="married">Married</option>
                                                    <option value="widowed">Widowed</option>
                                                    <option value="separated">Separated</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Birth Date:</label>
                                                <input type="date" name="birth_date" class="form-control" required>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Birth Place:</label>
                                                <input type="text" name="birth_place" class="form-control" placeholder="Enter Birth Place" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Contact Number:</label>
                                                <input type="number" name="contact_number" class="form-control" placeholder="Enter Contact Number" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Height (cm):</label>
                                                <input type="number" name="height" class="form-control" placeholder="Enter Height" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Weight (kg):</label>
                                                <input type="number" name="weight" class="form-control" placeholder="Enter Weight" required>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Educational Attainment:</label>
                                                <select name="educational_attainment" class="form-control">
                                                    <option value="" disabled selected>Select Educational Attainment</option>
                                                    <option value="college_graduate">College Graduate</option>
                                                    <option value="vocational">Vocational</option>
                                                    <option value="highschool_graduate">Highschool Graduate</option>
                                                    <option value="masteral_graduate">Masteral Graduate</option>
                                                    <option value="vocational_trade_course">Vocational Trade Course</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label for="form-label text-secondary">Course</label>
                                                <input type="text" name="course" class="form-control" placeholder="Enter course">
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary" for="blood_type">Blood Type:</label>
                                                <select name="blood_type" class="form-control" required>
                                                    <option value="" disabled selected>Select your blood type</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                </select>
                                            </div>

                                            
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Nationality:</label>
                                                <input type="text" name="nationality" class="form-control" placeholder="Enter Nationality" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Spouse Name:</label>
                                                <input type="text" name="spouse_name" class="form-control" placeholder="Enter Spouse Name">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Spouse Occupation:</label>
                                                <input type="text" name="spouse_occupation" class="form-control" placeholder="Enter Spouse Occupation">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Address -->
                                    <fieldset class="col-12">
                                        <legend class="text-primary">Address</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Street:</label>
                                                <input type="text" name="street" class="form-control" placeholder="Enter Street" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Barangay:</label>
                                                <input type="text" name="barangay" class="form-control" placeholder="Enter Barangay" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">City:</label>
                                                <input type="text" name="city" class="form-control" placeholder="Enter City" required>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-label text-secondary">Province:</label>
                                                <input type="text" name="province" class="form-control" placeholder="Enter Province" required>
                                            </div>
                                        </div>
                                    </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">Emergency Contact Information</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Person Name:</label>
                                            <input type="text" name="person_name" class="form-control" placeholder="Enter Person Name">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Relationship:</label>
                                            <input type="text" name="relationship" class="form-control" placeholder="Enter Relationship">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Tel No.:</label>
                                            <input type="number" name="tel_no" class="form-control" placeholder="Enter Telephone Number">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Street:</label>
                                            <input type="text" name="e_street" class="form-control" placeholder="Enter Street">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Barangay:</label>
                                            <input type="text" name="e_barangay" class="form-control" placeholder="Enter Barangay">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">City:</label>
                                            <input type="text" name="e_city" class="form-control" placeholder="Enter City">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Province:</label>
                                            <input type="text" name="e_province" class="form-control" placeholder="Enter Province">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">City Departments</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Department:</label>
                                            <select name="department_name" class="form-control" required>
                                                <option value="" disabled selected>Select Department</option>
                                                <option value="AEMSMDH">AEMSMDH</option>
                                                <option value="City Accounting Office">City Accounting Office</option>
                                                <option value="City Agriculture Office">City Agriculture Office</option>
                                                <option value="City Assessor's Office">City Assessor's Office</option>
                                                <option value="City Budget Office">City Budget Office</option>
                                                <option value="City Civil Registry Office">City Civil Registry Office</option>
                                                <option value="City Economics and Enterprises Office">City Economics and Enterprises Office</option>
                                                <option value="City Engineering Office">City Engineering Office</option>
                                                <option value="City Environment & Natural Resources Office">City Environment & Natural Resources Office</option>
                                                <option value="City General Services Office">City General Services Office</option>
                                                <option value="City Health Office">City Health Office</option>
                                                <option value="City Legal Office">City Legal Office</option>
                                                <option value="City Mayor's Office">City Mayor's Office</option>
                                                <option value="City Planning & Development Office">City Planning & Development Office</option>
                                                <option value="City Social Welfare & Development Office">City Social Welfare & Development Office</option>
                                                <option value="City Treasury Office">City Treasury Office</option>
                                                <option value="City Veterinary Office">City Veterinary Office</option>
                                                <option value="City Vice Mayor & Sangguniang Panlungsod Office">City Vice Mayor & Sangguniang Panlungsod Office</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Position:</label>
                                            <input type="text" name="position" class="form-control" placeholder="Enter Position" required>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Salary Grade:</label>
                                            <input type="text" name="salary_grade" class="form-control" placeholder="Enter Salary Grade" required>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Step:</label>
                                            <input type="number" name="step" class="form-control" placeholder="Enter Step" required>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">Government ID</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">GSIS Number:</label>
                                            <input type="text" name="gsis_number" class="form-control" placeholder="Enter GSIS Number">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">SSS Number:</label>
                                            <input type="text" name="sss_number" class="form-control" placeholder="Enter SSS Number">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">PhilHealth Number:</label>
                                            <input type="text" name="philhealth_number" class="form-control" placeholder="Enter PhilHealth Number">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Pag-ibig Number:</label>
                                            <input type="text" name="pagibig_number" class="form-control" placeholder="Enter Pag-ibig Number">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="col-12">
                                    <legend class="text-primary">Government Eligibility</legend>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">Eligibility:</label>
                                            <input type="text" name="eligibility" class="form-control" placeholder="Enter Eligibility">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">PRC Number:</label>
                                            <input type="text" name="prc_number" class="form-control" placeholder="Enter PRC Number">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label text-secondary">PRC Expiry Date:</label>
                                            <input type="date" name="prc_expiry_date" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- Submit -->
                                <div class="col-12 mt-3">
                                    <div class="row float-right">
                                        <div class="col-12 text-end">
                                            <!-- Back Button -->
                                            <a href="javascript:history.back()" class="btn btn-link text-primary me-3">
                                                <i class="fas fa-arrow-left"></i> Back
                                            </a>
                                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                                            
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


</body>
</html>
