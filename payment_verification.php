<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use AfricasTalking\SDK\AfricasTalking;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
require 'vendor/autoload.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug session data
error_log("Session data: " . print_r($_SESSION, true));

// Check if user is coming from payment process
if (!isset($_SESSION['national_id']) || !isset($_SESSION['send_method']) || !isset($_SESSION['contact_value'])) {
    error_log("Missing session data. Redirecting to index.php");
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "Auca@123", "online_driving_permit");

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Function to send OTP via email
function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'leopordbonfils@gmail.com';
        $mail->Password = 'ozwovevikldaogf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('leopordbonfils@gmail.com', 'Online Driving Permit System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Payment Verification Code';
        $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>Payment Verification Code</h2>
                <p>Your verification code is: <strong style='font-size: 24px; color: #007bff;'>$otp</strong></p>
                <p>This code will expire in 10 minutes.</p>
                <p>If you didn't request this code, please ignore this email.</p>
                <hr>
                <p style='color: #666;'>This is an automated message, please do not reply.</p>
            </body>
            </html>";

        $mail->send();
        error_log("Email sent successfully to: " . $email);
        return true;
    } catch (Exception $e) {
        error_log("Email Error: " . $e->getMessage());
        return false;
    }
}

// Function to send OTP via SMS using Africa's Talking
function sendOTPSMS($phone, $otp) {
    try {
        // Initialize Africa's Talking
        $username = "sandbox"; // Replace with your Africa's Talking username
        $apiKey = "YOUR_API_KEY"; // Replace with your Africa's Talking API key
        
        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();
        
        // Format the phone number (remove any spaces or special characters)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Add country code if not present
        if (substr($phone, 0, 3) !== '250') {
            $phone = '250' . ltrim($phone, '0');
        }
        
        // Prepare the message
        $message = "Your Online Driving Permit payment verification code is: $otp. This code will expire in 10 minutes.";
        
        // Send the message
        $result = $sms->send([
            'to'      => $phone,
            'message' => $message,
            'from'    => 'DRIVING' // Replace with your Africa's Talking sender ID
        ]);
        
        error_log("SMS sent successfully to: " . $phone);
        return true;
    } catch (Exception $e) {
        error_log("SMS Error: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("POST request received: " . print_r($_POST, true));
    
    if (isset($_POST['send_otp'])) {
        $national_id = $_SESSION['national_id'];
        $payment_method = $_SESSION['payment_method'];
        $send_method = $_SESSION['send_method'];
        $contact_value = $_SESSION['contact_value'];
        $otp = generateOTP();
        
        error_log("Generating OTP for: " . $national_id);
        error_log("Send method: " . $send_method);
        error_log("Contact value: " . $contact_value);
        
        // First, check if there's an existing unverified payment
        $check_stmt = $conn->prepare("SELECT id FROM payments WHERE national_id = ? AND is_verified = 0 AND created_at > DATE_SUB(NOW(), INTERVAL 10 MINUTE)");
        $check_stmt->bind_param("s", $national_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            error_log("Updating existing payment record");
            // Update existing record
            $stmt = $conn->prepare("UPDATE payments SET verification_code = ?, created_at = NOW() WHERE national_id = ? AND is_verified = 0");
            $stmt->bind_param("ss", $otp, $national_id);
        } else {
            error_log("Creating new payment record");
            // Insert new record
            $stmt = $conn->prepare("INSERT INTO payments (national_id, payment_method, send_method, contact_value, verification_code) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $national_id, $payment_method, $send_method, $contact_value, $otp);
        }
        
        if ($stmt->execute()) {
            error_log("Database operation successful");
            $success = false;
            // Send OTP based on method
            if ($send_method === "email") {
                $success = sendOTPEmail($contact_value, $otp);
            } else if ($send_method === "sms") {
                $success = sendOTPSMS($contact_value, $otp);
            }
            
            if ($success) {
                echo "✅ OTP sent successfully to your " . $send_method . "!";
            } else {
                echo "❌ Failed to send OTP via " . $send_method . ".";
            }
        } else {
            error_log("Database operation failed: " . $stmt->error);
            echo "❌ Failed to record payment information.";
        }
    }
    
    if (isset($_POST['verify_otp'])) {
        $national_id = $_SESSION['national_id'];
        $otp = $_POST['otp'];
        
        error_log("Verifying OTP for: " . $national_id);
        
        // Verify OTP
        $stmt = $conn->prepare("SELECT * FROM payments WHERE national_id = ? AND verification_code = ? AND is_verified = 0 AND created_at > DATE_SUB(NOW(), INTERVAL 10 MINUTE) ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param("ss", $national_id, $otp);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            error_log("OTP verified successfully");
            // Mark payment as verified
            $stmt = $conn->prepare("UPDATE payments SET is_verified = 1 WHERE national_id = ? AND verification_code = ?");
            $stmt->bind_param("ss", $national_id, $otp);
            $stmt->execute();
            
            echo "✅ OTP verified successfully!";
        } else {
            error_log("Invalid or expired OTP");
            echo "❌ Invalid or expired OTP.";
        }
    }
}
?> 