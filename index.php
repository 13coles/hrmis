<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRMIS</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">

</head>
<style>
       body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        background-image: url("assets/img/cityhall.jpg");
        background-size: cover; 
        background-position: center;
        background-repeat: no-repeat;
        filter: none;
    }


        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container h2 {
            color: black;
            margin: 20px 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-container img {
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%;
        }

        .login-container .form-control {
            background-color: rgba(240, 240, 240, 0.3);
            color: #000;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-container .btn-primary {
            background: blue;
            border: none;
            width: 100%;
            font-size: 16px;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .login-container .btn-primary:hover {
            opacity: 0.9;
        }
    </style>
<body>
    <div class="login-container">
        <img src="assets/img/logo1.jpg" alt="HRMIS Logo" height="120">
        <h2>HRMIS ADMIN</h2>
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="appLeave.php"class="btn btn-primary">Apply for Leave</a>
    </div>

    <!-- AdminLTE Scripts -->
    <script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
