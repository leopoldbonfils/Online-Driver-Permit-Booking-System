<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// DB connection
$conn = new mysqli("localhost", "root", "Auca@123", "online_driving_permit");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token    = bin2hex(random_bytes(16));

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, token) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $token);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'leopordbonfils@gmail.com'; // Your Gmail address
            $mail->Password   = 'lizgsbaaesjtcehj';    // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
            $mail->Port       = 587; // TLS port
            
            // Enable verbose debug output if needed
            // $mail->SMTPDebug = 2;
            
            // Disable SSL verification (not recommended for production)
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients
            $mail->setFrom('leopordbonfils@gmail.com', 'Driving_Permit_System');
            $mail->addAddress($email, $username);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Confirm Your Email';
            $mail->Body    = "Hi <b>$username</b>,<br><br>
                Please click the link below to verify your account:<br>
                <a href='http://localhost/Final/verify.php?token=$token'>Verify Account</a><br><br>
                Thanks!";

            $mail->send();
            echo "✅ Check your email to verify your account.";
        } catch (Exception $e) {
            echo "❌ Email not sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ Something went wrong. Try again.";
    }
}
?>