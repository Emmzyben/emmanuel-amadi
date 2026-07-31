<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    ensure_default_admin($firebaseDatabase);
    $admin = verify_admin($firebaseDatabase, $username, $password);

    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_user'] = $admin['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #222222;
            font-family: 'Open Sans', sans-serif;
            color: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: #333333;
            border: 1px solid #FF6F61;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .login-card h2 {
            color: #FF6F61;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            background-color: #222222;
            border: 1px solid #444;
            color: #fff;
            border-radius: 0;
            padding: 12px;
        }
        .form-control:focus {
            background-color: #222222;
            border-color: #FF6F61;
            color: #fff;
            box-shadow: none;
        }
        .btn-login {
            background-color: #FF6F61;
            color: #222222;
            border: none;
            border-radius: 0;
            padding: 12px;
            font-weight: 700;
            width: 100%;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #ffffff;
            color: #FF6F61;
        }
        .error-msg {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Admin Portal</h2>
        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login">LOGIN</button>
        </form>
    </div>
</body>
</html>
