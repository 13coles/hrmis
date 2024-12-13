<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $employee_no = $_POST['employee_no'];
    $career = $_POST['career'];
    $rating = $_POST['rating'];
    $date_exam = $_POST['date_exam'];
    $place_exam = $_POST['place_exam'];
    $license_no = $_POST['license_no'];
    $sql = "INSERT INTO civil_service_eligibility (employee_no, career, rating, date_exam, place_exam, license_no)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    for ($i = 0; $i < count($career); $i++) {
        $stmt->bind_param("ssssss", $employee_no, $career[$i], $rating[$i], $date_exam[$i], $place_exam[$i], $license_no[$i]);

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit();
        }
    }


    $stmt->close();
    header("Location: ../PDS.php?success=1"); 
    exit();
}
?>
