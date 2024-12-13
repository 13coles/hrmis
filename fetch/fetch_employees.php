<?php
require_once '../config/conn.php';
// Fetch employees with 5+ years of service
$fiveYearsQuery = "
  SELECT 
    id,
    CONCAT(last_name, ', ', first_name, ' ', COALESCE(middle_name, ''), ' ', COALESCE(extension_name, '')) AS name,
    TIMESTAMPDIFF(YEAR, date_hired, CURDATE()) AS years_of_service,
    employee_no,
    employee_type,
    position,
    department_name
  FROM employees
  WHERE TIMESTAMPDIFF(YEAR, date_hired, CURDATE()) >= 5;
";
$fiveYearsResult = mysqli_query($conn, $fiveYearsQuery);
$fiveYearsEmployees = [];

while ($employee = mysqli_fetch_assoc($fiveYearsResult)) {
    $fiveYearsEmployees[] = $employee;
}

// Return the results as JSON
echo json_encode($fiveYearsEmployees);
?>
