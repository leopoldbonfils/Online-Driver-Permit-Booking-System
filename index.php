<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Driver's Permit Booking System</title>
    <link rel="stylesheet" href="index.css" />
</head>
<body>
    <header>
        <div class="container">
            <h1>Online Driver's Permit Booking System</h1>
        </div>
    </header>
    
    <main class="container">
        <section class="card">
            <h2>Apply for a new driver's permit online, click the button below. </h2>
            <a href="application.html">
            <button class="btn">New Application</button>
            </a>
           
        </section>
        
        <section class="card">
            <h2>Find Application</h2>
            <p>Find an existing transmit application using your national Id number and last name.</p>
            
            <table>
                <thead>
                    <tr>
                        <th>National Id Number</th>
                        <th>Last Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" placeholder="Enter national id number"></td>
                        <td><input type="text" placeholder="Enter last name"></td>
                        <td><button class="btn">Find</button></td>
                    </tr>
                     
                   
                </tbody>

            </table>
            <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="renewal-type" checked>
                            <label for="renewal-type">This information is real </label>
                        </div>
                    </div>
        </section>
    </main>
</body>
</html>