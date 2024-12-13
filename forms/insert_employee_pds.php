<?php
session_start();
require_once '../config/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Required fields for employee
    $required_fields = [
        'employee_type', 'employee_no', 'date_hired', 'status', 'last_name',
        'first_name', 'sex', 'civil_status', 'birth_date', 'birth_place',
        'contact_number', 'height', 'weight', 'educational_attainment',
        'blood_type', 'nationality', 'department_name', 'position',
        'salary_grade', 'step'
    ];

    // Check for missing fields
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error'] = "Missing required field: $field.";
            header('Location: ../permanent.php');
            exit();
        }
    }

    // Escaped variables for employee
    $employee_type = mysqli_real_escape_string($conn, $_POST['employee_type']);
    $employee_no = mysqli_real_escape_string($conn, $_POST['employee_no']);
    $date_hired = mysqli_real_escape_string($conn, $_POST['date_hired']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = !empty($_POST['middle_name']) ? mysqli_real_escape_string($conn, $_POST['middle_name']) : null;
    $extension_name = !empty($_POST['extension_name']) ? mysqli_real_escape_string($conn, $_POST['extension_name']) : null;
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $birth_place = mysqli_real_escape_string($conn, $_POST['birth_place']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $educational_attainment = mysqli_real_escape_string($conn, $_POST['educational_attainment']);
    $course = !empty($_POST['course']) ? mysqli_real_escape_string($conn, $_POST['course']) : null;
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $spouse_name = !empty($_POST['spouse_name']) ? mysqli_real_escape_string($conn, $_POST['spouse_name']) : null;
    $spouse_occupation = !empty($_POST['spouse_occupation']) ? mysqli_real_escape_string($conn, $_POST['spouse_occupation']) : null;


    $query = "INSERT INTO employees 
        (employee_type, employee_no, date_hired, status, last_name, first_name, middle_name, extension_name, sex, 
        civil_status, birth_date, birth_place, contact_number, height, weight, educational_attainment, course, 
        blood_type, nationality, spouse_name, spouse_occupation, department_name, position, salary_grade, step) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssssssssssssddsssssssssi",
        $employee_type, $employee_no, $date_hired, $status, $last_name, $first_name, $middle_name, $extension_name, 
        $sex, $civil_status, $birth_date, $birth_place, $contact_number, $height, $weight, $educational_attainment, 
        $course, $blood_type, $nationality, $spouse_name, $spouse_occupation, $department_name, $position, 
        $salary_grade, $step
    );

    if ($stmt->execute()) {
        $employee_id = $stmt->insert_id; 


        if (!empty($_POST['street']) && !empty($_POST['barangay']) && !empty($_POST['city']) && !empty($_POST['province'])) {
            $street = mysqli_real_escape_string($conn, $_POST['street']);
            $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
            $city = mysqli_real_escape_string($conn, $_POST['city']);
            $province = mysqli_real_escape_string($conn, $_POST['province']);
            $address_query = "INSERT INTO address (employee_id, street, barangay, city, province) 
                              VALUES (?, ?, ?, ?, ?)";
            $address_stmt = $conn->prepare($address_query);
            $address_stmt->bind_param("issss", $employee_id, $street, $barangay, $city, $province);
            $address_stmt->execute();
            $address_stmt->close();
        }

        if (!empty($_POST['person_name'])) {
            $person_name = mysqli_real_escape_string($conn, $_POST['person_name']);
            $relationship = mysqli_real_escape_string($conn, $_POST['relationship']);
            $tel_no = mysqli_real_escape_string($conn, $_POST['tel_no']);
            $e_street = mysqli_real_escape_string($conn, $_POST['e_street']);
            $e_barangay = mysqli_real_escape_string($conn, $_POST['e_barangay']);
            $e_city = mysqli_real_escape_string($conn, $_POST['e_city']);
            $e_province = mysqli_real_escape_string($conn, $_POST['e_province']);
            $emergency_query = "INSERT INTO emergency_contacts (employee_id, person_name, relationship, tel_no, e_street, e_barangay, e_city, e_province) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $emergency_stmt = $conn->prepare($emergency_query);
            $emergency_stmt->bind_param("isssssss", $employee_id, $person_name, $relationship, $tel_no, $e_street, $e_barangay, $e_city, $e_province);
            $emergency_stmt->execute();
            $emergency_stmt->close();
        }

       
        if (!empty($_POST['gsis_number'])) {
            $gsis_number = mysqli_real_escape_string($conn, $_POST['gsis_number']);
            $sss_number = mysqli_real_escape_string($conn, $_POST['sss_number']);
            $philhealth_number = mysqli_real_escape_string($conn, $_POST['philhealth_number']);
            $pagibig_number = mysqli_real_escape_string($conn, $_POST['pagibig_number']);
            $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
            $prc_number = mysqli_real_escape_string($conn, $_POST['prc_number']);
            $prc_expiry_date = mysqli_real_escape_string($conn, $_POST['prc_expiry_date']);
            $government_query = "INSERT INTO government_ids (employee_id, gsis_number, sss_number, philhealth_number, pagibig_number, eligibility, prc_number, prc_expiry_date) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $government_stmt = $conn->prepare($government_query);
            $government_stmt->bind_param("isssssss", $employee_id, $gsis_number, $sss_number, $philhealth_number, $pagibig_number, $eligibility, $prc_number, $prc_expiry_date);
            $government_stmt->execute();
            $government_stmt->close();
        }

       
        $_SESSION['success'] = "Employee data successfully added!";
        header('Location: ../permanent.php');
        exit();  

    } else {
        
        $_SESSION['error'] = "Error: Unable to save employee data.";
        header('Location: ../permanent.php');
        exit();  
    }
}
