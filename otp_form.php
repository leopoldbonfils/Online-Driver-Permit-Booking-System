<?php
session_start();


if (!isset($_SESSION['temp_user_id'])) {
    header("Location: signin.html");
    exit();
}


if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
    $_SESSION['user_id'] = $_SESSION['temp_user_id'];
    $_SESSION['username'] = $_SESSION['temp_username'];
    
    
    unset($_SESSION['temp_user_id']);
    unset($_SESSION['temp_username']);
    unset($_SESSION['temp_email']);
    unset($_SESSION['otp_verified']);
    
    header("Location: signin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="signin.css">
    <style>
        .otp-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .otp-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .resend {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h2>OTP Verification</h2>
        <p>We've sent a verification code to your email address.</p>
        
        
        <form action="otp_verification.php" method="post" id="sendOtpForm">
            <input type="hidden" name="email" value="<?php echo $_SESSION['temp_email']; ?>">
            <input type="hidden" name="send_otp" value="1">
            <button type="submit" class="btn">Send OTP</button>
        </form>

    
        <form action="otp_verification.php" method="post" id="verifyOtpForm">
            <input type="hidden" name="email" value="<?php echo $_SESSION['temp_email']; ?>">
            <input type="text" name="otp" class="otp-input" placeholder="Enter OTP" required>
            <input type="hidden" name="verify_otp" value="1">
            <button type="submit" class="btn">Verify OTP</button>
        </form>

        <div class="resend">
            <p>Didn't receive the code? <a href="#" onclick="document.getElementById('sendOtpForm').submit(); return false;">Resend OTP</a></p>
        </div>
    </div>
</body>
</html> 