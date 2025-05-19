<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'leopordbonfils@gmail.com';
    // Enter the new App Password you just generated
    $mail->Password = 'ENTER_NEW_APP_PASSWORD_HERE'; // Replace this with the new 16-character password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    
    // Disable SSL verification
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    // Recipients
    $mail->setFrom('leopordbonfils@gmail.com', 'Test');
    $mail->addAddress('leopordbonfils@gmail.com');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email ' . date('Y-m-d H:i:s');
    $mail->Body    = 'This is a test email sent at ' . date('Y-m-d H:i:s');

    $mail->send();
    echo '<div style="color: green; padding: 10px; margin: 10px 0; border: 1px solid green;">Message has been sent successfully!</div>';
} catch (Exception $e) {
    echo '<div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red;">';
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo '</div>';
}
?> 