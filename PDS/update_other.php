<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php';
require '../util/encrypt_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $other_info_id = $_POST['id'];
    
    // Safely retrieve form inputs with validation
    $employee_no = $_POST['employee_no'] ?? null;
    $skills = isset($_POST['skills']) ? implode(',', (array)$_POST['skills']) : null;
    $non_academic = isset($_POST['non_academic']) ? implode(',', (array)$_POST['non_academic']) : null;
    $membership = isset($_POST['membership']) ? implode(',', (array)$_POST['membership']) : null;
    $if_third = isset($_POST['if_third']) ? 'no' : 'yes';
    $if_fourth = isset($_POST['if_fourth']) ? 'no' : 'yes';
    $if_guilty = isset($_POST['if_guilty']) ? 'no' : 'yes';
    $if_criminal = isset($_POST['if_criminal']) ? 'no' : 'yes';
    $if_convicted = isset($_POST['if_convicted']) ? 'no' : 'yes';
    $if_separated = isset($_POST['if_separated']) ? 'no' : 'yes';
    $if_candidate = isset($_POST['if_candidate']) ? 'no' : 'yes';
    $if_resigned = isset($_POST['if_resigned']) ? 'no' : 'yes';
    $if_immigrant = isset($_POST['if_immigrant']) ? 'no' : 'yes';
    $if_indigenous = isset($_POST['if_indigenous']) ? 'no' : 'yes';

    // Handle optional references
    $ref_nameq = $_POST['ref_nameq'] ?? null;
    $ref_add1 = $_POST['ref_add1'] ?? null;
    $ref_tel1 = $_POST['ref_tel1'] ?? null;
    $ref_name2 = $_POST['ref_name2'] ?? null;
    $ref_add2 = $_POST['ref_add2'] ?? null;
    $ref_tel2 = $_POST['ref_tel2'] ?? null;
    $ref_name3 = $_POST['ref_name3'] ?? null;
    $ref_add3s = $_POST['ref_add3s'] ?? null;
    $ref_tel3 = $_POST['ref_tel3'] ?? null;
    $gov_id = $_POST['gov_id'] ?? null;
    $passport_id = $_POST['passport_id'] ?? null;
    $insure_date = $_POST['insure_date'] ?? null;

    // Prepare the update query
    $update_query = "
        UPDATE other_info
        SET 
            employee_no = ?, 
            skills = ?, 
            non_academic = ?, 
            membership = ?, 
            if_third = ?, 
            if_fourth = ?, 
            if_guilty = ?, 
            if_criminal = ?, 
            if_convicted = ?, 
            if_separated = ?, 
            if_candidate = ?, 
            if_resigned = ?, 
            if_immigrant = ?, 
            if_indigenous = ?, 
            ref_nameq = ?, 
            ref_add1 = ?, 
            ref_tel1 = ?, 
            ref_name2 = ?, 
            ref_add2 = ?, 
            ref_tel2 = ?, 
            ref_name3 = ?, 
            ref_add3s = ?, 
            ref_tel3 = ?, 
            gov_id = ?, 
            passport_id = ?, 
            insure_date = ?
        WHERE id = ?";

    if ($stmt = $conn->prepare($update_query)) {
        // Bind parameters for update
        $stmt->bind_param(
            'ssssssssssssssssssssssssssi',
            $employee_no, $skills, $non_academic, $membership, $if_third, $if_fourth, $if_guilty, $if_criminal,
            $if_convicted, $if_separated, $if_candidate, $if_resigned, $if_immigrant, $if_indigenous,
            $ref_nameq, $ref_add1, $ref_tel1, $ref_name2, $ref_add2, $ref_tel2,
            $ref_name3, $ref_add3s, $ref_tel3, $gov_id, $passport_id, $insure_date, $other_info_id
        );

        // Execute the query
        if ($stmt->execute()) {
            $_SESSION['info'] = "Data updated successfully.";
            $token = encrypt_id($employee_no);
            header("Location: ../viewjo_pds.php?token=$token");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }
} else {
    echo "Invalid request.";
}
?>
