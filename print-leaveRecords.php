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
   
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .report-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .report-header img {
        max-width: 150px;
        margin-bottom: 10px;
    }

    .report-header h1,
    .report-header p {
        margin: 0;
    }

   
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    
    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        .header1 {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        table {
            page-break-inside: avoid; 
            margin: 0 auto; 
        }

       
        .content {
            margin: 0;
            padding: 0;
        }
    }

    
    .header1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header1 img {
        width: 100px;
    }

   
    .content {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
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
<h3>Leave Records</h3>
    <!-- Main Content -->
    <section class="content">
          
                        <table id="apple_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Number</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Type of Leave</th>
                                    <th>Number of Days</th>
                                   
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
                                      
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
              
        </section>
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>
