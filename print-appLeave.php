<?php 
session_start();
require_once './config/conn.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Application Leave</title>
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
    </style>
</head>
<body>

<!-- Header Section -->
<div class="report-header">
    <img src="../images/logo1.jpg" alt="School Logo">
    <h1>Leave Card Record</h1>
    <p>Brgy. Sample, Sample City</p>
    <p>Phone: (123) 456-7890 | Email: school@edu.com</p>
</div>

<script>
    // Automatically print the page when loaded
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>
