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
        $from_dates = $_POST['from'];
        $to_dates = $_POST['to'];
        $positions = $_POST['position'];
        $departments = $_POST['department'];
        $salaries = $_POST['salary'];
        $salary_grades = $_POST['salary_grade'];
        $status_appointments = $_POST['status_appointment'];
        $gov_services = $_POST['gov'];

        for ($i = 0; $i < count($from_dates); $i++) {
            $from = mysqli_real_escape_string($conn, $from_dates[$i]);
            $to = mysqli_real_escape_string($conn, $to_dates[$i]);
            $position = mysqli_real_escape_string($conn, $positions[$i]);
            $department = mysqli_real_escape_string($conn, $departments[$i]);
            $salary = mysqli_real_escape_string($conn, $salaries[$i]);
            $salary_grade = mysqli_real_escape_string($conn, $salary_grades[$i]);
            $status_appointment = mysqli_real_escape_string($conn, $status_appointments[$i]);
            $gov_service = mysqli_real_escape_string($conn, $gov_services[$i]);

     
            $query = "INSERT INTO work_experience (employee_no, from_date, to_date, position, department, salary, salary_grade, status_appointment, gov_service) 
                      VALUES ('$employee_no', '$from', '$to', '$position', '$department', '$salary', '$salary_grade', '$status_appointment', '$gov_service')";
            
            if (!mysqli_query($conn, $query)) {
                $error_msg = "Error: " . mysqli_error($conn);
                break;
            }
        }
        if (empty($error_msg)) {
            $_SESSION['success'] = "Work experience submitted successfully!";
            header("Location: ../PDS.php");
            exit();
        }
    }
}
$_SESSION['error_msg'] = $error_msg;
header("Location: ../PDS.php");
exit();
?>
