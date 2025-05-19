<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$conn = new mysqli("localhost", "root", "Auca@123", "online_driving_permit");

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Function to send OTP via email
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'leopordbonfils@gmail.com';
        $mail->Password = 'lizgsbaaesjtcehj';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 587;
        
        // SSL Configuration
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Recipients
        $mail->setFrom('leopordbonfils@gmail.com', 'Driving_Permit_System');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Your OTP Verification Code';
        $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>OTP Verification Code</h2>
                <p>Your verification code is: <strong style='font-size: 24px; color: #007bff;'>$otp</strong></p>
                <p>This code will expire in 10 minutes.</p>
                <p>If you didn't request this code, please ignore this email.</p>
                <hr>
                <p style='color: #666;'>This is an automated message, please do not reply.</p>
            </body>
            </html>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['send_otp'])) {
        // Generate and send OTP
        $email = $_POST['email'];
        $otp = generateOTP();
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        // Store OTP in database
        $stmt = $conn->prepare("INSERT INTO otp_codes (email, otp, expiry) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $otp, $expiry);
        
        if ($stmt->execute() && sendOTP($email, $otp)) {
            echo "✅ OTP sent successfully!";
        } else {
            echo "❌ Failed to send OTP.";
        }
    }
    
    if (isset($_POST['verify_otp'])) {
        // Verify OTP
        $email = $_POST['email'];
        $user_otp = $_POST['otp'];
        
        $stmt = $conn->prepare("SELECT * FROM otp_codes WHERE email = ? AND otp = ? AND expiry > NOW() AND is_used = 0 ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param("ss", $email, $user_otp);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Mark OTP as used
            $stmt = $conn->prepare("UPDATE otp_codes SET is_used = 1 WHERE email = ? AND otp = ?");
            $stmt->bind_param("ss", $email, $user_otp);
            $stmt->execute();
            
            $_SESSION['otp_verified'] = true;
            echo "✅ OTP verified successfully!";
        } else {
            echo "❌ Invalid or expired OTP.";
        }
    }
}
?> 