<?php
session_start();
require_once './config/conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch total employees on leave
$leaveQuery = "SELECT COUNT(*) AS total_leave FROM appleave";
$leaveResult = mysqli_query($conn, $leaveQuery);
$leaveCount = mysqli_fetch_assoc($leaveResult)['total_leave'];

// Fetch total Job Order employees
$jobOrderQuery = "SELECT COUNT(*) AS total_job_order FROM employees WHERE employee_type = 'jo'";
$jobOrderResult = mysqli_query($conn, $jobOrderQuery);
$jobOrderCount = mysqli_fetch_assoc($jobOrderResult)['total_job_order'];

// Fetch total Permanent employees
$permanentQuery = "SELECT COUNT(*) AS total_permanent FROM employees WHERE employee_type = 'permanent'";
$permanentResult = mysqli_query($conn, $permanentQuery);
$permanentCount = mysqli_fetch_assoc($permanentResult)['total_permanent'];

// Fetch employees with 5 years of service
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/chart.js/Chart.min.css">

    <!-- Google Fonts (for better typography) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8f9fa;
            font-size: 1.25rem;
            color: #495057;
        }

        .card-body {
            padding: 1.25rem;
        }

        .list-group-item {
            padding: 10px;
            font-size: 1rem;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
        }

        .col-lg-4, .col-md-6 {
            margin-bottom: 1.25rem;
        }

        .card-footer {
            background-color: #f8f9fa;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .content-header {
            padding: 15px;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .col-lg-6, .col-md-6 {
                width: 100%;
            }
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <?php include './util/head.php'; ?>

    <!-- Sidebar -->
    <?php include './util/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0 text-dark">Admin Dashboard</h1>
                </div>
            </section>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Session Messages -->
                    <?php include './util/session-message.php'?>

                    <!-- Dashboard Cards -->
                    <div class="row">
                        <!-- Permanent Employees -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Permanent Employees
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $permanentCount; ?> Employees
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Job Order -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Job Order
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $jobOrderCount; ?> Employees
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Leave -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Leave
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $leaveCount; ?> Employees
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CHart and Employees with 5+ Years of Service in the same row -->
                    <div class="row">
                        <!-- CHart Section -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Employee Leave Chart</h6>
                                </div>
                                <div class="card-body">
                                    <div class="calendar">
                                        <!-- Canvas element for the chart -->
                                        <canvas id="leaveChart" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employees with 5+ Years of Service Section -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Employees with 5+ Years of Service</h6>
                                </div>
                                <div class="card-body">
                                    <?php if (count($fiveYearsEmployees) > 0): ?>
                                        <ul class="list-group">
                                            <?php foreach ($fiveYearsEmployees as $employee): ?>
                                                <li class="list-group-item">
                                                    <strong><?php echo !empty($employee['name']) ? $employee['name'] : 'Unknown Employee'; ?></strong> 
                                                    (<?php echo $employee['years_of_service']; ?> years)
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-muted">No employees have reached 5 years of service.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>



    <!-- Footer -->
    <?php include './util/footer.php'; ?>

</div>

<!-- Scripts -->
<script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/chart.js/Chart.bundle.js"></script>
<script src="vendor/almasaeed2010/adminlte/plugins/chart.js/Chart.min.js"></script>
<script src="./assets/js/script.js"></script>
<script>
let chart;

function fetchLeaveData() {
    fetch('fetch/get_leave_data.php')
        .then(response => response.json())
        .then(data => {
            const months = [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ];
            const leaveCounts = data;
            updateChart(months, leaveCounts);
        })
        .catch(error => console.error('Error fetching leave data:', error));
}

// Initialize the chart
function initializeChart() {
    const ctx = document.getElementById('leaveChart').getContext('2d');
    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [], 
            datasets: [{
                label: 'Number of Employee File Leave',
                data: [], 
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        
                        callback: function(value) {
                            return value === 0 ? 'No data' : value;
                        }
                    }
                }
            }
        }
    });
}


function updateChart(months, leaveCounts) {
    console.log("Months:", months); 
    console.log("Leave Counts:", leaveCounts); 
    chart.data.labels = months;
    chart.data.datasets[0].data = leaveCounts; 
    chart.update();
}

document.addEventListener("DOMContentLoaded", function() {
    initializeChart();
    fetchLeaveData(); 
    setInterval(fetchLeaveData, 3000);
});
</script>

</body>
</html>
