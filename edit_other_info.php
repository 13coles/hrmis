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
    $other_info_id = decrypt_id($token);
    
    $query = "
            SELECT *
            FROM other_info
            WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $other_info_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $other_info = $result->fetch_assoc();
        } else {
            echo "No record Found.";
            header("Location: other.php");
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
    <title>Other Information</title>
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
                <div class="card mt-2">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">
                            Other Information
                        </h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/update_other.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($other_info['id']) ?>">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" value="<?= htmlspecialchars($other_info['employee_no']) ?>" readonly>
                            </div>

                            <div class="col-md-12 mb-4" id="input-fields-container">
                                <div class="row">
                                    <!-- Career Service Fields -->
                                    <div class="col-md-4 mb-2">
                                        <label>31. Special Skills & Hobbies:</label>
                                        <input type="text" name="skills[]" class="form-control" value="<?= htmlspecialchars($other_info['skills']) ?>" placeholder="Enter Special Skills & Hobbies">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>32. Non-Academic Distinctions/Recognition:</label>
                                        <input type="text" name="non_academic[]" class="form-control" value="<?= htmlspecialchars($other_info['non_academic']) ?>" placeholder="Write in full">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>33. Membership in Association/Organization:</label>
                                        <input type="text" name="membership[]" class="form-control" value="<?= htmlspecialchars($other_info['membership']) ?>" placeholder="Write in full">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or to the person who has immediate supervision over you in the Office, Bureau, or Department where you will be appointed, a. within the third degree?</label>
                                <input type="text" name="if_third" class="form-control" value="<?= htmlspecialchars($other_info['if_third']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>b. within the fourth degree (for Local Government Unit-Career Employee)?</label>
                                <input type="text" name="if_fourth" class="form-control" value="<?= htmlspecialchars($other_info['if_fourth']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>35. a. Have you been found guilty of any administrative offense?</label>
                                <input type="text" name="if_guilty" class="form-control" value="<?= htmlspecialchars($other_info['if_guilty']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>b. Have you been criminally charged before any court?</label>
                                <input type="text" name="if_criminal" class="form-control" value="<?= htmlspecialchars($other_info['if_criminal']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>36. Have you ever been convicted of any violation of any law, decree, ordinance or regulation by any court or tribunal?</label>
                                <input type="text" name="if_convicted" class="form-control" value="<?= htmlspecialchars($other_info['if_convicted']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</label>
                                <input type="text" name="if_separated" class="form-control" value="<?= htmlspecialchars($other_info['if_separated']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>38. a. Have you been a candidate in a national or local election held within the last year (except Barangay election)?</label>
                                <input type="text" name="if_candidate" class="form-control" value="<?= htmlspecialchars($other_info['if_candidate']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</label>
                                <input type="text" name="if_resigned" class="form-control" value="<?= htmlspecialchars($other_info['if_resigned']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>39. Have you acquired the status of an immigrant or permanent resident of another country?</label>
                                <input type="text" name="if_immigrant" class="form-control" value="<?= htmlspecialchars($other_info['if_immigrant']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277) and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items: a. Are you a member of any indigenous group?</label>
                                <input type="text" name="if_indigenous" class="form-control" value="<?= htmlspecialchars($other_info['if_indigenous']) ?>" placeholder="(if yes, give the details.)">
                            </div>

                            <label>41. REFERENCES (Person not related by consanguinity or affinity to applicant/appointee)</label>
                            <div class="row">
                                <!-- Reference Fields -->
                                <div class="col-md-4 mb-2">
                                    <label>NAME:</label>
                                    <input type="text" name="ref_nameq" class="form-control" value="<?= htmlspecialchars($other_info['ref_nameq']) ?>" placeholder="Enter Name">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>ADDRESS:</label>
                                    <input type="text" name="ref_add1" class="form-control" value="<?= htmlspecialchars($other_info['ref_add1']) ?>" placeholder="Write in full">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>TEL. NO.:</label>
                                    <input type="text" name="ref_tel1" class="form-control" value="<?= htmlspecialchars($other_info['ref_tel1']) ?>" placeholder="Provide number">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>NAME:</label>
                                    <input type="text" name="ref_name2" class="form-control" value="<?= htmlspecialchars($other_info['ref_name2']) ?>" placeholder="Enter Name">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>ADDRESS:</label>
                                    <input type="text" name="ref_add2" class="form-control" value="<?= htmlspecialchars($other_info['ref_add2']) ?>" placeholder="Write in full">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>TEL. NO.:</label>
                                    <input type="text" name="ref_tel2" class="form-control" value="<?= htmlspecialchars($other_info['ref_tel2']) ?>" placeholder="Provide number">
                                </div>
                            </div>
                            <label>42. I declare under oath I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines...</label>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label>Government ID:</label>
                                        <input type="text" name="gov_id" class="form-control" placeholder="Government ID" value="<?= htmlspecialchars($other_info['gov_id']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Passport or License ID:</label>
                                        <input type="text" name="passport_id" class="form-control" placeholder="License or Passport ID" value="<?= htmlspecialchars($other_info['passport_id']) ?>">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>Date of Issuance:</label>
                                        <input type="date" name="insure_date" class="form-control" value="<?= htmlspecialchars($other_info['insure_date']) ?>">
                                    </div>
                                </div>


                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>
<!-- AdminLTE JS -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
