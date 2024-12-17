<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/conn.php';
require '../util/encrypt_helper.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $id = $_POST['id']; 
    $employee_no = $_POST['employee_no']; 

    // Career services details
    $career = $_POST['career'];
    $rating = $_POST['rating'];
    $date_exam = $_POST['date_exam'];
    $place_exam = $_POST['place_exam'];
    $license_no = $_POST['license_no'];

    $query = "
        UPDATE civil_service_eligibility 
        SET employee_no = ?, 
            career= ?, 
            rating = ?, 
            date_exam = ?, 
            place_exam = ?, 
            license_no = ?
        WHERE id = ?";

    if ($stmt = $conn->prepare($query)) {
        foreach ($career as $index => $service) {
            $career_value = $career[$index];
            $rating_value = $rating[$index];
            $date_exam_value = $date_exam[$index];
            $place_exam_value = $place_exam[$index];
            $license_no_value = $license_no[$index];
            $stmt->bind_param('ssssssi', $employee_no, $career_value, $rating_value, $date_exam_value, $place_exam_value, $license_no_value, $id);
            if (!$stmt->execute()) {
                echo "Error updating record: " . $stmt->error;
                exit();
            }
        }

        $_SESSION['info'] = "Civil Service Eligibility updated successfully.";

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
