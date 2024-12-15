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

$childFields = [];
for ($i = 1; $i <= 7; $i++) {
    $childFields["child_{$i}"] = isset($_POST["child_{$i}"]) ? htmlspecialchars(trim($_POST["child_{$i}"])) : null;
    $childFields["child_{$i}_birth"] = isset($_POST["child_{$i}_birth"]) ? htmlspecialchars(trim($_POST["child_{$i}_birth"])) : null;
}

$stmt = $conn->prepare("
    INSERT INTO family_info (
        employee_no, spouse_sname, spouse_fname, spouse_mname, spouse_ext, occupation, bussAdd, telephone,
        father_sname, father_fname, father_mname, mothers_sname, mothers_fname, mothers_mname,
        child1_name, child1_birth, child2_name, child2_birth, child3_name, child3_birth,
        child4_name, child4_birth, child5_name, child5_birth, child6_name, child6_birth, 
        child7_name, child7_birth, created_at, updated_at
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
    )
");

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param(
    "ssssssssssssssssssssssssssss",
    $employee_no, $spouse_sname, $spouse_fname, $spouse_mname, $spouse_ext, $occupation, $bussAdd, $telephone,
    $father_sname, $father_fname, $father_mname, $mothers_sname, $mothers_fname, $mothers_mname,
    $childFields['child_1'], $childFields['child_1_birth'], $childFields['child_2'], $childFields['child_2_birth'],
    $childFields['child_3'], $childFields['child_3_birth'], $childFields['child_4'], $childFields['child_4_birth'],
    $childFields['child_5'], $childFields['child_5_birth'], $childFields['child_6'], $childFields['child_6_birth'],
    $childFields['child_7'], $childFields['child_7_birth']
);

if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

$stmt->close();
$conn->close();

header("Location: ../educational.php?success=1");
exit();
?>
