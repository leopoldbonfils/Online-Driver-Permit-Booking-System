<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Driver's Permit Booking</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="application2.css">
  <script src="application2.js" defer></script>
</head>
<body>
  <div class="container">
    <h1>Online Driver's Permit Booking</h1>
    
    <div class="progress-steps">
      <div class="step completed" id="step1">
        <div class="step-number"><i class="fas fa-check"></i></div>
        <div class="step-label">Personal Info</div>
      </div>
      <div class="step completed" id="step2">
        <div class="step-number"><i class="fas fa-check"></i></div>
        <div class="step-label">Place Info</div>
      </div>
      <div class="step active" id="step3">
        <div class="step-number">3</div>
        <div class="step-label">Summary</div>
      </div>
      <div class="step">
        <div class="step-number">4</div>
        <div class="step-label">Payment</div>
      </div>
    </div>
    
    <h2>Application Summary</h2>
   
     <div class="section-title">Personal Information</div>
    <table>
        <tr><th>National ID</th><td><?= htmlspecialchars($personal['national_id']) ?></td></tr>
        <tr><th>Full Name</th><td><?= htmlspecialchars($personal['full_name']) ?></td></tr>
        <tr><th>Sex</th><td><?= htmlspecialchars($personal['sex']) ?></td></tr>
        <tr><th>Date of Birth</th><td><?= htmlspecialchars($personal['dob']) ?></td></tr>
        <tr><th>Address</th><td><?= htmlspecialchars($personal['address']) ?></td></tr>
        <tr><th>Phone</th><td><?= htmlspecialchars($personal['phone']) ?></td></tr>
    </table>

    <div class="section-title">Place Information</div>
    <table>
        <tr><th>Category</th><td><?= htmlspecialchars($place['category']) ?></td></tr>
        <tr><th>District</th><td><?= htmlspecialchars($place['district']) ?></td></tr>
        <tr><th>Test Date</th><td><?= htmlspecialchars($place['test_date']) ?></td></tr>
        <tr><th>Test Time</th><td><?= htmlspecialchars($place['test_time']) ?></td></tr>
        <tr><th>Test Place</th><td><?= htmlspecialchars($place['test_place']) ?></td></tr>
    </table>
    <div class="button-group">
      <a href="application1.html">
        <button class="btn btn-back">Back</button>
      </a>
      <a href="application3.html" onclick="markStepCompleted(3)">
        <button class="btn">Continue to Payment</button>
      </a>
    </div>
  </div>
</body>
</html>