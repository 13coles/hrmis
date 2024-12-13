<?php
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $employee_no = $_POST['employee_no'] ?? null;

    $elementary = $_POST['elementary'] ?? null;
    $elemDegree = $_POST['elemDegree'] ?? null;
    $elemPeriod = $_POST['elemPeriod'] ?? null;
    $elemLevel = $_POST['elemLevel'] ?? null;
    $elemYear = $_POST['elemYear'] ?? null;
    $elemAcad = $_POST['elemAcad'] ?? null;

    $secondary = $_POST['secondary'] ?? null;
    $secDegree = $_POST['secDegree'] ?? null;
    $secPeriod = $_POST['secPeriod'] ?? null;
    $secLevel = $_POST['secLevel'] ?? null;
    $secYear = $_POST['secYear'] ?? null;
    $secAcad = $_POST['secAcad'] ?? null;

    $vocational = $_POST['vocational'] ?? null;
    $vocDegree = $_POST['vocDegree'] ?? null;
    $vocPeriod = $_POST['vocPeriod'] ?? null;
    $vocLevel = $_POST['vocLevel'] ?? null;
    $vocYear = $_POST['vocYear'] ?? null;
    $vocAcad = $_POST['vocAcad'] ?? null;

    $college = $_POST['college'] ?? null;
    $colDegree = $_POST['colDegree'] ?? null;
    $colPeriod = $_POST['colPeriod'] ?? null;
    $colLevel = $_POST['colLevel'] ?? null;
    $colYear = $_POST['colYear'] ?? null;
    $colAcad = $_POST['colAcad'] ?? null;

    $graduate = $_POST['graduate'] ?? null;
    $gradDegree = $_POST['gradDegree'] ?? null;
    $gradPeriod = $_POST['gradPeriod'] ?? null;
    $gradLevel = $_POST['gradLevel'] ?? null;
    $gradYear = $_POST['gradYear'] ?? null;
    $gradAcad = $_POST['gradAcad'] ?? null;

    $sql = "INSERT INTO educational_background (
        employee_no, elementary, elem_degree, elem_period, elem_level, elem_year, elem_acad,
        secondary, sec_degree, sec_period, sec_level, sec_year, sec_acad,
        vocational, voc_degree, voc_period, voc_level, voc_year, voc_acad,
        college, col_degree, col_period, col_level, col_year, col_acad,
        graduate, grad_degree, grad_period, grad_level, grad_year, grad_acad
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param(
            'sssssssssssssssssssssssssssssss',
            $employee_no, $elementary, $elemDegree, $elemPeriod, $elemLevel, $elemYear, $elemAcad,
            $secondary, $secDegree, $secPeriod, $secLevel, $secYear, $secAcad,
            $vocational, $vocDegree, $vocPeriod, $vocLevel, $vocYear, $vocAcad,
            $college, $colDegree, $colPeriod, $colLevel, $colYear, $colAcad,
            $graduate, $gradDegree, $gradPeriod, $gradLevel, $gradYear, $gradAcad
        );
    
        if ($stmt->execute()) {
            header('Location: ../PDS.php?success=1');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }    
}
?>
