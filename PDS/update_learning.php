<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conn.php';
require '../util/encrypt_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];
    $employee_no = $_POST['employee_no'];
    $titles = $_POST['title'];
    $from_dates = $_POST['from_date'];
    $to_dates = $_POST['to_date'];
    $hours = $_POST['hours'];
    $citizenship_types = $_POST['citizenship_type'];
    $conducted_bys = $_POST['conducted_by'];

   
    $conn->begin_transaction();

    try {
       
        $updateQuery = "UPDATE learning_development SET employee_no = ? WHERE id = ?";
        if ($stmt = $conn->prepare($updateQuery)) {
            $stmt->bind_param('si', $employee_no, $id);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

       
        foreach ($titles as $index => $title) {
            $from_date = $from_dates[$index];
            $to_date = $to_dates[$index];
            $hour = $hours[$index];
            $citizenship_type = $citizenship_types[$index];
            $conducted_by = $conducted_bys[$index];

           
            $updateTrainingQuery = "UPDATE learning_development SET 
                                        title = ?, 
                                        from_date = ?, 
                                        to_date = ?, 
                                        hours = ?, 
                                        citizenship_type = ?, 
                                        conducted_by = ? 
                                    WHERE id = ?"; 

            if ($stmt = $conn->prepare($updateTrainingQuery)) {
                $stmt->bind_param('sssisss', $title, $from_date, $to_date, $hour, $citizenship_type, $conducted_by, $id);
                $stmt->execute();
                $stmt->close();
            } else {
                throw new Exception("Error preparing statement: " . $conn->error);
            }
        }

        $conn->commit();

        $_SESSION['info'] = "Learning and development record updated successfully.";
        $token = encrypt_id($employee_no);
        header("Location: ../viewjo_pds.php?token=$token");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error updating record: " . $e->getMessage();
    }
} else {
   
    $token = encrypt_id($employee_no);
    header("Location: ../viewjo_pds.php?token=$token");
    exit();
}
?>