<?php
//new
session_start();
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed.');
    }

    $id = intval($_POST['id']);
    $employee_id = intval($_POST['employee_id']);
    $year = $_POST['year'];
    $le_vac = $_POST['le_vac'];
    $le_sck = $_POST['le_sck'];
    $from_to = $_POST['from_to'];
    $lt_wp_vac = $_POST['lt_wp_vac'];
    $lt_wp_sck = $_POST['lt_wp_sck'];
    $lt_np_vac = $_POST['lt_np_vac'];
    $lt_np_sck = $_POST['lt_np_sck'];
    $u_vac = $_POST['u_vac'];
    $u_sck = $_POST['u_sck'];
    $b_vac = $_POST['b_vac'];
    $b_sck = $_POST['b_sck'];
    $p_initial = $_POST['p_initial'];
    $p_date = $_POST['p_date'];

    $query = $conn->prepare("UPDATE pelc SET year = ?, le_vac = ?, le_sck = ?, from_to = ?, lt_wp_vac = ?, lt_wp_sck = ?, lt_np_vac = ?, lt_np_sck = ?, u_vac = ?, u_sck = ?, b_vac = ?, b_sck = ?, p_initial = ?, p_date = ? WHERE id = ?");
    $query->bind_param("idssssssssssssi", $year, $le_vac, $le_sck, $from_to, $lt_wp_vac, $lt_wp_sck, $lt_np_vac, $lt_np_sck, $u_vac, $u_sck, $b_vac, $b_sck, $p_initial, $p_date, $id);

    if ($query->execute()) {
        $_SESSION['info'] = 'Record updated successfully.';
    } else {
        $_SESSION['error'] = 'Error updating record.';
    }

    header("Location: ../leaveCard.php?id=" . $employee_id);
    exit();
    
}
?>
