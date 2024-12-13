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
        $orgs = isset($_POST['org']) ? $_POST['org'] : [];
        $from_dates = isset($_POST['from_date']) ? $_POST['from_date'] : [];
        $to_dates = isset($_POST['to_date']) ? $_POST['to_date'] : [];
        $hours = isset($_POST['hours']) ? $_POST['hours'] : [];
        $nature_works = isset($_POST['nature_work']) ? $_POST['nature_work'] : [];

        if (empty($orgs) || empty($from_dates) || empty($to_dates) || empty($hours) || empty($nature_works)) {
            $error_msg = "All fields are required.";
        }

        if (empty($error_msg)) {
            for ($i = 0; $i < count($orgs); $i++) {
                $org = mysqli_real_escape_string($conn, $orgs[$i]);
                $from = mysqli_real_escape_string($conn, $from_dates[$i]);
                $to = mysqli_real_escape_string($conn, $to_dates[$i]);
                $hour = mysqli_real_escape_string($conn, $hours[$i]);
                $nature_work = mysqli_real_escape_string($conn, $nature_works[$i]);

                $query = "INSERT INTO voluntary_work (employee_no, org_name, from_date, to_date, hours, nature_of_work) 
                          VALUES ('$employee_no', '$org', '$from', '$to', '$hour', '$nature_work')";

             
                if (!mysqli_query($conn, $query)) {
                    $error_msg = "Error: " . mysqli_error($conn);
                    break; 
                }
            }
        }

      
        if (empty($error_msg)) {
            $_SESSION['success_msg'] = "Voluntary work details submitted successfully!";
            header("Location: ../PDS.php");
            exit();
        }
    }
}

$_SESSION['error_msg'] = $error_msg;
header("Location: ../PDS.php");
exit();
?>
