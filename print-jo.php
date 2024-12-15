<?php 
session_start();
require_once './config/conn.php';
require './util/encrypt_helper.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch employee records from the database
$query = "SELECT id, employee_no, last_name, first_name, middle_name, extension_name, department_name, date_hired, position FROM employees WHERE employee_type = 'jo' ";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Order Employee Record Report</title>
    <style>
        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .report-header h1, .report-header p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media print {
            body {
                font-family: Arial, sans-serif;
            }
            table {
                page-break-inside: avoid;
            }
        }
        .header1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header1 img {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="header1">
    <img src="assets/img/logo1.jpg" alt="City Logo">
                            <div>
                                <p>Republic of the Philippines<br>
                                Province of Negros Occidental<br>
                                <strong>City of Sagay</strong><br>
                                OFFICE OF THE HUMAN RESOURCE & MANAGEMENT<br>
                                Cell No. 09171194285<br>
                                Email add: <em>www.hrmosagaycity@gmail.com</em></p>
                            </div>
                            <img src="assets/img/SAGAY.png" alt="HR Logo">
    </div>

  <!-- Main Content -->
  <section class="content">
            <div class="container-fluid">
            <?php include './util/session-message.php'?>
                <!-- Table for Employee Records -->
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title">Employee Records</h3>
                     
                    </div>
                    <div class="card-body">
                        <table id="employee_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Number</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Years In Service</th>
                                    <th>Position</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Loop through the result and display each record dynamically
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $employeeNumber = $row['employee_no'];

                                    // Construct employee name
                                    $employeeName = $row['last_name'] . ', ' . $row['first_name'];
                                    if (!empty($row['middle_name'])) {
                                        $employeeName .= ' ' . $row['middle_name'];
                                    }
                                    if (!empty($row['extension_name'])) {
                                        $employeeName .= ' ' . $row['extension_name'];
                                    }

                                    // Get department name
                                    $department = $row['department_name'];

                                    // Calculate years in service
                                    $dateHired = $row['date_hired'];
                                    $yearsInService = floor((strtotime(date('Y-m-d')) - strtotime($dateHired)) / (365*60*60*24));

                                    // Check for 5 years of service and insert notification
                                    if ($yearsInService === 5) {
                                        $notificationMessage = "Congrats! You reached 5 years of service.";
                                        $createdAt = date('Y-m-d H:i:s');

                                        // Insert notification into database
                                        $notificationQuery = "INSERT INTO notifications (employee_no, notification_message, created_at) VALUES ('$employeeNumber', '$notificationMessage', '$createdAt')";
                                        mysqli_query($conn, $notificationQuery);
                                    }

                                    // Get position
                                    $position = $row['position'];
                                ?>
                                <tr>
                                    <td><?php echo $employeeNumber; ?></td>
                                    <td><?php echo $employeeName; ?></td>
                                    <td><?php echo $department; ?></td>
                                    <td><?php echo $yearsInService; ?></td>
                                    <td><?php echo $position; ?></td>
                                  
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>
