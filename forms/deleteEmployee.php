<?php
session_start();
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_POST['employee_id']) && !empty($_POST['employee_id'])) {
     
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $conn->begin_transaction();

        try {

            // Delete from the emergency_contacts table
            $delete_emergency_query = "DELETE FROM emergency_contacts WHERE employee_id = ?";
            $stmt = $conn->prepare($delete_emergency_query);
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            $stmt->close();

            // Delete from the address table
            $delete_address_query = "DELETE FROM address WHERE employee_id = ?";
            $stmt = $conn->prepare($delete_address_query);
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            $stmt->close();

            // Delete from the government_ids table
            $delete_government_query = "DELETE FROM government_ids WHERE employee_id = ?";
            $stmt = $conn->prepare($delete_government_query);
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            $stmt->close();

            // Delete from the pelc table
            $delete_pelc_query = "DELETE FROM pelc WHERE employee_id = ?";
            $stmt = $conn->prepare($delete_pelc_query);
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            $stmt->close();

            // Finally, delete from the employees table
            $delete_employee_query = "DELETE FROM employees WHERE id = ?";
            $stmt = $conn->prepare($delete_employee_query);
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
            $stmt->close();

            // Commit the transaction
            $conn->commit();

            $_SESSION['success'] = "Employee and associated records successfully deleted!";
            header('Location: ../permanent.php');
            exit();

        } catch (Exception $e) {
            // Rollback the transaction in case of any error
            $conn->rollback();
            $_SESSION['error'] = "Error: Unable to delete employee. Please try again.";
            header('Location: ../permanent.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Error: Employee ID not found.";
        header('Location: ../permanent.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request method.";
    header('Location: ../permanent.php');
    exit();
}
?>
