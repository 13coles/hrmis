<?php
require_once '../config/conn.php';
require '../util/encrypt_helper.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch and sanitize all form data
    $employee_id = filter_input(INPUT_POST, 'employee_id', FILTER_VALIDATE_INT);
    $employee_no = trim($_POST['employee_no']);
    $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
    $le_vac = filter_input(INPUT_POST, 'le_vac', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $le_sck = filter_input(INPUT_POST, 'le_sck', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $from_to = trim($_POST['from_to']);
    $lt_wp_vac = filter_input(INPUT_POST, 'lt_wp_vac', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $lt_wp_sck = filter_input(INPUT_POST, 'lt_wp_sck', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $lt_np_vac = filter_input(INPUT_POST, 'lt_np_vac', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $lt_np_sck = filter_input(INPUT_POST, 'lt_np_sck', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $u_vac = filter_input(INPUT_POST, 'u_vac', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $u_sck = filter_input(INPUT_POST, 'u_sck', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $b_vac = filter_input(INPUT_POST, 'b_vac', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $b_sck = filter_input(INPUT_POST, 'b_sck', FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    $p_initial = trim($_POST['p_initial']);
    $p_date = trim($_POST['p_date']);


    // Calculate the new balances for b_vac and b_sck
    $new_b_vac = ($le_vac ?? 0) + ($b_vac ?? 0);
    $new_b_sck = ($le_sck ?? 0) + ($b_sck ?? 0);

    // Prepare SQL query
    $query = "INSERT INTO pelc 
              (employee_id, employee_no, year, le_vac, le_sck, from_to, lt_wp_vac, lt_wp_sck, lt_np_vac, lt_np_sck, u_vac, u_sck, b_vac, b_sck, p_initial, p_date) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['error'] = "Database error: " . $conn->error;
        $token = encrypt_id($employee_id);
        header("Location: ../leaveCard.php?token=$token");
        exit();
    }

    // Bind parameters
    $stmt->bind_param(
        "isisdssdssdssdss",
        $employee_id,
        $employee_no,
        $year,
        $le_vac,
        $le_sck,
        $from_to,
        $lt_wp_vac,
        $lt_wp_sck,
        $lt_np_vac,
        $lt_np_sck,
        $u_vac,
        $u_sck,
        $new_b_vac,
        $new_b_sck,
        $p_initial,
        $p_date
    );

    // Execute the query and handle success or errors
    if ($stmt->execute()) {
        $_SESSION['success'] = "New record added successfully.";
    } else {
        $_SESSION['error'] = "Database error: " . $stmt->error;
    }

    // Redirect user back with encrypted token
    $token = encrypt_id($employee_id);
    header("Location: ../leaveCard.php?token=$token");
    exit();
}
?>
