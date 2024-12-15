<?php 
session_start();
require_once './config/conn.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch employee records from the database
$query = "SELECT * FROM appleave";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Record Reports</title>
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
                        <table id="apple_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Number</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Type of Leave</th>
                                    <th>Number of Days</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                // Check if there are records
                                if (mysqli_num_rows($result) > 0) {
                                    // Loop through the results and display them
                                    while ($row = mysqli_fetch_assoc($result)) { 
                                ?>
                                    <tr>
                                        <td><?php echo $row['employee_no']; ?></td>
                                        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                        <td><?php echo $row['office']; ?></td>
                                        <td><?php echo $row['position']; ?></td>
                                        <td><?php echo $row['typeofLeave']; ?></td>
                                        <td><?php echo $row['numberofWork']; ?></td>
                                        <td>
                                            <div class="dropdown d-flex justify-content-center">
                                                <button type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <!-- View -->
                                                    <form action="viewLeave.php" method="POST" class="mb-0">
                                                        <input type="hidden" name="employee_no" value="<?php echo $row['employee_no']; ?>">
                                                        <button type="submit" class="dropdown-item text-sm">
                                                            <i class="fas fa-file-alt text-primary me-2"></i> View More
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- Delete Employee -->
                                                    <form action="forms/deleteEmployee.php" method="POST" class="mb-0" onsubmit="return confirmDelete();">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <button type="submit" class="dropdown-item text-sm text-danger">
                                                            <i class="fas fa-trash-alt text-danger me-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                                }
                                ?>
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
