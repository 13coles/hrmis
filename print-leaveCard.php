<?php
session_start();
require_once './config/conn.php';
require './util/encrypt_helper.php';

// Check if form data is submitted
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $employee_id = decrypt_id($token);

    // Fetch employee details
    $employeeQuery = $conn->prepare("
        SELECT 
            id AS employee_id,
            CONCAT(last_name, ', ', first_name, ' ', IFNULL(middle_name, ''), ' ', IFNULL(extension_name, '')) AS name,
            sex, 
            civil_status, 
            date_hired 
        FROM employees 
        WHERE id = ?
    ");
    $employeeQuery->bind_param("i", $employee_id);
    $employeeQuery->execute();
    $employeeResult = $employeeQuery->get_result();
    
    if ($employeeResult->num_rows > 0) {
        $employee = $employeeResult->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit;
    }

    // Fetch all leave card records for the employee
    $leaveCardQuery = $conn->prepare("
        SELECT 
            year, 
            le_vac, 
            le_sck,
            from_to,
            lt_wp_vac,
            lt_wp_sck,
            lt_np_vac,
            lt_np_sck,
            u_vac,
            u_sck,
            b_vac,
            b_sck,
            p_initial,
            p_date
        FROM pelc 
        WHERE employee_id = ? 
        ORDER BY year ASC, id ASC
    ");
    $leaveCardQuery->bind_param("i", $employee_id);
    $leaveCardQuery->execute();
    $leaveCardResult = $leaveCardQuery->get_result();
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Leave Card</title>
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

<!-- Content Wrapper -->
<div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
            <?php include './util/session-message.php'?>
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-2">
                             <div class="card-header">
                                <div class="row p-2 bg-primary"> 
                                    <div class="col">
                                        <strong class="h6">Employee Name:</strong> <span class="h6"><?= htmlspecialchars($employee['name']) ?></span>
                                    </div>
                                    <div class="col">
                                        <strong class="h6">Sex:</strong> <span class="h6"><?= htmlspecialchars($employee['sex']) ?></span>
                                    </div>
                                    <div class="col">
                                        <strong class="h6">Civil Status:</strong> <span class="h6"><?= htmlspecialchars($employee['civil_status']) ?></span>
                                    </div>
                                    <div class="col">
                                        <strong class="h6">Date Started:</strong> <span class="h6"><?= htmlspecialchars($employee['date_hired']) ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Leave Card Details -->
                            <div class="card-body">
                         

                                <!-- Leave Card Table -->
                                <table class="table table-bordered table-striped table-responsive-sm mt-3">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Year</th>
                                            <th colspan="2">Leaves Earned</th>
                                            <th rowspan="2">From - To</th>
                                            <th colspan="4">Leaves Taken</th>
                                            <th colspan="2">Undertime</th>
                                            <th colspan="2">Balance</th>
                                            <th colspan="2">Processor</th>
                                        </tr>
                                        <tr>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Vacation (With Pay)</th>
                                            <th>Sick (With Pay)</th>
                                            <th>Vacation (No Pay)</th>
                                            <th>Sick (No Pay)</th>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Vacation</th>
                                            <th>Sick</th>
                                            <th>Initial</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($leaveCardResult->num_rows == 0): ?>
                                            <tr>
                                                <td colspan="14" class="text-center">No data available</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php while ($card = $leaveCardResult->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($card['year']) ?></td>
                                                <td><?= htmlspecialchars($card['le_vac']) ?></td>
                                                <td><?= htmlspecialchars($card['le_sck']) ?></td>
                                                <td><?= htmlspecialchars($card['from_to']) ?></td>
                                                <td><?= htmlspecialchars($card['lt_wp_vac']) ?></td>
                                                <td><?= htmlspecialchars($card['lt_wp_sck']) ?></td>
                                                <td><?= htmlspecialchars($card['lt_np_vac']) ?></td>
                                                <td><?= htmlspecialchars($card['lt_np_sck']) ?></td>
                                                <td><?= htmlspecialchars($card['u_vac']) ?></td>
                                                <td><?= htmlspecialchars($card['u_sck']) ?></td>
                                                <td><?= htmlspecialchars($card['b_vac']) ?></td>
                                                <td><?= htmlspecialchars($card['b_sck']) ?></td>
                                                <td><?= htmlspecialchars($card['p_initial']) ?></td>
                                                <td><?= htmlspecialchars($card['p_date']) ?></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<script>
    // Automatically print the page when loaded
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>
