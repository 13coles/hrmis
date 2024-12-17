<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php';
require '../util/encrypt_helper.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve POST data
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $employee_no = isset($_POST['employee_no']) ? $_POST['employee_no'] : '';

    $elementary = isset($_POST['elementary']) ? $_POST['elementary'] : '';
    $elem_degree = isset($_POST['elem_degree']) ? $_POST['elem_degree'] : '';
    $elem_period = isset($_POST['elem_period']) ? $_POST['elem_period'] : '';
    $elem_level = isset($_POST['elem_level']) ? $_POST['elem_level'] : '';
    $elem_year = isset($_POST['elem_year']) ? $_POST['elem_year'] : '';
    $elem_acad = isset($_POST['elem_acad']) ? $_POST['elem_acad'] : '';

    $secondary = isset($_POST['secondary']) ? $_POST['secondary'] : '';
    $sec_degree = isset($_POST['sec_degree']) ? $_POST['sec_degree'] : '';
    $sec_period = isset($_POST['sec_period']) ? $_POST['sec_period'] : '';
    $sec_level = isset($_POST['sec_level']) ? $_POST['sec_level'] : '';
    $sec_year = isset($_POST['sec_year']) ? $_POST['sec_year'] : '';
    $sec_acad = isset($_POST['sec_acad']) ? $_POST['sec_acad'] : '';

    $vocational = isset($_POST['vocational']) ? $_POST['vocational'] : '';
    $voc_degree = isset($_POST['voc_degree']) ? $_POST['voc_degree'] : '';
    $voc_period = isset($_POST['voc_period']) ? $_POST['voc_period'] : '';
    $voc_level = isset($_POST['voc_level']) ? $_POST['voc_level'] : '';
    $voc_year = isset($_POST['voc_year']) ? $_POST['voc_year'] : '';
    $voc_acad = isset($_POST['voc_acad']) ? $_POST['voc_acad'] : '';

    $college = isset($_POST['college']) ? $_POST['college'] : '';
    $col_degree = isset($_POST['col_degree']) ? $_POST['col_degree'] : '';
    $col_period = isset($_POST['col_period']) ? $_POST['col_period'] : '';
    $col_level = isset($_POST['col_level']) ? $_POST['col_level'] : '';
    $col_year = isset($_POST['col_year']) ? $_POST['col_year'] : '';
    $col_acad = isset($_POST['col_acad']) ? $_POST['col_acad'] : '';

    $graduate = isset($_POST['graduate']) ? $_POST['graduate'] : '';
    $grad_degree = isset($_POST['grad_degree']) ? $_POST['grad_degree'] : '';
    $grad_period = isset($_POST['grad_period']) ? $_POST['grad_period'] : '';
    $grad_level = isset($_POST['grad_level']) ? $_POST['grad_level'] : '';
    $grad_year = isset($_POST['grad_year']) ? $_POST['grad_year'] : '';
    $grad_acad = isset($_POST['grad_acad']) ? $_POST['grad_acad'] : '';

    // Prepare the update query
    $query = "UPDATE educational_background 
              SET employee_no = ?, elementary = ?, elem_degree = ?, elem_period = ?, elem_level = ?, elem_year = ?, elem_acad = ?,
                  secondary = ?, sec_degree = ?, sec_period = ?, sec_level = ?, sec_year = ?, sec_acad = ?,
                  vocational = ?, voc_degree = ?, voc_period = ?, voc_level = ?, voc_year = ?, voc_acad = ?,
                  college = ?, col_degree = ?, col_period = ?, col_level = ?, col_year = ?, col_acad = ?,
                  graduate = ?, grad_degree = ?, grad_period = ?, grad_level = ?, grad_year = ?, grad_acad = ?,
                  updated_at = NOW()
              WHERE id = ?";

    // Prepare and execute the query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('sssssssssssssssssssssssssssssssi', 
            $employee_no, $elementary, $elem_degree, $elem_period, $elem_level, $elem_year, $elem_acad,
            $secondary, $sec_degree, $sec_period, $sec_level, $sec_year, $sec_acad,
            $vocational, $voc_degree, $voc_period, $voc_level, $voc_year, $voc_acad,
            $college, $col_degree, $col_period, $col_level, $col_year, $col_acad,
            $graduate, $grad_degree, $grad_period, $grad_level, $grad_year, $grad_acad, $id
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['info'] = "Educational background updated successfully!";
        } else {
            $_SESSION['error'] = "Error: Could not update educational background.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing the query.";
       
    }

    $conn->close();

    // Redirect with encrypted ID
    $token = encrypt_id($employee_no);
    header("Location: ../viewjo_pds.php?token=$token");
    exit();
}
?>
