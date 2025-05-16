<?php
session_start();

if (!isset($_SESSION['national_id'])) {
    die("Session expired. Please go back and fill the application again.");
}

$national_id = $_SESSION['national_id'];

$payment_method = $_POST['payment_method'] ?? '';
$send_method = $_POST['send_method'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$verification_code = $_POST['verification_code'] ?? '';

if (empty($payment_method) || empty($send_method) || empty($verification_code)) {
    die("Missing required fields.");
}

$host = "localhost";
$username = "root";
$password = "Auca@123";  // Replace if different
$dbname = "online_driving_permit";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO payments (national_id, payment_method, send_method, email, phone, verification_code) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $national_id, $payment_method, $send_method, $email, $phone, $verification_code);

if ($stmt->execute()) {
    echo "Payment submitted successfully. You may now wait for confirmation.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
