<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/conn.php';



function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_no = sanitizeInput($_POST['employee_no']);
    $csc = sanitizeInput($_POST['csc']);
    $sname = sanitizeInput($_POST['sname']);
    $fname = sanitizeInput($_POST['fname']);
    $mname = sanitizeInput($_POST['mname']);
    $extension = sanitizeInput($_POST['extension']);
    $datebirth = sanitizeInput($_POST['datebirth']);
    $placebirth = sanitizeInput($_POST['placebirth']);
    $sex = sanitizeInput($_POST['sex']);
    $status = sanitizeInput($_POST['status']);
    $height = sanitizeInput($_POST['height']);
    $weight = sanitizeInput($_POST['weight']);
    $bloodtype = sanitizeInput($_POST['bloodtype']);
    $gsis_id = sanitizeInput($_POST['gsis_id']);
    $pagibig_id = sanitizeInput($_POST['pagibig_id']);
    $philhealth_id = sanitizeInput($_POST['philhealth_id']);
    $sss_id = sanitizeInput($_POST['sss_id']);
    $tin_id = sanitizeInput($_POST['tin_id']);
    $citizenship = sanitizeInput($_POST['citizenship']);
    $country = sanitizeInput($_POST['country']);
    $resAdd = sanitizeInput($_POST['resAdd']);
    $street = sanitizeInput($_POST['street']);
    $subdivision = sanitizeInput($_POST['subdivision']);
    $barangay = sanitizeInput($_POST['barangay']);
    $city = sanitizeInput($_POST['city']);
    $province = sanitizeInput($_POST['province']);
    $zipcode = sanitizeInput($_POST['zipcode']);
    $permaAdd = sanitizeInput($_POST['permaAdd']);
    $permaStreet = sanitizeInput($_POST['permaStreet']);
    $permaSub = sanitizeInput($_POST['permaSub']);
    $permaBarangay = sanitizeInput($_POST['permaBarangay']);
    $permaCity = sanitizeInput($_POST['permaCity']);
    $permaProvince = sanitizeInput($_POST['permaProvince']);
    $permaZip = sanitizeInput($_POST['permaZip']);
    $telno = sanitizeInput($_POST['telno']);
    $mobileno = sanitizeInput($_POST['mobileno']);
    $email = sanitizeInput($_POST['email']);


    $sql = "INSERT INTO personal_info (employee_no, csc, sname, fname, mname, extension, datebirth, placebirth, sex, status, height, weight, bloodtype, gsis_id, pagibig_id, philhealth_id, sss_id, tin_id, citizenship, country, resAdd, street, subdivision, barangay, city, province, zipcode, permaAdd, permaStreet, permaSub, permaBarangay, permaCity, permaProvince, permaZip, telno, mobileno, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssssssssssssssssssssssssssssss",
        $employee_no, $csc, $sname, $fname, $mname, $extension, $datebirth, $placebirth, $sex, $status, $height, $weight, $bloodtype,
        $gsis_id, $pagibig_id, $philhealth_id, $sss_id, $tin_id, $citizenship, $country, $resAdd, $street, $subdivision,
        $barangay, $city, $province, $zipcode, $permaAdd, $permaStreet, $permaSub, $permaBarangay, $permaCity, $permaProvince, 
        $permaZip, $telno, $mobileno, $email
    );

    if ($stmt->execute()) {
        $_SESSION['success'] = "New record created successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../famb.php");
    exit();
}
?>