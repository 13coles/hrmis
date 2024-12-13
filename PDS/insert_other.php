<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php'; 


$employee_no = mysqli_real_escape_string($conn, $_POST['employee_no']);
$skills = !empty($_POST['skills']) ? implode(", ", $_POST['skills']) : null;
$non_academic = !empty($_POST['non_academic']) ? implode(", ", $_POST['non_academic']) : null;
$membership = !empty($_POST['membership']) ? implode(", ", $_POST['membership']) : null;
$if_third = mysqli_real_escape_string($conn, $_POST['if_third']);
$if_fourth = mysqli_real_escape_string($conn, $_POST['if_fourth']);
$if_guilty = mysqli_real_escape_string($conn, $_POST['if_guilty']);
$if_criminal = mysqli_real_escape_string($conn, $_POST['if_criminal']);
$if_convicted = mysqli_real_escape_string($conn, $_POST['if_convicted']);
$if_separated = mysqli_real_escape_string($conn, $_POST['if_separated']);
$if_candidate = mysqli_real_escape_string($conn, $_POST['if_candidate']);
$if_resigned = mysqli_real_escape_string($conn, $_POST['if_resigned']);
$if_immigrant = mysqli_real_escape_string($conn, $_POST['if_immigrant']);
$if_indigenous = mysqli_real_escape_string($conn, $_POST['if_indigenous']);
$ref_nameq = mysqli_real_escape_string($conn, $_POST['ref_nameq']);
$ref_add1 = mysqli_real_escape_string($conn, $_POST['ref_add1']);
$ref_tel1 = mysqli_real_escape_string($conn, $_POST['ref_tel1']);
$ref_name2 = mysqli_real_escape_string($conn, $_POST['ref_name2']);
$ref_add2 = mysqli_real_escape_string($conn, $_POST['ref_add2']);
$ref_tel2 = mysqli_real_escape_string($conn, $_POST['ref_tel2']);
$ref_name3 = mysqli_real_escape_string($conn, $_POST['ref_name3']);
$ref_add3s = mysqli_real_escape_string($conn, $_POST['ref_add3s']);
$ref_tel3 = mysqli_real_escape_string($conn, $_POST['ref_tel3']);
$gov_id = mysqli_real_escape_string($conn, $_POST['gov_id']);
$passport_id = mysqli_real_escape_string($conn, $_POST['passport_id']);
$insure_date = mysqli_real_escape_string($conn, $_POST['insure_date']);

$query = "INSERT INTO other_info
    (employee_no, skills, non_academic, membership, if_third, if_fourth, if_guilty, if_criminal, if_convicted, if_separated, if_candidate, if_resigned, if_immigrant, if_indigenous, 
    ref_nameq, ref_add1, ref_tel1, ref_name2, ref_add2, ref_tel2, ref_name3, ref_add3s, ref_tel3, gov_id, passport_id, insure_date)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}

$stmt->bind_param(
    'ssssssssssssssssssssssssss', 
    $employee_no, $skills, $non_academic, $membership, $if_third, $if_fourth, $if_guilty, $if_criminal, $if_convicted, $if_separated, 
    $if_candidate, $if_resigned, $if_immigrant, $if_indigenous, $ref_nameq, $ref_add1, $ref_tel1, $ref_name2, $ref_add2, $ref_tel2, 
    $ref_name3, $ref_add3s, $ref_tel3, $gov_id, $passport_id, $insure_date
);



if ($stmt->execute()) {

    header("Location: ../PDS.php");
    exit();
} else {
   
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
