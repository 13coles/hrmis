<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php';


$employee_no = isset($_POST['employee_no']) ? htmlspecialchars(trim($_POST['employee_no'])) : null;
$spouse_sname = isset($_POST['spouse_sname']) ? htmlspecialchars(trim($_POST['spouse_sname'])) : null;
$spouse_fname = isset($_POST['spouse_fname']) ? htmlspecialchars(trim($_POST['spouse_fname'])) : null;
$spouse_mname = isset($_POST['spouse_mname']) ? htmlspecialchars(trim($_POST['spouse_mname'])) : null;
$spouse_ext = isset($_POST['spouse_ext']) ? htmlspecialchars(trim($_POST['spouse_ext'])) : null;
$occupation = isset($_POST['occupation']) ? htmlspecialchars(trim($_POST['occupation'])) : null;
$bussAdd = isset($_POST['bussAdd']) ? htmlspecialchars(trim($_POST['bussAdd'])) : null;
$telephone = isset($_POST['telephone']) ? htmlspecialchars(trim($_POST['telephone'])) : null;

$father_sname = isset($_POST['father_sname']) ? htmlspecialchars(trim($_POST['father_sname'])) : null;
$father_fname = isset($_POST['father_fname']) ? htmlspecialchars(trim($_POST['father_fname'])) : null;
$father_mname = isset($_POST['father_mname']) ? htmlspecialchars(trim($_POST['father_mname'])) : null;

$mothers_sname = isset($_POST['mothers_sname']) ? htmlspecialchars(trim($_POST['mothers_sname'])) : null;
$mothers_fname = isset($_POST['mothers_fname']) ? htmlspecialchars(trim($_POST['mothers_fname'])) : null;
$mothers_mname = isset($_POST['mothers_mname']) ? htmlspecialchars(trim($_POST['mothers_mname'])) : null;


$child_1 = isset($_POST['child_1']) ? htmlspecialchars(trim($_POST['child_1'])) : null;
$child_1_birth = isset($_POST['child_1_birth']) ? htmlspecialchars(trim($_POST['child_1_birth'])) : null;

$child_2 = isset($_POST['child_2']) ? htmlspecialchars(trim($_POST['child_2'])) : null;
$child_2_birth = isset($_POST['child_2_birth']) ? htmlspecialchars(trim($_POST['child_2_birth'])) : null;

$child_3 = isset($_POST['child_3']) ? htmlspecialchars(trim($_POST['child_3'])) : null;
$child_3_birth = isset($_POST['child_3_birth']) ? htmlspecialchars(trim($_POST['child_3_birth'])) : null;

$child_4 = isset($_POST['child_4']) ? htmlspecialchars(trim($_POST['child_4'])) : null;
$child_4_birth = isset($_POST['child_4_birth']) ? htmlspecialchars(trim($_POST['child_4_birth'])) : null;

$child_5 = isset($_POST['child_5']) ? htmlspecialchars(trim($_POST['child_5'])) : null;
$child_5_birth = isset($_POST['child_5_birth']) ? htmlspecialchars(trim($_POST['child_5_birth'])) : null;

$child_6 = isset($_POST['child_6']) ? htmlspecialchars(trim($_POST['child_6'])) : null;
$child_6_birth = isset($_POST['child_6_birth']) ? htmlspecialchars(trim($_POST['child_6_birth'])) : null;

$child_7 = isset($_POST['child_7']) ? htmlspecialchars(trim($_POST['child_7'])) : null;
$child_7_birth = isset($_POST['child_7_birth']) ? htmlspecialchars(trim($_POST['child_7_birth'])) : null;


$stmt = $conn->prepare("INSERT INTO family_info (
    employee_no, spouse_sname, spouse_fname, spouse_mname, spouse_ext, occupation, bussAdd, telephone,
    father_sname, father_fname, father_mname, mothers_sname, mothers_fname, mothers_mname,
    child1_name, child1_birth, child2_name, child2_birth, child3_name, child3_birth,
    child4_name, child4_birth, child5_name, child5_birth, child6_name, child6_birth, 
    child7_name, child7_birth, created_at, updated_at
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
)");

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}


$stmt->bind_param(
    "ssssssssssssssssssssssssssss",
    $employee_no, $spouse_sname, $spouse_fname, $spouse_mname, $spouse_ext, $occupation, $bussAdd, $telephone,
    $father_sname, $father_fname, $father_mname, $mothers_sname, $mothers_fname, $mothers_mname,
    $_POST['child_1'], $_POST['child_1_birth'], $_POST['child_2'], $_POST['child_2_birth'],
    $_POST['child_3'], $_POST['child_3_birth'], $_POST['child_4'], $_POST['child_4_birth'],
    $_POST['child_5'], $_POST['child_5_birth'], $_POST['child_6'], $_POST['child_6_birth'],
    $_POST['child_7'], $_POST['child_7_birth']
);


if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

$stmt->close();
$conn->close();


$childDataAvailable = !empty($_POST['child_1']) || !empty($_POST['child_2']) || !empty($_POST['child_3']);
if ($childDataAvailable) {
    header("Location: ../PDS.php?success=1");
} else {
    header("Location: form_page.php?error=no_child_data");
}
exit();
?>
