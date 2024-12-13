<?php 
session_start();

require_once './config/conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch and sanitize input data
    $user_name = trim($_POST['user_name']);
    $password = trim($_POST['password']);

    // Check if fields are filled
    if (!empty($user_name) && !empty($password)) {
        // Prepare the SQL query
        $sql = "SELECT * FROM users WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['success'] = "Welcome, " . htmlspecialchars($user['user_name']) . "!";
                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="vendor/almasaeed2010/adminlte/plugins/fontawesome-free/css/all.min.css">
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
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <img src="assets/img/logo1.jpg" alt="HRMIS Logo" height="120">
        <h2>HRMIS ADMIN</h2>
        <?php include './util/session-message.php'?>
        <form action="" method="post">
            <!-- Username Input -->
            <div class="form-group">
                <input type="text" name="user_name" class="form-control" placeholder="Username" required>
            </div>
            <!-- Password Input -->
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="mt-3">Create Account</a>
        </form>
    </div>

    <!-- AdminLTE Scripts -->
    <script src="vendor/almasaeed2010/adminlte/plugins/jquery/jquery.min.js"></script>
    <script src="vendor/almasaeed2010/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
