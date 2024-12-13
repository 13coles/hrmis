<?php
session_start();

require_once '../config/conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_no = trim($_POST['employee_no']);
    $office = trim($_POST['office']);
    $lastname = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $position = trim($_POST['position']);
    $salary = trim($_POST['salary']);
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
    $certificationofLeave = $_POST['certificationofLeave'];#new
    $sickTotal = floatval(trim($_POST['sickTotal']));#
    $vacationTotal = floatval(trim($_POST['vacationTotal']));#
    $vacationLess = floatval(trim($_POST['vacationLess']));
    $sickLess = floatval(trim($_POST['sickLess']));
    $vacationBalance = floatval(trim($_POST['vacationBalance']));#
    $sickBalance = floatval(trim($_POST['sickBalance']));#
    $recommendation = trim($_POST['recommendation']);
    $forDisapproval = trim($_POST['forDisapproval']);
    $approved = trim($_POST['approved']);
    $disapproved = trim($_POST['disapproved']);

    $stmt = $conn->prepare("INSERT INTO appleave
        (employee_no, office, lastname, firstname, middlename, position, salary, dateofFilling, typeofLeave, others, vacationleave, sickleave, specialleave, studyleave, otherpurpose, numberofWork, inclusiveDate_from, inclusiveDate_to, commutation, certificationofLeave, sickTotal, vacationTotal, vacationLess, sickLess, vacationBalance, sickBalance, recommendation, forDisapproval, approved, disapproved)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssssssssssssssssssssssss",
        $employee_no,
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
        // Prepare the first query to update lt_wp_vac and lt_wp_sck
        $update_lt_wp_query = $conn->prepare("UPDATE pelc 
            SET lt_wp_vac = lt_wp_vac + ?, lt_wp_sck = lt_wp_sck + ? 
            WHERE employee_no = ?");
        $update_lt_wp_query->bind_param("dds", $vacationLess, $sickLess, $employee_no);

        if ($update_lt_wp_query->execute()) {
            // Prepare the second query to update b_vac and b_sck based on lt_wp_vac and lt_wp_sck
            $balance_query = $conn->prepare("UPDATE pelc 
                SET b_vac = b_vac - ?, b_sck = b_sck - ? 
                WHERE employee_no = ?");
            $balance_query->bind_param("dds", $vacationLess, $sickLess, $employee_no);

            // Execute the query to update b_vac and b_sck
            if ($balance_query->execute()) {
                $_SESSION['success'] = "Leave application submitted successfully!";
            } else {
                $_SESSION['error'] = "Error updating leave balance: " . $balance_query->error;
            }
            $balance_query->close();
        } else {
            $_SESSION['error'] = "Error updating leave balances: " . $update_lt_wp_query->error;
        }
        $update_lt_wp_query->close();
    } else {
        $_SESSION['error'] = "Error inserting leave application: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request method.";
}

$conn->close();
header("Location: ../appLeave.php");
exit;
?>
