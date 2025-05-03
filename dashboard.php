<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver's Permit/License Renewal Dashboard</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-gray: #ecf0f1;
            --dark-gray: #7f8c8d;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        h1 {
            font-size: 28px;
            font-weight: 600;
        }
        
        h2 {
            font-size: 22px;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
        }
        
        .sidebar {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .nav-menu {
            list-style: none;
        }
        
        .nav-menu li {
            margin-bottom: 15px;
        }
        
        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--primary-color);
            padding: 8px;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .nav-menu a:hover, .nav-menu a.active {
            background-color: var(--light-gray);
            color: var(--secondary-color);
        }
        
        .nav-menu i {
            width: 24px;
            text-align: center;
        }
        
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: var(--light-gray);
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stat-label {
            color: var(--dark-gray);
        }
        
        .guidelines-list {
            margin-left: 20px;
            margin-bottom: 30px;
        }
        
        .guidelines-list li {
            margin-bottom: 15px;
        }
        
        .warning-box {
            border-left: 4px solid var(--accent-color);
            background-color: #fdeaea;
            padding: 15px;
            margin: 20px 0;
        }
        
        .warning-title {
            color: var(--accent-color);
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .note-box {
            background-color: #fff8e6;
            border-left: 4px solid var(--warning-color);
            padding: 15px;
            margin: 20px 0;
            font-weight: bold;
        }
        
        .application-status {
            margin-top: 20px;
        }
        
        .status-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .status-info {
            display: flex;
            flex-direction: column;
        }
        
        .status-date {
            color: var(--dark-gray);
            font-size: 14px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        hr {
            border: 0;
            height: 1px;
            background-color: #ddd;
            margin: 30px 0;
        }
        
        .btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <h1>Online Driver's Permit/License Renewal System</h1>
            <div class="user-info">
                <div class="user-avatar">JD</div>
                <span>John Doe</span>
            </div>
        </div>
    </header>
    
    <main class="container">
        <div class="dashboard-grid">
            <aside class="sidebar">
                <ul class="nav-menu">
                    <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-file-alt"></i> New Application</a></li>
                    <li><a href="#"><i class="fas fa-history"></i> Application History</a></li>
                    <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="#"><i class="fas fa-question-circle"></i> Help</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
                
                <div class="application-status">
                    <h3>Current Application</h3>
                    <div class="status-item">
                        <div class="status-info">
                            <strong>Driver's License Renewal</strong>
                            <span class="status-date">Submitted: 2025-04-25</span>
                        </div>
                        <span class="status-badge status-pending">Pending</span>
                    </div>
                </div>
                
                <a href="#" class="btn btn-block" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i> Start New Application
                </a>
            </aside>
            
            <div class="main-content">
                <section class="card">
                    <h2>Quick Stats</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <i class="fas fa-clock fa-2x" style="color: var(--warning-color);"></i>
                            <div class="stat-value">2</div>
                            <div class="stat-label">Pending Applications</div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-check-circle fa-2x" style="color: var(--success-color);"></i>
                            <div class="stat-value">5</div>
                            <div class="stat-label">Approved Licenses</div>
                        </div>
                        <div class="stat-card">
                            <i class="fas fa-exclamation-triangle fa-2x" style="color: var(--accent-color);"></i>
                            <div class="stat-value">1</div>
                            <div class="stat-label">Rejected Applications</div>
                        </div>
                    </div>
                </section>
                
                <section class="card">
                    <h2>Renewal Guidelines</h2>
                    
                    <ol class="guidelines-list">
                        <li>Online Drivers Permit/License Renewal applications can only be submitted before the listed expiry date.</li>
                        <li>Newly renamed driver licensees might experience delays in email delivery notifications.</li>
                        <li>Ensure all payment amounts are correct before submission as changes may require office contact.</li>
                        <li>Customers selecting "Collect at Receiving Center" must collect their license within 14 days or it will be returned to the Central Licensing office.</li>
                        <li>Change of licensee address details are currently not available for online processing.</li>
                    </ol>
                    
                    <hr>
                    
                    <div class="note-box">
                        PLEASE NOTE: INCOMPLETE APPLICATIONS WILL NOT BE ACCEPTED.
                    </div>
                    
                    <div class="warning-box">
                        <div class="warning-title">WARNING TO ALL APPLICANTS AND REPRESENTATIVES:</div>
                        <p>Any person who makes a written or oral statement knowingly to be false or misleading is guilty of an offence and is liable to be subject to imprisonment.</p>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>