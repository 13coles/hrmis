<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once './config/conn.php';
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
                            <a href="PDS.php" class="text-white">Back</a> / Other Information
                        </h3>
                    </div>
                    <div class="card-body">
                    <form action="PDS/insert_other.php" method="POST">
                        <div class="row">
                            <!-- Employee Details -->
                            <div class="col-md-12 mb-2">
                                <label>Employee No:</label>
                                <input type="text" name="employee_no" class="form-control" placeholder="Agency Employee Number" required>
                            </div>

                            <div class="col-md-12 mb-4" id="input-fields-container">
                                <div class="row">
                                    <!-- Career Service Fields -->
                                    <div class="col-md-4 mb-2">
                                        <label>31. Special Skills & Hobbies:</label>
                                        <input type="text" name="skills[]" class="form-control" placeholder="Enter Special Skills & Hobbies">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>32. Non-Academic Distinctions/Recognition:</label>
                                        <input type="text" name="non_academic[]" class="form-control" placeholder="Write in full">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label>33. Membership in Association/Organization:</label>
                                        <input type="text" name="membership[]" class="form-control" placeholder="Write in full">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or to the person who has immediate supervision over you in the Office, Bureau, or Department where you will be appointed, a. within the third degree?</label>
                                <input type="text" name="if_third" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>b. within the fourth degree (for Local Government Unit-Career Employee)?</label>
                                <input type="text" name="if_fourth" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>35. a. Have you been found guilty of any administrative offense?</label>
                                <input type="text" name="if_guilty" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>b. Have you been criminally charged before any court?</label>
                                <input type="text" name="if_criminal" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>36. Have you ever been convicted of any violation of any law, decree, ordinance or regulation by any court or tribunal?</label>
                                <input type="text" name="if_convicted" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</label>
                                <input type="text" name="if_separated" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>38. a. Have you been a candidate in a national or local election held within the last year (except Barangay election)?</label>
                                <input type="text" name="if_candidate" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</label>
                                <input type="text" name="if_resigned" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>39. Have you acquired the status of an immigrant or permanent resident of another country?</label>
                                <input type="text" name="if_immigrant" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <div class="col-md-12 mb-2">
                                <label>40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277) and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items: a. Are you a member of any indigenous group?</label>
                                <input type="text" name="if_indigenous" class="form-control" placeholder="(if yes, give the details.)">
                            </div>

                            <label>41. REFERENCES (Person not related by consanguinity or affinity to applicant/appointee)</label>
                            <div class="row">
                                <!-- Reference Fields -->
                                <div class="col-md-4 mb-2">
                                    <label>NAME:</label>
                                    <input type="text" name="ref_nameq" class="form-control" placeholder="Enter Name">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>ADDRESS:</label>
                                    <input type="text" name="ref_add1" class="form-control" placeholder="Write in full">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>TEL. NO.:</label>
                                    <input type="text" name="ref_tel1" class="form-control" placeholder="Provide number">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>NAME:</label>
                                    <input type="text" name="ref_name2" class="form-control" placeholder="Enter Name">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>ADDRESS:</label>
                                    <input type="text" name="ref_add2" class="form-control" placeholder="Write in full">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>TEL. NO.:</label>
                                    <input type="text" name="ref_tel2" class="form-control" placeholder="Provide number">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>NAME:</label>
                                    <input type="text" name="ref_name3" class="form-control" placeholder="Enter Name">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>ADDRESS:</label>
                                    <input type="text" name="ref_add3s" class="form-control" placeholder="Write in full">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>TEL. NO.:</label>
                                    <input type="text" name="ref_tel3" class="form-control" placeholder="Provide number">
                                </div>
                            </div>

                            <label>42. I declare under oath I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines...</label>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label>Government ID:</label>
                                    <input type="text" name="gov_id" class="form-control" placeholder="Government ID">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Passport or License ID:</label>
                                    <input type="text" name="passport_id" class="form-control" placeholder="License or Passport ID">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Date of Issuance:</label>
                                    <input type="date" name="insure_date" class="form-control">
                                </div>
                            </div>

                            <!-- Add/Remove Buttons -->
                            <div class="col-md-12 mb-2 text-right">
                                <button type="button" id="add-field" class="btn btn-success">Add Another</button>
                                <button type="button" id="remove-field" class="btn btn-danger" style="display:none;">Remove</button>
                            </div>

                            <!-- Submission Buttons -->
                            <div class="col-12 text-right mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="PDS.php" class="btn btn-secondary">Cancel</a>
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
<script>
    // Add and remove fields functionality
    const addButton = document.getElementById('add-field');
    const removeButton = document.getElementById('remove-field');
    const container = document.getElementById('input-fields-container');

    addButton.addEventListener('click', function() {
        // Clone the existing input fields and append them
        const newFields = container.children[0].cloneNode(true);
        container.appendChild(newFields);

        // Show remove button when there's more than one set of fields
        if (container.children.length > 1) {
            removeButton.style.display = 'inline-block';
        }
    });

    removeButton.addEventListener('click', function() {
        if (container.children.length > 1) {
            // Remove the last set of fields
            container.removeChild(container.lastElementChild);
        }

        // Hide remove button if only one set of fields remains
        if (container.children.length === 1) {
            removeButton.style.display = 'none';
        }
    });

    // Toggle visibility of text input based on radio button selection
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function () {
            let textInput = this.closest('div').querySelector('input[type="text"]');
            if (this.value === 'yes') {
                textInput.style.display = 'block';  
            } else {
                textInput.style.display = 'none';  
            }
        });
    });
</script>


</body>
</html>
