<?php
session_start();

$host = "localhost";
$username = "root";
$password = "Auca@123";
$dbname = "online_driving_permit";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $national_id = $_POST['national_id'];
    $full_name   = $_POST['full_name'];
    $sex         = $_POST['sex'];
    $dob         = $_POST['dob'];
    $address     = $_POST['address'];
    $phone       = $_POST['phone'];

    $valid = true;
    $errors = [];

    if (!preg_match("/^[0-9]{16}$/", $national_id)) {
        $errors[] = "National ID must be exactly 16 digits.";
        $valid = false;
    }

    $today = new DateTime();
    $birthDate = new DateTime($dob);
    $age = $today->diff($birthDate)->y;
    if ($age < 18) {
        $errors[] = "You must be at least 18 years old.";
        $valid = false;
    }

    if (!preg_match("/^[0-9]{10,}$/", $phone)) {
        $errors[] = "Phone number must be at least 10 digits.";
        $valid = false;
    }

    if ($valid) {
        // Check if national_id already exists
        $check = $conn->prepare("SELECT national_id FROM personal_info WHERE national_id = ?");
        $check->bind_param("s", $national_id);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {
            // Already exists, go to next step
            $_SESSION['national_id'] = $national_id;
            header("Location: application1.html");
            exit();
        }
        $check->close();

        // Insert new record
        $stmt = $conn->prepare("INSERT INTO personal_info (national_id, full_name, sex, dob, address, phone) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $national_id, $full_name, $sex, $dob, $address, $phone);

        if ($stmt->execute()) {
            $_SESSION['national_id'] = $national_id;
            header("Location: application1.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "<ul style='color:red;'>";
        foreach ($errors as $err) {
            echo "<li>$err</li>";
        }
        echo "</ul>";
        echo "<a href='application.html'>Go Back</a>";
    }

    $conn->close();
}
?>
