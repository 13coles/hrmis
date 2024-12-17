<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php';
require '../util/encrypt_helper.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; 
    $employee_no = $_POST['employee_no'];
    $org = $_POST['org_name'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $hours = $_POST['hours'];
    $nature_work = $_POST['nature_of_work'];
    $query = "
        UPDATE voluntary_work
        SET employee_no = ?, org_name = ?, from_date = ?, to_date = ?, hours = ?, nature_of_work = ?
        WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        foreach ($org as $index => $organization) {
            $stmt->bind_param('ssssssi', 
                $employee_no, 
                $org[$index], 
                $from_date[$index], 
                $to_date[$index], 
                $hours[$index], 
                $nature_work[$index], 
                $id
            );

            if (!$stmt->execute()) {
                $_SESSION['error'] = "Error updating record: " . $stmt->error;
                header("Location: ../viewjo_pds.php");
                exit();
            }
        }
        $_SESSION['info'] = "Voluntary work updated successfully.";
        $stmt->close();
        $token = encrypt_id($employee_no);
        header("Location: ../viewjo_pds.php?token=$token");
        exit();

    } else {
        die("Error preparing statement: " . $conn->error);
    }
} else {
    echo "Invalid request method.";
}
?>
