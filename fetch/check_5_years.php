<?php
require_once '../config/conn.php';

// Fetch employees who have been hired for 5 years or more
$employeesQuery = "SELECT id, employee_no, date_hired FROM employees"; 
$employeesResult = mysqli_query($conn, $employeesQuery);

$notifications = [];

// Loop through all employees
while ($employee = mysqli_fetch_assoc($employeesResult)) {
    $employeeId = $employee['id'];
    $employeeNo = $employee['employee_no'];
    $dateHired = $employee['date_hired'];

    // Calculate the difference between the current date and the date_hired
    $dateHiredTimestamp = strtotime($dateHired);
    $currentDateTimestamp = time();
    $yearsWorked = floor(($currentDateTimestamp - $dateHiredTimestamp) / (60 * 60 * 24 * 365));

    // If the employee has reached 5 years of experience
    if ($yearsWorked >= 5) {
        // Check if the notification already exists for this employee to avoid duplicate entries
        $notificationQuery = "SELECT * FROM notification WHERE employee_no = '$employeeNo' AND notification_message LIKE '%5 years%'";
        $notificationResult = mysqli_query($conn, $notificationQuery);

        if (mysqli_num_rows($notificationResult) == 0) {
            // Insert the notification into the database
            $notificationMessage = "Employee $employeeNo has reached 5 years of experience!";
            $insertNotificationQuery = "INSERT INTO notification (employee_no, notification_message, created_at) 
                                        VALUES ('$employeeNo', '$notificationMessage', NOW())";
            mysqli_query($conn, $insertNotificationQuery);

            // Add the notification to the response array
            $notifications[] = $notificationMessage;
        }
    }
}

// Return the notifications as a JSON response
echo json_encode($notifications);
?>
