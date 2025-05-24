<?php

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
            
            
            <div class="button-container">
                <button class="print-btn" onclick="printDocument()">
                    <i class="print-icon">🖨️</i> Print Document
                </button>
            </div>
        </div>
        
        <script>
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('resultCard').style.display = 'block';
            
            function closeModal() {
                document.getElementById('resultCard').style.animation = 'fadeOut 0.3s';
                document.getElementById('overlay').style.animation = 'fadeOut 0.3s';
                
                setTimeout(function() {
                    document.getElementById('resultCard').style.display = 'none';
                    document.getElementById('overlay').style.display = 'none';
                
                    window.history.back();
                }, 300);
            }
            
            
            function printDocument() {
                
                const printWindow = window.open('', '_blank');
                
        
                let printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Driving Permit Application Details</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            margin: 20px;
                        }
                        .print-header {
                            text-align: center;
                            margin-bottom: 20px;
                            border-bottom: 2px solid #333;
                            padding-bottom: 10px;
                        }
                        h1 {
                            color: #1a5276;
                            font-size: 24px;
                            margin-bottom: 5px;
                        }
                        h2 {
                            color: #1a5276;
                            font-size: 18px;
                            margin-top: 15px;
                            margin-bottom: 8px;
                            border-bottom: 1px solid #eee;
                            padding-bottom: 5px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 15px;
                        }
                        th, td {
                            text-align: left;
                            padding: 8px;
                            border-bottom: 1px solid #ddd;
                        }
                        th {
                            width: 30%;
                            color: #1a5276;
                            font-weight: 600;
                        }
                        .footer {
                            margin-top: 30px;
                            text-align: center;
                            font-size: 12px;
                            color: #777;
                            border-top: 1px solid #ddd;
                            padding-top: 10px;
                        }
                    </style>
                </head>
                <body>
                    <div class="print-header">
                        <h1>Driving Permit Application Details</h1>
                        <p>Date Printed: ${new Date().toLocaleDateString()}</p>
                    </div>
                    
                    <h2>Personal Information</h2>
                    <table>
                        <tr><th>National ID</th><td>${<?= json_encode(htmlspecialchars($data['national_id'])) ?>}</td></tr>
                        <tr><th>Full Name</th><td>${<?= json_encode(htmlspecialchars($data['full_name'])) ?>}</td></tr>
                        <tr><th>Sex</th><td>${<?= json_encode(htmlspecialchars($data['sex'])) ?>}</td></tr>
                        <tr><th>Date of Birth</th><td>${<?= json_encode(htmlspecialchars($data['dob'])) ?>}</td></tr>
                        <tr><th>Address</th><td>${<?= json_encode(htmlspecialchars($data['address'])) ?>}</td></tr>
                        <tr><th>Phone</th><td>${<?= json_encode(htmlspecialchars($data['phone'])) ?>}</td></tr>
                    </table>
                    
                    <h2>Place Information</h2>
                    <table>
                        <tr><th>Category</th><td>${<?= json_encode(htmlspecialchars($data['category'])) ?>}</td></tr>
                        <tr><th>District</th><td>${<?= json_encode(htmlspecialchars($data['district'])) ?>}</td></tr>
                        <tr><th>Test Date</th><td>${<?= json_encode(htmlspecialchars($data['test_date'])) ?>}</td></tr>
                        <tr><th>Test Time</th><td>${<?= json_encode(htmlspecialchars($data['test_time'])) ?>}</td></tr>
                        <tr><th>Test Place</th><td>${<?= json_encode(htmlspecialchars($data['test_place'])) ?>}</td></tr>
                    </table>
                    
                    <div class="footer">
                        <p>This document is a printed version of your driving permit application details.</p>
                    </div>
                </body>
                </html>
                `;
                
                
                printWindow.document.open();
                printWindow.document.write(printContent);
                printWindow.document.close();
                
                
                printWindow.onload = function() {
                    printWindow.print();
            
                };
            }
            
            document.getElementById('overlay').addEventListener('click', closeModal);
        </script>
        <?php
    } else {
        echo "<p class='error-message'>No matching record found. Please check your information and try again.</p>";
    }
    
    $conn->close();
}
?>

<style>
.card1 {
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 8px;
    background-color: white;
    max-width: 600px; 
    width: 90%;
    margin: 50px auto;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    animation: fadeIn 0.3s ease-out;
    display: none; 
    max-height: 80vh; 
    overflow-y: auto; 
}

.card1 table {
    width: 100%;
    margin-top: 15px;
    border-collapse: collapse;
}

.card1 th {
    text-align: left;
    width: 30%;
    padding: 10px 8px; 
    border-bottom: 1px solid #eee;
    color: #1a5276;
    font-weight: 600;
    font-size: 14px; 
}

.card1 td {
    text-align: left;
    padding: 10px 8px; 
    border-bottom: 1px solid #eee;
    font-size: 14px; 
}

.card1 tr:hover {
    background-color: #f5f9fd;
}

.card1 h2 {
    color: #1a5276;
    margin-top: 15px; 
    margin-bottom: 8px; 
    padding-bottom: 8px; 
    border-bottom: 2px solid #eee;
    font-size: 18px; 
}

.card1 h2:first-child {
    margin-top: 0;
}


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
    font-size: 18px; 
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: background-color 0.2s, transform 0.2s;
    z-index: 1001; 
}

.close-btn:hover {
    background-color: #c0392b;
    transform: scale(1.1);
}


.button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.print-btn {
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s, transform 0.1s;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.print-btn:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
}

.print-btn:active {
    transform: translateY(0);
}

.print-icon {
    margin-right: 8px;
    font-size: 18px;
}


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


@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}


@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}


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
    
    .close-btn, .print-btn {
        font-size: 14px;
    }
    
    .close-btn {
        width: 25px;
        height: 25px;
        font-size: 16px;
    }
    
    .print-btn {
        padding: 8px 15px;
    }
}
</style>