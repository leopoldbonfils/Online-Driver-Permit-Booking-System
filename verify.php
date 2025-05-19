<?php
$conn = new mysqli("localhost", "root", "Auca@123", "online_driving_permit");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Step 1: Check if token exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    // Step 2: If token is valid, update verification and redirect
    if ($result->num_rows === 1) {
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1, token = NULL WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // ✅ Redirect to index.php
            header("Location: signin.html");
            exit();
        } else {
            echo "❌ Something went wrong during verification.";
        }
    } else {
        echo "❌ Invalid or expired token.";
    }
} else {
    echo "❌ No verification token provided.";
}
?>
