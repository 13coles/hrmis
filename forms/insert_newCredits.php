<?php
require_once '../config/conn.php';
require '../util/encrypt_helper.php';

session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch all form data
    $employee_id = (int) $_POST['employee_id'];
    $year = (int) $_POST['year'];
    $le_vac = isset($_POST['le_vac']) ? (float) $_POST['le_vac'] : null;
    $le_sck = isset($_POST['le_sck']) ? (float) $_POST['le_sck'] : null;
    $from_to = $_POST['from_to'];
    $lt_wp_vac = isset($_POST['lt_wp_vac']) ? (float) $_POST['lt_wp_vac'] : null;
    $lt_wp_sck = isset($_POST['lt_wp_sck']) ? (float) $_POST['lt_wp_sck'] : null;
    $lt_np_vac = isset($_POST['lt_np_vac']) ? (float) $_POST['lt_np_vac'] : null;
    $lt_np_sck = isset($_POST['lt_np_sck']) ? (float) $_POST['lt_np_sck'] : null;
    $u_vac = isset($_POST['u_vac']) ? (float) $_POST['u_vac'] : null;
    $u_sck = isset($_POST['u_sck']) ? (float) $_POST['u_sck'] : null;
    $b_vac = isset($_POST['b_vac']) ? (float) $_POST['b_vac'] : null;
    $b_sck = isset($_POST['b_sck']) ? (float) $_POST['b_sck'] : null;
    $p_initial = $_POST['p_initial'];
    $p_date = $_POST['p_date'];

    // Calculate the new balances for b_vac and b_sck
    $new_b_vac = ($le_vac + $b_vac); 
    $new_b_sck = ($le_sck + $b_sck); 

    // Insert new record
    $query = "INSERT INTO pelc (employee_id, year, le_vac, le_sck, from_to, lt_wp_vac, lt_wp_sck, lt_np_vac, lt_np_sck, u_vac, u_sck, b_vac, b_sck, p_initial, p_date) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        // Set session error message if prepare fails
        $_SESSION['error'] = "Prepare failed: " . $conn->error;
        $token = encrypt_id($employee_id);
        header("Location: ../leaveCard.php?token=$token"); 
        exit();
    }

    // Bind parameters
    $stmt->bind_param(
        "iisdssdssdssdss", 
        $employee_id, 
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

    // Execute and handle errors
    if ($stmt->execute()) {
        // Set session success message
        $_SESSION['success'] = "New record added successfully.";
        $token = encrypt_id($employee_id);
        header("Location: ../leaveCard.php?token=$token"); 
        exit();
    } else {
        // Set session error message if execution fails
        $_SESSION['error'] = "Error: " . $stmt->error;
        $token = encrypt_id($employee_id);
        header("Location: ../leaveCard.php?token=$token"); 
        exit();
    }

    $stmt->close();
}
?>
