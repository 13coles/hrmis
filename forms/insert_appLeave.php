<?php
session_start();
require_once '../config/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $employee_id = ($_POST['employee_id']);
    $dateofFilling = trim($_POST['dateofFilling']);
    $typeofLeave = trim($_POST['typeofLeave']);
    $others = trim($_POST['others']);
    $vacationleave = trim($_POST['vacationleave']);
    $sickleave = trim($_POST['sickleave']);
    $specialleave = trim($_POST['specialleave']);
    $studyleave = $_POST['studyleave'] ?? null;
    $otherpurpose = $_POST['otherpurpose'] ?? null;
    $numberofWork = trim($_POST['numberofWork']);
    $inclusiveDate_from = trim($_POST['inclusiveDate_from']);
    $inclusiveDate_to = trim($_POST['inclusiveDate_to']);
    $commutation = $_POST['commutation'] ?? null;
    $certificationofLeave = $_POST['certificationofLeave'];
    $sickTotal = floatval(trim($_POST['sickTotal']));
    $vacationTotal = floatval(trim($_POST['vacationTotal']));
    $vacationLess = floatval(trim($_POST['vacationLess']));
    $sickLess = floatval(trim($_POST['sickLess']));
    $vacationBalance = floatval(trim($_POST['vacationBalance']));
    $sickBalance = floatval(trim($_POST['sickBalance']));
    $recommendation = trim($_POST['recommendation']);
    $forDisapproval = trim($_POST['forDisapproval']);
    $approved = trim($_POST['approved']);
    $disapproved = trim($_POST['disapproved']);

    // Insert new leave application into appleave
    $stmt = $conn->prepare("INSERT INTO appleave
        (employee_id, office, lastname, firstname, middlename, position, salary, dateofFilling, typeofLeave, others, vacationleave, sickleave, specialleave, studyleave, otherpurpose, numberofWork, inclusiveDate_from, inclusiveDate_to, commutation, certificationofLeave, sickTotal, vacationTotal, vacationLess, sickLess, vacationBalance, sickBalance, recommendation, forDisapproval, approved, disapproved)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "isssssssssssssssssssssssssssss",
        $employee_id,
        $office,
        $lastname,
        $firstname,
        $middlename,
        $position,
        $salary,
        $dateofFilling,
        $typeofLeave,
        $others,
        $vacationleave,
        $sickleave,
        $specialleave,
        $studyleave,
        $otherpurpose,
        $numberofWork,
        $inclusiveDate_from,
        $inclusiveDate_to,
        $commutation,
        $certificationofLeave,
        $sickTotal,
        $vacationTotal,
        $vacationLess,
        $sickLess,
        $vacationBalance,
        $sickBalance,
        $recommendation,
        $forDisapproval,
        $approved,
        $disapproved
    );

    if ($stmt->execute()) {
        // Format "from_to" as required
        $from_to = "LESS " . date("M d/Y", strtotime($inclusiveDate_from)) . " / " . date("M d/Y", strtotime($inclusiveDate_to));

        // Get the latest balance for the employee
        $latest_query = $conn->prepare("SELECT b_vac, b_sck FROM pelc WHERE employee_id = ? ORDER BY id DESC LIMIT 1");
        $latest_query->bind_param("i", $employee_id);
        $latest_query->execute();
        $latest_query->bind_result($prev_b_vac, $prev_b_sck);
        $latest_query->fetch();
        $latest_query->close();

        // Ensure previous values are set
        $prev_b_vac = $prev_b_vac ?? 0;
        $prev_b_sck = $prev_b_sck ?? 0;

        // Calculate new balance values
        $new_b_vac = $prev_b_vac - $vacationLess;
        $new_b_sck = $prev_b_sck - $sickLess;

        // Insert new row into pelc
        $insert_stmt = $conn->prepare("INSERT INTO pelc (employee_id, from_to, lt_wp_vac, lt_wp_sck, b_vac, b_sck) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("issddd", $employee_id, $from_to, $vacationLess, $sickLess, $new_b_vac, $new_b_sck);

        if ($insert_stmt->execute()) {
            $_SESSION['success'] = "Leave application submitted successfully!";
        } else {
            $_SESSION['error'] = "Error inserting leave record: " . $insert_stmt->error;
        }
        $insert_stmt->close();
    } else {
        $_SESSION['error'] = "Error inserting leave application: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
header("Location: ../appLeave.php");
exit;
?>
