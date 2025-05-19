<?php
session_start();
$message = '';
$color = '';

if (isset($_SESSION['otp_success'])) {
    $message = $_SESSION['otp_success'];
    $color = 'green';
    unset($_SESSION['otp_success']);
} elseif (isset($_SESSION['otp_error'])) {
    $message = $_SESSION['otp_error'];
    $color = 'red';
    unset($_SESSION['otp_error']);
} else {
    
    header("Location: signin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="rw">
<head>
    <meta charset="UTF-8">
    <title>OTP Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
            text-align: center;
            padding-top: 80px;
        }
        .message {
            display: inline-block;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            color: <?php echo $color; ?>;
            font-size: 20px;
        }
        a {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="message">
        <?php echo $message; ?>
        <a href="signin.html">back Sign In</a>
    </div>
</body>
</html>
