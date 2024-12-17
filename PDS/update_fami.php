<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php';
require '../util/encrypt_helper.php';

function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // List of fields to collect and sanitize
    $fields = [
        'employee_no', 'spouse_sname', 'spouse_fname', 'spouse_mname', 'spouse_ext',
        'occupation', 'bussAdd', 'telephone', 'father_sname', 'father_fname', 
        'father_mname', 'mothers_sname', 'mothers_fname', 'mothers_mname', 
        'child1_name', 'child1_birth', 'child2_name', 'child2_birth', 
        'child3_name', 'child3_birth', 'child4_name', 'child4_birth',
        'child5_name', 'child5_birth', 'child6_name', 'child6_birth',
        'child7_name', 'child7_birth', 'id'
    ];

    // Dynamically collect and sanitize input
    $formData = [];
    foreach ($fields as $field) {
        $formData[$field] = isset($_POST[$field]) ? sanitizeInput($_POST[$field]) : '';
    }

    // Ensure all required fields are available
    if (empty($formData['employee_no']) || empty($formData['id'])) {
        $_SESSION['error'] = "Error: Missing required fields.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Update query
    $query = "UPDATE family_info SET
        employee_no = ?,
        spouse_sname = ?,
        spouse_fname = ?,
        spouse_mname = ?,
        spouse_ext = ?,
        occupation = ?,
        bussAdd = ?,
        telephone = ?,
        father_sname = ?,
        father_fname = ?,
        father_mname = ?,
        mothers_sname = ?,
        mothers_fname = ?,
        mothers_mname = ?,
        child1_name = ?,
        child1_birth = ?,
        child2_name = ?,
        child2_birth = ?,
        child3_name = ?,
        child3_birth = ?,
        child4_name = ?,
        child4_birth = ?,
        child5_name = ?,
        child5_birth = ?,
        child6_name = ?,
        child6_birth = ?,
        child7_name = ?,
        child7_birth = ?
        WHERE id = ?";

    // Prepare statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters dynamically
        $stmt->bind_param(
            "ssssssssssssssssssssssssssssi", 
            $formData['employee_no'], $formData['spouse_sname'], $formData['spouse_fname'], 
            $formData['spouse_mname'], $formData['spouse_ext'], $formData['occupation'], 
            $formData['bussAdd'], $formData['telephone'], $formData['father_sname'], 
            $formData['father_fname'], $formData['father_mname'], $formData['mothers_sname'], 
            $formData['mothers_fname'], $formData['mothers_mname'], $formData['child1_name'], 
            $formData['child1_birth'], $formData['child2_name'], $formData['child2_birth'], 
            $formData['child3_name'], $formData['child3_birth'], $formData['child4_name'], 
            $formData['child4_birth'], $formData['child5_name'], $formData['child5_birth'], 
            $formData['child6_name'], $formData['child6_birth'], $formData['child7_name'], 
            $formData['child7_birth'], $formData['id']
        );

        // Execute and check if the update was successful
        if ($stmt->execute()) {
            $_SESSION['info'] = "Personal Record updated!";
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error: Failed to prepare the statement.";
    }

    // Close database connection
    $conn->close();

    // Redirect with encrypted ID
    $token = encrypt_id($formData['employee_no']);
    header("Location: ../viewjo_pds.php?token=$token");
    exit();
}
?>
