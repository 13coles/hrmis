<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php'; 

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_no = mysqli_real_escape_string($conn, $_POST['employee_no']);

    if (empty($employee_no)) {
        $error_msg = "Employee number is required.";
    }

    if (empty($error_msg)) {
        $titles = $_POST['title'];
        $attFrom_dates = $_POST['attFrom_date'];
        $attTo_dates = $_POST['attTo_date'];
        $hours = $_POST['hours'];
        $citizenships = $_POST['citizenship'];
        $conducteds = $_POST['conducted'];

        for ($i = 0; $i < count($titles); $i++) {
            $title = mysqli_real_escape_string($conn, $titles[$i]);
            $attFrom = mysqli_real_escape_string($conn, $attFrom_dates[$i]);
            $attTo = mysqli_real_escape_string($conn, $attTo_dates[$i]);
            $hour = mysqli_real_escape_string($conn, $hours[$i]);
            $citizenship = mysqli_real_escape_string($conn, $citizenships[$i]);
            $conducted = mysqli_real_escape_string($conn, $conducteds[$i]);

      
            $query = "INSERT INTO learning_development (employee_no, title, from_date, to_date, hours, citizenship_type, conducted_by) 
                      VALUES ('$employee_no', '$title', '$attFrom', '$attTo', '$hour', '$citizenship', '$conducted')";

     
            if (!mysqli_query($conn, $query)) {
                $error_msg = "Error: " . mysqli_error($conn);
                break; 
            }
        }


        if (empty($error_msg)) {
            $_SESSION['success_msg'] = "Learning and development details submitted successfully!";
            header("Location: ../PDS.php");
            exit();
        }
    }
}


$_SESSION['error_msg'] = $error_msg;
header("Location: ../PDS.php");
exit();
?>
