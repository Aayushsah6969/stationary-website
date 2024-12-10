<?php
session_start();

// Initialize attempt tracking variables if they don't exist
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Generate CAPTCHA
$captcha_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 70vw;
        }
        .login-form h1 {
            margin: 0 0 15px;
            color: #007bb5;
        }
        .login-form input[type="text"], .login-form input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-form input[type="submit"] {
            background: #007bb5;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-form input[type="submit"]:hover {
            background: #005f8b;
        }
        .error {
            color: red;
        }
        @media only screen and (max-width:600px){
            .login-form{
                max-width: 100vw;
                height: auto;
                margin-top: -15vh;
            }
            input{
                font-size: 1.5rem;
            }
        }
        .captcha{
            border: 1px solid grey;
            display: inline-block;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            user-select: none; /* Disable text selection */
        -webkit-user-select: none; /* Disable text selection for Safari */
        -moz-user-select: none; /* Disable text selection for Firefox */
        -ms-user-select: none; 
        }
    </style>
</head>
<body>
    <form class="login-form" action="adminlogin.php" method="post">
        <h1>Login</h1>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="captcha" placeholder="Enter CAPTCHA" required>
        <p class="captcha"><?php echo $_SESSION['captcha_code']; ?></p><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
