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
    $personal_info_id = decrypt_id($token);
    
    $query = "
            SELECT *
            FROM personal_info
            WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $personal_info_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $personal_info = $result->fetch_assoc();
        } else {
            echo "No record Found.";
            header("Location: personal_info.php");
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
    <title>Personal Info</title>
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
            <?php include './util/session-message.php'; ?>

                <!-- Card with Nav List -->
                <div class="card mt-2">
                    <div class="card-header bg-primary">
                        <h3 class="card-title"> Edit Personal Information</h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/update_personal_info.php" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($personal_info['id']) ?>">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-6 mb-2">
                                <label>1. Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" value="<?= htmlspecialchars($personal_info['employee_no']) ?>"  readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label>2. CS ID No:</label>
                                <input type="text" name="csc" class="form-control" value="<?= htmlspecialchars($personal_info['csc']) ?>" placeholder="(Do not fill up. For CSC use only)">
                            </div>

                            <!-- Name Details -->
                            <div class="col-md-3 mb-2">
                                <label>3. Surname:</label>
                                <input type="text" name="sname" class="form-control" value="<?= htmlspecialchars($personal_info['sname']) ?>" placeholder="Surname">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>First Name:</label>
                                <input type="text" name="fname" class="form-control"  value="<?= htmlspecialchars($personal_info['fname']) ?>" placeholder="First Name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Middle Name:</label>
                                <input type="text" name="mname" class="form-control"  value="<?= htmlspecialchars($personal_info['mname']) ?>" placeholder="Middle Name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Name Extension:</label>
                                <select name="extension" class="form-control">
                                    <option value="" <?= empty($personal_info['extension']) ? 'selected' : '' ?>></option>
                                    <option value="Jr." <?= isset($personal_info['extension']) && $personal_info['extension'] == 'Jr.' ? 'selected' : '' ?>>Jr.</option>
                                    <option value="Sr." <?= isset($personal_info['extension']) && $personal_info['extension'] == 'Sr.' ? 'selected' : '' ?>>Sr.</option>
                                </select>

                            </div>

                            <!-- Birth Details -->
                            <div class="col-md-4 mb-2">
                                <label>4. Date of Birth:</label>
                                <input type="date" name="datebirth" class="form-control"  value="<?= htmlspecialchars($personal_info['datebirth']) ?>">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>5. Place of Birth:</label>
                                <input type="text" name="placebirth" class="form-control"  value="<?= htmlspecialchars($personal_info['placebirth']) ?>" placeholder="Place of Birth">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>6. Sex:</label>
                                <select name="sex" class="form-control">
                                    <option value="" disabled selected>Select Sex</option>
                                    <option value="Male" <?= isset($personal_info['sex']) && $personal_info['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= isset($personal_info['sex']) && $personal_info['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                </select>
                            </div>

                            <!-- Civil Status -->
                            <div class="col-md-4 mb-2">
                                <label>7. Civil Status:</label>
                                <select name="status" class="form-control">
                                    <option value="" disabled selected>Select Civil Status</option>
                                    <option value="Single" <?= isset($personal_info['status']) && $personal_info['status'] == 'Single' ? 'selected' : '' ?>>Single</option>
                                    <option value="Married" <?= isset($personal_info['status']) && $personal_info['status'] == 'Married' ? 'selected' : '' ?>>Married</option>
                                    <option value="Widowed" <?= isset($personal_info['status']) && $personal_info['status'] == 'Widowed' ? 'selected' : '' ?>>Widowed</option>
                                    <option value="Separated" <?= isset($personal_info['status']) && $personal_info['status'] == 'Separated' ? 'selected' : '' ?>>Separated</option>
                                    <option value="Other" <?= isset($personal_info['status']) && $personal_info['status'] == 'Other' ? 'selected' : '' ?>>Other/s</option>
                                </select>
                            </div>

                            <!-- Physical Details -->
                            <div class="col-md-4 mb-2">
                                <label>8. Height (cm):</label>
                                <input type="text" name="height" class="form-control" placeholder="Height (cm)" pattern="\d+(\.\d{1,2})?" title="Enter a valid height in centimeters (e.g., 175)" value="<?= htmlspecialchars($personal_info['height']) ?>">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>9. Weight (kg):</label>
                                <input type="text" name="weight" class="form-control" placeholder="Weight (kg)" pattern="\d+(\.\d{1,2})?" title="Enter a valid weight in kilograms (e.g., 70)" value="<?= htmlspecialchars($personal_info['weight']) ?>">
                            </div>

                            <!-- Identification Numbers -->
                            <div class="col-md-4 mb-2">
                                <label>10. Blood Type:</label>
                                <input type="text" name="bloodtype" class="form-control" value="<?= htmlspecialchars($personal_info['bloodtype']) ?>" placeholder="Blood Type">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>11. GSIS ID No:</label>
                                <input type="text" name="gsis_id" class="form-control" value="<?= htmlspecialchars($personal_info['gsis_id']) ?>" placeholder="GSIS ID No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>12. PAG-IBIG ID No:</label>
                                <input type="text" name="pagibig_id" class="form-control" value="<?= htmlspecialchars($personal_info['pagibig_id']) ?>"  placeholder="PAG-IBIG ID No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>13. PHILHEALTH No:</label>
                                <input type="text" name="philhealth_id" class="form-control" value="<?= htmlspecialchars($personal_info['philhealth_id']) ?>" placeholder="PHILHEALTH No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>14. SSS No:</label>
                                <input type="text" name="sss_id" class="form-control" value="<?= htmlspecialchars($personal_info['sss_id']) ?>"  placeholder="SSS No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>15. TIN No:</label>
                                <input type="text" name="tin_id" class="form-control" value="<?= htmlspecialchars($personal_info['tin_id']) ?>"  placeholder="TIN No">
                            </div>

                            <!-- Citizenship -->
                            <div class="col-md-4 mb-2">
                                <label>16. Citizenship:</label>
                                <select name="citizenship" class="form-control">
                                    <option value="" disabled selected>Select Citizenship</option>
                                    <option value="Filipino" <?= isset($personal_info['citizenship']) && $personal_info['citizenship'] == 'Filipino' ? 'selected' : '' ?>>Filipino</option>
                                    <option value="Dual Citizenship" <?= isset($personal_info['citizenship']) && $personal_info['citizenship'] == 'Dual Citizenship' ? 'selected' : '' ?>>Dual Citizenship</option>
                                    <option value="By Birth" <?= isset($personal_info['citizenship']) && $personal_info['citizenship'] == 'By Birth' ? 'selected' : '' ?>>By Birth</option>
                                    <option value="By Naturalization" <?= isset($personal_info['citizenship']) && $personal_info['citizenship'] == 'By Naturalization' ? 'selected' : '' ?>>By Naturalization</option>
                                </select>

                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Country:</label>
                                <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($personal_info['country']) ?>" placeholder="Please indicate country">
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-4 mb-2">
                                <label>17. Residential Address:</label>
                                <input type="text" name="resAdd" class="form-control" value="<?= htmlspecialchars($personal_info['resAdd']) ?>" placeholder="House/Block/Lot No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Street:</label>
                                <input type="text" name="street" class="form-control" value="<?= htmlspecialchars($personal_info['street']) ?>" placeholder="Street">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Subdivision:</label>
                                <input type="text" name="subdivision" class="form-control" value="<?= htmlspecialchars($personal_info['subdivision']) ?>" placeholder="Subdivision">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Barangay:</label>
                                <input type="text" name="barangay" class="form-control" value="<?= htmlspecialchars($personal_info['barangay']) ?>" placeholder="Barangay">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>City:</label>
                                <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($personal_info['city']) ?>" placeholder="City">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Province:</label>
                                <input type="text" name="province" class="form-control" value="<?= htmlspecialchars($personal_info['province']) ?>" placeholder="Province">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Zipcode:</label>
                                <input type="text" name="zipcode" class="form-control" value="<?= htmlspecialchars($personal_info['zipcode']) ?>" placeholder="Zipcode">
                            </div>

                            <!-- Address Details -->
                            <div class="col-md-4 mb-2">
                                <label>18. Permanent Address:</label>
                                <input type="text" name="permaAdd" class="form-control" value="<?= htmlspecialchars($personal_info['permaAdd']) ?>" placeholder="House/Block/Lot No">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Street:</label>
                                <input type="text" name="permaStreet" class="form-control" value="<?= htmlspecialchars($personal_info['permaStreet']) ?>" placeholder="Street">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Subdivision:</label>
                                <input type="text" name="permaSub" class="form-control" value="<?= htmlspecialchars($personal_info['permaSub']) ?>" placeholder="Subdivision">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Barangay:</label>
                                <input type="text" name="permaBarangay" class="form-control" value="<?= htmlspecialchars($personal_info['permaBarangay']) ?>" placeholder="Barangay">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>City:</label>
                                <input type="text" name="permaCity" class="form-control" value="<?= htmlspecialchars($personal_info['permaCity']) ?>" placeholder="City">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Province:</label>
                                <input type="text" name="permaProvince" class="form-control" value="<?= htmlspecialchars($personal_info['permaProvince']) ?>" placeholder="Province">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Zipcode:</label>
                                <input type="text" name="permaZip" class="form-control" value="<?= htmlspecialchars($personal_info['permaZip']) ?>" placeholder="Zipcode">
                            </div>

                            <!-- Contact Details -->
                            <div class="col-md-4 mb-2">
                                <label>19. Telephone No.:</label>
                                <input type="text" name="telno" class="form-control" value="<?= htmlspecialchars($personal_info['telno']) ?>" placeholder="Telephone No.">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>20. Mobile No.:</label>
                                <input type="text" name="mobileno" class="form-control" value="<?= htmlspecialchars($personal_info['mobileno']) ?>" placeholder="Mobile No.">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>21. Email Address:</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($personal_info['email']) ?>" placeholder="Email Address">
                            </div>
                        </div>

                        <!-- Submission Buttons -->
                        <div class="row mt-3 float-right">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                
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

