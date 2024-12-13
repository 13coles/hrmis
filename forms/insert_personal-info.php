<?php
session_start();
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $full_name = $_POST['full_name'] ?? null;
    $csid = $_POST['csid'] ?? null;
    $place_of_birth = $_POST['place_of_birth'] ?? null;
    $sex = $_POST['sex'] ?? null;
    $civil_status = $_POST['civil_status'] ?? null;
    $height = $_POST['height'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $gsis_number = $_POST['gsis_number'] ?? null;
    $pagibig_number = $_POST['pagibig_number'] ?? null;
    $philhealth_number = $_POST['philhealth_number'] ?? null;
    $sss_number = $_POST['sss_number'] ?? null;
    $tin_number = $_POST['tin_number'] ?? null;
    $agency_employee_number = $_POST['agency_employee_number'] ?? null;
    $citizenship = $_POST['citizenship'] ?? null;
    $residential_address = $_POST['residential_address'] ?? null;
    $permanent_address = $_POST['permanent_address'] ?? null;
    $tel_no = $_POST['tel_no'] ?? null;
    $mobile_no = $_POST['mobile_no'] ?? null;
    $email_address = $_POST['email_address'] ?? null;

    // Insert into personal_info table
    $query = "INSERT INTO personal_info (
        employee_id, full_name, csid, place_of_birth, sex, civil_status, height, weight, 
        gsis_number, pagibig_number, philhealth_number, sss_number, tin_number, agency_employee_number, 
        citizenship, residential_address, permanent_address, tel_no, mobile_no, email_address
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "issssssssssssssssss",
        $employee_id, $full_name, $csid, $place_of_birth, $sex, $civil_status, $height, $weight,
        $gsis_number, $pagibig_number, $philhealth_number, $sss_number, $tin_number, $agency_employee_number,
        $citizenship, $residential_address, $permanent_address, $tel_no, $mobile_no, $email_address
    );

    if ($stmt->execute()) {
        echo "Record successfully inserted!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>