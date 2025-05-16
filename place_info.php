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

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['national_id'])) {
        die("No personal info found. Please start from the beginning.");
    }

    $national_id = $_SESSION['national_id']; // Link this to the user

    $category    = $_POST["category"] ?? '';
    $district    = $_POST["district"] ?? '';
    $test_date   = $_POST["test_date"] ?? '';
    $test_time   = $_POST["test_time"] ?? '';
    $test_place  = $_POST["test_place"] ?? '';

    // Validation
    if (empty($category)) $errors[] = "Please select a category.";
    if (empty($district)) $errors[] = "Please select a district.";
    if (empty($test_date)) $errors[] = "Please enter the date.";
    if (empty($test_time)) $errors[] = "Please select the time.";
    if (empty($test_place)) $errors[] = "Please select the place.";

    if (empty($errors)) {
        // Optional: Check if entry for this national_id already exists
        $check = $conn->prepare("SELECT * FROM place_info WHERE national_id = ?");
        $check->bind_param("s", $national_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            // Skip inserting, redirect to summary
            header("Location: summary.php");
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO place_info (national_id, category, district, test_date, test_time, test_place) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $national_id, $category, $district, $test_date, $test_time, $test_place);

        if ($stmt->execute()) {
            header("Location: summary.php");
            exit();
        } else {
            echo "Database error: " . $stmt->error;
        }

        $stmt->close();
        $check->close();
    } else {
        echo "<ul style='color:red;'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "<a href='application1.html'>Go Back</a>";
    }
}

$conn->close();
?>
