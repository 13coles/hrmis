<?php
require_once '../config/conn.php';

// Fetch employees hired for 5 years or more
$employeesQuery = "
    SELECT 
        e.id, 
        e.employee_no, 
        e.date_hired, 
        e.last_name, 
        e.first_name, 
        e.middle_name, 
        e.extension_name
    FROM employees e
    WHERE TIMESTAMPDIFF(YEAR, e.date_hired, CURDATE()) >= 5
";
$employeesResult = mysqli_query($conn, $employeesQuery);

// Notifications array
$notifications = [];

while ($employee = mysqli_fetch_assoc($employeesResult)) {
    $employeeNo = $employee['employee_no'];
    $fullName = trim(
        $employee['last_name'] . ', ' . 
        $employee['first_name'] . ' ' . 
        ($employee['middle_name'] ? $employee['middle_name'][0] . '.' : '') . 
        ' ' . $employee['extension_name']
    );

    // Check if a notification already exists
    $notificationQuery = "
        SELECT 1 
        FROM notification 
        WHERE employee_no = '$employeeNo' 
          AND notification_message LIKE '%5 years%'
        LIMIT 1
    ";
    $notificationResult = mysqli_query($conn, $notificationQuery);

    if (mysqli_num_rows($notificationResult) == 0) {
        // Insert notification
        $notificationMessage = "$fullName reached 5 years of service!";
        $insertNotificationQuery = "
            INSERT INTO notification (employee_no, notification_message, created_at) 
            VALUES ('$employeeNo', '$notificationMessage', NOW())
        ";
        mysqli_query($conn, $insertNotificationQuery);
    }
}

// Fetch all notifications
$allNotificationsQuery = "
    SELECT notification_message 
    FROM notification 
    ORDER BY created_at DESC
";
$allNotificationsResult = mysqli_query($conn, $allNotificationsQuery);

// Build notifications response
while ($row = mysqli_fetch_assoc($allNotificationsResult)) {
    $notifications[] = $row['notification_message'];
}

// Return notifications as JSON
echo json_encode($notifications);
?>
