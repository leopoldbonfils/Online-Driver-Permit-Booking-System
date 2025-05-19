<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Driver's Permit Booking System</title>
   
     <style>
        :root {
            --primary-color: #1a5276;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-gray: #ecf0f1;
            --dark-gray: #7f8c8d;
            --text-color: #2c3e50;
            --header-bg: #1a5276;
            --card-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: var(--header-bg);
            color: white;
            padding: 15px 0;
            width: 100%;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
        }

        .header-title {
            font-size: 22px;
            font-weight: 500;
            margin: 0;
            color: white;
            text-align: center;
            flex-grow: 1;
        }

        .sign-in-link {
            font-size: 16px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.2);
            transition: background-color 0.3s;
        }

        .sign-in-link:hover {
            background-color: rgba(255, 255, 255, 0.3);
            text-decoration: none;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            gap: 30px;
            flex: 1;
        }

        h2 {
            font-size: 20px;
            color: var(--primary-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
        }

        p {
            margin-bottom: 20px;
            color: var(--dark-gray);
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            padding: 35px;
            transition: transform 0.3s, box-shadow 0.3s;
             
            
            width: 900px !important; 
            max-width: 100%; 
            margin-left: auto;
            margin-right: auto;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .form-group {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus, select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .checkbox-group input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
        }

        .btn {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: var(--light-gray);
            font-weight: 600;
            color: var(--primary-color);
        }

        td {
            vertical-align: middle;
        }

        td input {
            margin: 0;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
                max-width: 95%;
            }
            
            .card {
                padding: 20px;
            }
            
            th, td {
                padding: 8px 10px;
            }
            
            .header-title {
                font-size: 18px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            input[type="text"], input[type="password"] {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .header-container {
                flex-direction: column;
                gap: 10px;
            }
            
            .sign-in-link {
                position: static;
            }
            
            th, td {
                padding: 6px 8px;
                font-size: 14px;
            }
            
            .btn {
                width: 100%;
            }
        }


.header-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px 20px;
    background-color: var(--primary-color);
    color: white;
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

.header-title {
    font-size: 24px;
    font-weight: 100%;
    margin: 0;
    color: white;
    text-align: center;
}

.sign-in-link {
    font-size: 16px;
    color: #dcd1f5;
    text-decoration: none;
    font-weight: 500;
    position: absolute;
    right: 20px;
}
.sign-in-link:hover {
    text-decoration: underline;
}

     </style>

</head>
<body>
        <header>
            <div class="header-container">
                <h1 class="header-title">Welcome to the Online Driver's Permit Booking System</h1>
                <a href="signin.html" class="sign-in-link">Sign in</a>
            </div>
       </header>
    
    <div class="container">
        <div class="card">
            <h2>Apply for a new driver's permit online, click the button below. </h2>

            <a href="application.html">
            <button class="btn">New Application</button>
            </a>
           
        </div>
        
        <div class="card">
            <h2>Find Application</h2>
            <p>Find an existing transmit application using your national Id number and full name.</p>
            <form method="POST" action="search.php">
                <table>
                    <thead>
                        <tr>
                            <th>National Id Number</th>
                            <th>full Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            
                                <td><input type="text" name="national_id" placeholder="Enter national id number"></td>
                                <td><input type="text" name="full_name" placeholder="Enter full name"></td>
                                <td><button class="btn">Find</button></td>
                            
                        </tr>
                        
                    
                    </tbody>

                </table>
            </form>
            <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="renewal-type" checked>
                            <label for="renewal-type">This information is real </label>
                        </div>
                    </div>
        </div>
</div>
</body>
</html>