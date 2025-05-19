<?php
// Add this div at the beginning of your file to create the overlay
echo '<div id="overlay" class="overlay"></div>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "Auca@123", "online_driving_permit");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $national_id = $_POST['national_id'] ?? '';
    $full_name = $_POST['full_name'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM personal_info JOIN place_info ON personal_info.national_id = place_info.national_id WHERE personal_info.national_id = ? AND personal_info.full_name = ?");
    $stmt->bind_param("ss", $national_id, $full_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        ?>
        <div class="card1" id="resultCard">
            <button class="close-btn" onclick="closeModal()">&times;</button>
            <h2>Personal Information</h2>
            <table>
                <tr><th>National ID</th><td><?= htmlspecialchars($data['national_id']) ?></td></tr>
                <tr><th>Full Name</th><td><?= htmlspecialchars($data['full_name']) ?></td></tr>
                <tr><th>Sex</th><td><?= htmlspecialchars($data['sex']) ?></td></tr>
                <tr><th>Date of Birth</th><td><?= htmlspecialchars($data['dob']) ?></td></tr>
                <tr><th>Address</th><td><?= htmlspecialchars($data['address']) ?></td></tr>
                <tr><th>Phone</th><td><?= htmlspecialchars($data['phone']) ?></td></tr>
            </table>

            <h2>Place Information</h2>
            <table>
                <tr><th>Category</th><td><?= htmlspecialchars($data['category']) ?></td></tr>
                <tr><th>District</th><td><?= htmlspecialchars($data['district']) ?></td></tr>
                <tr><th>Test Date</th><td><?= htmlspecialchars($data['test_date']) ?></td></tr>
                <tr><th>Test Time</th><td><?= htmlspecialchars($data['test_time']) ?></td></tr>
                <tr><th>Test Place</th><td><?= htmlspecialchars($data['test_place']) ?></td></tr>
            </table>
        </div>
        
        <script>
            // Show overlay and card when results are found
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('resultCard').style.display = 'block';
            
            // Function to close the modal and go back
            function closeModal() {
                document.getElementById('resultCard').style.animation = 'fadeOut 0.3s';
                document.getElementById('overlay').style.animation = 'fadeOut 0.3s';
                
                setTimeout(function() {
                    document.getElementById('resultCard').style.display = 'none';
                    document.getElementById('overlay').style.display = 'none';
                    // Go back to the previous page
                    window.history.back();
                }, 300);
            }
            
            // Close modal when clicking on the overlay
            document.getElementById('overlay').addEventListener('click', closeModal);
        </script>
        <?php
    } else {
        echo "<p class='error-message'>No matching record found. Please check your information and try again.</p>";
    }
    
    // Close the database connection
    $conn->close();
}
?>

<style>
/* Basic styling for card1 */
.card1 {
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 8px;
    background-color: white;
    max-width: 600px; /* Reduced from 800px */
    width: 90%;
    margin: 50px auto;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    animation: fadeIn 0.3s ease-out;
    display: none; /* Initially hidden */
    max-height: 80vh; /* Limit height */
    overflow-y: auto; /* Add scroll if needed */
}

.card1 table {
    width: 100%;
    margin-top: 15px;
    border-collapse: collapse;
}

.card1 th {
    text-align: left;
    width: 30%;
    padding: 10px 8px; /* Reduced padding */
    border-bottom: 1px solid #eee;
    color: #1a5276;
    font-weight: 600;
    font-size: 14px; /* Smaller font */
}

.card1 td {
    text-align: left;
    padding: 10px 8px; /* Reduced padding */
    border-bottom: 1px solid #eee;
    font-size: 14px; /* Smaller font */
}

.card1 tr:hover {
    background-color: #f5f9fd;
}

.card1 h2 {
    color: #1a5276;
    margin-top: 15px; /* Reduced margin */
    margin-bottom: 8px; /* Reduced margin */
    padding-bottom: 8px; /* Reduced padding */
    border-bottom: 2px solid #eee;
    font-size: 18px; /* Smaller heading */
}

.card1 h2:first-child {
    margin-top: 0;
}

/* Close button styling */
.close-btn {
    position: absolute;
    right: 15px;
    top: 15px;
    width: 30px;
    height: 30px;
    background-color: #e74c3c;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px; /* Smaller font */
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s, transform 0.2s;
    z-index: 1001; /* Ensure it's above everything */
}

.close-btn:hover {
    background-color: #c0392b;
    transform: scale(1.1);
}

/* Overlay for dimming the background */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
    animation: fadeIn 0.3s ease-out;
}

/* Animation for fade in effect */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Animation for fade out effect */
@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

/* Error message styling */
.error-message {
    color: #e74c3c;
    background-color: #fde5e4;
    padding: 12px 15px;
    border-radius: 5px;
    margin: 20px auto;
    max-width: 800px;
    text-align: center;
    border-left: 4px solid #e74c3c;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card1 {
        width: 95%;
        padding: 15px;
        margin: 20px auto;
        max-width: 90%;
    }
    
    .card1 th, .card1 td {
        padding: 6px 4px;
        font-size: 13px;
    }
    
    .card1 h2 {
        font-size: 16px;
    }
    
    .close-btn {
        width: 25px;
        height: 25px;
        font-size: 16px;
    }
}
</style>