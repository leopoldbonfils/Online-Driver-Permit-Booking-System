<?php
session_start();

// Check if national_id exists
if (!isset($_SESSION['national_id'])) {
    die("Session expired. Please start again.");
}

$national_id = $_SESSION['national_id'];

// Database connection
$conn = new mysqli("localhost", "root", "Auca@123", "online_driving_permit");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form Handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'] ?? '';
    $send_method = $_POST['send_method'] ?? '';
    $contact_value = ($send_method === 'email') ? trim($_POST['email_value']) : trim($_POST['phone_value']);

    $errors = [];
    if (!$payment_method) $errors[] = "Choose a payment method.";
    if (!$send_method) $errors[] = "Choose how to receive the payment code.";
    if ($send_method === 'email' && !filter_var($contact_value, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if ($send_method === 'phone' && !preg_match('/^\d{10,}$/', $contact_value)) {
        $errors[] = "Invalid phone number.";
    }

    if (!empty($errors)) {
        foreach ($errors as $e) echo "<p style='color:red;'>$e</p>";
        echo "<a href='application3.html'>Back</a>";
        exit();
    }

    $payment_code = rand(100000, 999999);

    $stmt = $conn->prepare("INSERT INTO payments (national_id, payment_method, send_method, contact_value, payment_code) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $national_id, $payment_method, $send_method, $contact_value, $payment_code);

    if ($stmt->execute()) {
        header("Location: payment_success.html");
            exit();
       
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
