<?php
// newly added
session_start();
require_once './config/conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM pelc WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $card = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Credits</title>
    <!-- AdminLTE and CSS -->
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
                <div class="row">
                    <div class="col-lg-12 mt-2">
                        <form action="forms/update_leavecredits.php" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($card['id']) ?>">
                            <input type="hidden" name="employee_id" value="<?= htmlspecialchars($card['employee_id']) ?>">

                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h5>Edit Leave Card Credits</h5>
                                </div>
                                <div class="card-body p-5">
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Leaves Earned</legend>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Year:</label>
                                                <input type="number" name="year" class="form-control" value="<?= htmlspecialchars($card['year'] ?? '') ?>" placeholder="Enter Year">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Vacation:</label>
                                                <input type="number" step="0.01" name="le_vac" class="form-control" value="<?= htmlspecialchars($card['le_vac'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Sick:</label>
                                                <input type="number" step="0.01" name="le_sck" class="form-control" value="<?= htmlspecialchars($card['le_sck'] ?? '') ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Credits From - To:</label>
                                                <input type="text" name="from_to" class="form-control" value="<?= htmlspecialchars($card['from_to'] ?? '') ?>" placeholder="From-To">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!-- Leaves Taken -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Leaves Taken</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">With Pay Vacation:</label>
                                                <input type="number" step="0.01" name="lt_wp_vac" class="form-control"  value="<?= htmlspecialchars($card['lt_wp_vac'] ?? '') ?>" placeholder="Enter Leave with Pay Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">With Pay Sick:</label>
                                                <input type="number" step="0.01" name="lt_wp_sck" class="form-control" value="<?= htmlspecialchars($card['lt_wp_sck'] ?? '') ?>" placeholder="Enter Leave with Pay Sick">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Without Pay Vacation:</label>
                                                <input type="number" step="0.01" name="lt_np_vac" class="form-control" value="<?= htmlspecialchars($card['lt_np_vac'] ?? '') ?>" placeholder="Enter Leave without Pay Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Without Pay Sick:</label>
                                                <input type="number" step="0.01" name="lt_np_sck" class="form-control" value="<?= htmlspecialchars($card['lt_np_sck'] ?? '') ?>" placeholder="Enter Leave without Pay Sick">
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!-- Undertime -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Undertime</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Unpaid Vacation:</label>
                                                <input type="number" step="0.01" name="u_vac" class="form-control" value="<?= htmlspecialchars($card['u_vac'] ?? '') ?>" placeholder="Enter Unpaid Vacation">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Unpaid Sick:</label>
                                                <input type="number" step="0.01" name="u_sck" class="form-control" value="<?= htmlspecialchars($card['u_sck'] ?? '') ?>" placeholder="Enter Unpaid Sick">
                                            </div>
                                        </div>
                                    </fieldset>
                                     <!-- Balance -->
                                     <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Balance</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Vacation Balance:</label>
                                                <input type="number" step="0.01" name="b_vac" class="form-control" value="<?= htmlspecialchars($card['b_vac'] ?? '') ?>" placeholder="Enter Vacation Balance">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Sick Balance:</label>
                                                <input type="number" step="0.01" name="b_sck" class="form-control" value="<?= htmlspecialchars($card['b_sck'] ?? '') ?>" placeholder="Enter Sick Balance">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Processor -->
                                    <fieldset class="col-12 mb-4">
                                        <legend class="text-primary">Processor</legend>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Initial:</label>
                                                <input type="text" name="p_initial" class="form-control" value="<?= htmlspecialchars($card['p_initial'] ?? '') ?>" placeholder="Enter Initial">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Date:</label>
                                                <input type="date" name="p_date" class="form-control" value="<?= htmlspecialchars($card['p_date'] ?? '') ?>">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button class="btn btn-primary mr-2" type="submit" name="submit">Update</button>
                                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
