<?php
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Employee Information
    $employee_no = $_POST['employee_no'] ?? null;

    // Elementary Education
    $elementary = $_POST['elementary'] ?? null;
    $elem_degree = $_POST['elem_degree'] ?? null;
    $elem_period = $_POST['elem_period'] ?? null;
    $elem_level = $_POST['elem_level'] ?? null;
    $elem_year = $_POST['elem_year'] ?? null;
    $elem_acad = $_POST['elem_acad'] ?? null;

    // Secondary Education
    $secondary = $_POST['secondary'] ?? null;
    $sec_degree = $_POST['sec_degree'] ?? null;
    $sec_period = $_POST['sec_period'] ?? null;
    $sec_level = $_POST['sec_level'] ?? null;
    $sec_year = $_POST['sec_year'] ?? null; 
    $sec_acad = $_POST['sec_acad'] ?? null;

    // Vocational Education
    $vocational = $_POST['vocational'] ?? null;
    $voc_degree = $_POST['voc_degree'] ?? null;
    $voc_period = $_POST['voc_period'] ?? null;
    $voc_level = $_POST['voc_level'] ?? null;
    $voc_year = $_POST['voc_year'] ?? null;
    $voc_acad = $_POST['voc_acad'] ?? null;

    // College Education
    $college = $_POST['college'] ?? null;
    $col_degree = $_POST['col_degree'] ?? null;
    $col_period = $_POST['col_period'] ?? null;
    $col_level = $_POST['col_level'] ?? null;
    $col_year = $_POST['col_year'] ?? null;
    $col_acad = $_POST['col_acad'] ?? null;

    // Graduate Education
    $graduate = $_POST['graduate'] ?? null;
    $grad_degree = $_POST['grad_degree'] ?? null;
    $grad_period = $_POST['grad_period'] ?? null;
    $grad_level = $_POST['grad_level'] ?? null;
    $grad_year = $_POST['grad_year'] ?? null;
    $grad_acad = $_POST['grad_acad'] ?? null;

    // Prepare the SQL query
    $sql = "INSERT INTO educational_background (
        employee_no, elementary, elem_degree, elem_period, elem_level, elem_year, elem_acad,
        secondary, sec_degree, sec_period, sec_level, sec_year, sec_acad,
        vocational, voc_degree, voc_period, voc_level, voc_year, voc_acad,
        college, col_degree, col_period, col_level, col_year, col_acad,
        graduate, grad_degree, grad_period, grad_level, grad_year, grad_acad
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters to the prepared statement
        $stmt->bind_param(
            'sssssssssssssssssssssssssssssss',
            $employee_no, $elementary, $elem_degree, $elem_period, $elem_level, $elem_year, $elem_acad,
            $secondary, $sec_degree, $sec_period, $sec_level, $sec_year, $sec_acad,
            $vocational, $voc_degree, $voc_period, $voc_level, $voc_year, $voc_acad,
            $college, $col_degree, $col_period, $col_level, $col_year, $col_acad,
            $graduate, $grad_degree, $grad_period, $grad_level, $grad_year, $grad_acad
        );

        // Execute the statement
        if ($stmt->execute()) {
            header('Location: ../PDS.php?success=1');
            exit();
        } else {
            echo "Execution Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Preparation Error: " . $conn->error;
    }
    
    // Close the connection
    $conn->close();
}
?>
