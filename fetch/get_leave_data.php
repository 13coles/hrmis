<?php
require_once '../config/conn.php';

// Query to get leave data grouped by month
$leaveQuery = "
    SELECT 
        MONTH(dateofFilling) AS month, 
        COUNT(*) AS total_leave
    FROM appleave
    GROUP BY MONTH(dateofFilling)
    ORDER BY month ASC
";

$leaveResult = mysqli_query($conn, $leaveQuery);
$data = [];

// Initialize an array with 12 months, all set to 0
$leaveData = array_fill(0, 12, 0); // Default all months to 0

// Fetch leave data and update the corresponding months
while ($row = mysqli_fetch_assoc($leaveResult)) {
    $leaveData[$row['month'] - 1] = $row['total_leave']; // Adjust for 0-based index
}

// Add the leave data to the response
echo json_encode($leaveData);
?>
