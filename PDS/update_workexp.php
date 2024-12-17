<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/conn.php';
require '../util/encrypt_helper.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $employee_no = $_POST['employee_no'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $salary_grade = $_POST['salary_grade'];
    $status_appointment = $_POST['status_appointment'];
    $gov = $_POST['gov_service'];

    $query = "
        UPDATE work_experience
        SET employee_no = ?, from_date = ?, to_date = ?, position = ?, department = ?, salary = ?, salary_grade = ?, status_appointment = ?, gov_service = ?
        WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Loop through each set of values and update
        foreach ($from as $index => $value) {
            $stmt->bind_param('sssssssssi', $employee_no, $from[$index], $to[$index], $position[$index], $department[$index], $salary[$index], $salary_grade[$index], $status_appointment[$index], $gov[$index], $id);
            $stmt->execute();
        }
        $stmt->close();
        $_SESSION['info'] = "Work experience updated successfully!";
        $token = encrypt_id($employee_no);
        header("Location: ../viewjo_pds.php?token=$token");
        exit();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}
?>
