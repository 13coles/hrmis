<?php
// this was change
session_start();
require_once './config/conn.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$employee = null;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
    $query = "SELECT 
                a.id,
                a.employee_id,
                e.employee_no,
                e.first_name, 
                e.middle_name, 
                e.last_name, 
                e.extension_name,
                e.department_name,
                e.position,
                e.salary_grade,
                a.dateofFilling,
                a.typeofLeave,
                a.others,
                a.vacationleave,
                a.sickleave,
                a.specialleave,
                a.studyleave,
                a.otherpurpose,
                a.numberofWork,
                a.inclusiveDate_from,
                a.inclusiveDate_to,
                a.commutation,
                a.certificationofLeave,
                a.vacationTotal,
                a.vacationLess,
                a.vacationBalance,
                a.sickTotal,
                a.sickLess,
                a.sickBalance,
                a.recommendation,
                a.forDisapproval,
                a.approved,
                a.disapproved
            FROM appleave a
            INNER JOIN employees e ON a.employee_id = e.id
            WHERE a.employee_id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $employee_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $employee = mysqli_fetch_assoc($result);
        } else {
            $error_message = "No record found for Employee ID: " . htmlspecialchars($employee_id);
        }

        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Query failed: " . mysqli_error($conn);
    }
} else {
    $error_message = "Invalid request.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Report</title>
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

    <?php if ($error_message): ?>
        <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
    <?php elseif ($employee): ?>
        <div class="card-header">
    <h6 class="font-weight-bold text-primary">Employee Details</h6>
</div>
<table class="table">
    <tr>
        <th>Employee No:</th>
        <td><input type="text" name="employee_no" class="form-control" placeholder="Enter Employee No" value="<?php echo htmlspecialchars($employee['employee_no']); ?>"></td>
    </tr>
    <tr>
        <th>Office/Department-District/School:</th>
        <td><input type="text" name="department_name" class="form-control" placeholder="Enter Office" value="<?php echo htmlspecialchars($employee['department_name']); ?>"></td>
    </tr>
    <tr>
        <th>Last Name:</th>
        <td><input type="text" name="last_name" class="form-control" required placeholder="Enter Last Name" value="<?php echo htmlspecialchars($employee['last_name']); ?>"></td>
    </tr>
    <tr>
        <th>First Name:</th>
        <td><input type="text" name="first_name" class="form-control" placeholder="Enter First Name" value="<?php echo htmlspecialchars($employee['first_name']); ?>"></td>
    </tr>
    <tr>
        <th>Middle Name:</th>
        <td><input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name" value="<?php echo htmlspecialchars($employee['middle_name']); ?>"></td>
    </tr>
    <tr>
        <th>Position:</th>
        <td><input type="text" name="position" class="form-control" placeholder="Enter your Position" value="<?php echo htmlspecialchars($employee['position']); ?>"></td>
    </tr>
    <tr>
        <th>Salary:</th>
        <td><input type="text" name="salary_grade" class="form-control" placeholder="Enter Salary" value="<?php echo htmlspecialchars($employee['salary_grade']); ?>"></td>
    </tr>
    <tr>
        <th>Date of Filing:</th>
        <td><input type="date" name="dateofFilling" class="form-control" value="<?php echo htmlspecialchars($employee['dateofFilling']); ?>"></td>
    </tr>
</table>

<div class="card-header">
    <h6 class="font-weight-bold text-primary">Details of Application</h6>
</div>
<table class="table">
    <tr>
        <th>Type of Leave:</th>
        <td><input type="text" name="typeofLeave" class="form-control" value="<?php echo htmlspecialchars($employee['typeofLeave']); ?>"></td>
    </tr>
    <tr>
        <th>Others (Specify):</th>
        <td><input type="text" name="others" class="form-control"></td>
    </tr>
    <tr>
        <th>Details of Leave <br><i>In case of Vacation/Special Privilege Leave:</i></th>
        <td><input type="text" name="vacationleave" class="form-control" placeholder="Within the Philippines/Abroad (Specify)" value="<?php echo htmlspecialchars($employee['vacationleave']); ?>"></td>
    </tr>
    <tr>
        <th><br><i>In case of Sick Leave:</i></th>
        <td><input type="text" name="sickleave" class="form-control" placeholder="In Hospital/Out Patient(Specify Illness)" value="<?php echo htmlspecialchars($employee['sickleave']); ?>"></td>
    </tr>
    <tr>
        <th><br><i>In case of Special Leave Benefits for Women:</i></th>
        <td><input type="text" name="specialleave" class="form-control" placeholder="(Specify Illness)" value="<?php echo htmlspecialchars($employee['specialleave']); ?>"></td>
    </tr>
    <tr>
        <th><br><i>In case of Study Leave:</i></th>
        <td><input type="text" name="studyleave" class="form-control" value="<?php echo htmlspecialchars($employee['studyleave']); ?>"></td>
    </tr>
    <tr>
        <th><i>Other Purpose:</i></th>
        <td><input type="text" name="otherpurpose" class="form-control" value="<?php echo htmlspecialchars($employee['otherpurpose']); ?>"></td>
    </tr>
    <tr>
        <th>Number of Working Days Applied for:</th>
        <td><input type="text" name="numberofWork" class="form-control" placeholder="Enter number of days applied for" value="<?php echo htmlspecialchars($employee['numberofWork']); ?>"></td>
    </tr>
    <tr>
        <th>Inclusive Dates <br>From:</th>
        <td><input type="date" name="inclusiveDate_from" class="form-control" value="<?php echo htmlspecialchars($employee['inclusiveDate_from']); ?>"></td>
    </tr>
    <tr>
        <th><br>To:</th>
        <td><input type="date" name="inclusiveDate_to" class="form-control" value="<?php echo htmlspecialchars($employee['inclusiveDate_to']); ?>"></td>
    </tr>
    <tr>
        <th><i>Commutation:</i></th>
        <td><input name="commutation" class="form-control" value="<?php echo htmlspecialchars($employee['commutation']); ?>"></td>
    </tr>
</table>

<div class="card-header">
    <h6 class="font-weight-bold text-primary">Leave Credits</h6>
</div>
<table class="table">
    <tr>
        <th>Certification of Leave Credits:</th>
        <td><input type="date" name="certificationofLeave" class="form-control" value="<?php echo htmlspecialchars($employee['certificationofLeave']); ?>"></td>
    </tr>
    <tr>
        <th>Vacation Leave:</th>
        <td><input type="text" name="vacationTotal" class="form-control" placeholder="Enter Vacation Leave" value="<?php echo htmlspecialchars($employee['vacationTotal']); ?>"></td>
    </tr>
    <tr>
        <th>Sick Leave:</th>
        <td><input type="text" name="sickTotal" class="form-control" placeholder="Enter Sick Leave" value="<?php echo htmlspecialchars($employee['sickTotal']); ?>"></td>
    </tr>
    <tr>
        <th>Less this application:</th>
        <td><input type="text" name="vacationLess" class="form-control" placeholder="Enter Vacation Less" value="<?php echo htmlspecialchars($employee['vacationLess']); ?>"></td>
    </tr>
    <tr>
        <th>Sick Leave Less:</th>
        <td><input type="text" name="sickLess" class="form-control" placeholder="Enter Sick Less" value="<?php echo htmlspecialchars($employee['sickLess']); ?>"></td>
    </tr>
    <tr>
        <th>Balance:</th>
        <td><input type="text" name="vacationBalance" class="form-control" placeholder="Enter Vacation Balance" value="<?php echo htmlspecialchars($employee['vacationBalance']); ?>"></td>
    </tr>
    <tr>
        <th>Sick Balance:</th>
        <td><input type="text" name="sickBalance" class="form-control" placeholder="Enter Sick Balance" value="<?php echo htmlspecialchars($employee['sickBalance']); ?>"></td>
    </tr>
</table>

<div class="card-header">
    <h6 class="font-weight-bold text-primary">Recommendation and Approval</h6>
</div>
<table class="table">
    <tr>
        <th>Recommendation:</th>
        <td><input type="text" name="recommendation" class="form-control" value="<?php echo htmlspecialchars($employee['recommendation']); ?>"></td>
    </tr>
    <tr>
        <th>Approved for:</th>
        <td><input type="text" name="approved" class="form-control" placeholder="days with pay / days without pay / others (specify)" value="<?php echo htmlspecialchars($employee['approved']); ?>"></td>
    </tr>
    <tr>
        <th>Disapproved due to:</th>
        <td><input type="text" name="disapproved" class="form-control" value="<?php echo htmlspecialchars($employee['disapproved']); ?>"></td>
    </tr>
</table>

    <?php endif; ?>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>
