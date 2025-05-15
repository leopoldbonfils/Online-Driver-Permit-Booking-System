<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files from your folder
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
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com';        // Replace with your Gmail
            $mail->Password = 'tnbrqdutvufqduji';     // Use Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer'       => true,
                    'verify_peer_name'  => true,
                    'allow_self_signed' => false,
                    'cafile'            => 'C:/xampp/php/extras/ssl/cacert.pem'
                )
            );

            // Sender and recipient
            $mail->setFrom('your_email@gmail.com', 'Driving Permit System ');
            $mail->addAddress($email, $username);

            // Email content
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
