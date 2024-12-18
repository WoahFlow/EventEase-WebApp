<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Audits</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f6ed6ed8b3.js" crossorigin="anonymous"></script>
  
    <style>
        body {
            display: flex;
            flex-direction: column;
            margin: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .topnav {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .topnav h4 {
            margin: 0;
            font-weight: 500;
        }
        .logout-icon {
            font-size: 1.5rem;
            cursor: pointer;
            color: #ffffff;
            transition: color 0.3s;
        }
        .logout-icon:hover {
            color: #ff0000;
        }
        .sidebar {
            width: 200px;
            background-color: #495057;
            position: fixed;
            top: 50px;
            left: 0;
            height: calc(100% - 50px);
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #ffffff;
            text-decoration: none;
            font-size: 1rem;
            margin-bottom: 5px;
            border-radius: 6px;
            transition: all 0.3s ease-in-out;
    
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
            margin-top: 30px;
            overflow-y: auto;
            flex: 1;
        }
        .card {
            margin-bottom: 20px;
            cursor: pointer;
            margin-top: 20px;
        }
        .card.custom-color {
            background-color: #6c757d;
            color: white;
        }
        .card.bg-success {
            background-color: #28a745;
            color: white;
        }
        .card.bg-info {
            background-color: #17a2b8;
            color: white;
        }
        .custom-table {
            margin-top: 20px;
            width: 100%;
            border: 2px solid #343a40;
            border-collapse: collapse;
        }
        .custom-table th, .custom-table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .custom-table th {
            background-color: #343a40;
            color: white;
        }
        .custom-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .custom-table tbody tr:hover {
            background-color: #d6e9f9;
        }
        .sidebar a:hover {
    background-color: #007bff; /* Blue background on hover */
    color: white; /* White text color */
    transform: translateX(1px); /* Moves the link slightly to the right */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Adds a shadow for emphasis */
  
}

.sidebar a i {
    margin-right: 20px;
}

    </style>
</head>
<body>

    <div class="sidebar">
        <a href="dashboard.php" class="active"><i class="fa fa-home"></i> Dashboard</a>
        <a href="Admin Audits.php"><i class="fa fa-file"></i> Audits</a>
        <a href="Admin Events List.php"><i class="fa fa-history"></i> History</a>
        <a href="Admin History.php"><i class="fa fa-calendar"></i> Events</a>
        <a href="#"><i class="fa fa-users"></i> Accounts</a>
        <a href="#"><i class="fa fa-cog"></i> Settings</a>
    </div>
    
    <div class="topnav">
        <h4>Welcome, Admin!</h4>
        <i class="fa fa-sign-out logout-icon" onclick="location.href='#'"></i>
    </div>
    <div class="sidebar">
        <a href="dashboard.php" class="active"><i class="fa fa-home"></i> Dashboard</a>
        <a href="Admin Audits.php"><i class="fa fa-file"></i> Audits</a>
        <a href="#"><i class="fa fa-history"></i> History</a>
        <a href="Admin Events List.php"><i class="fa fa-calendar"></i> Events</a>
        <a href="#"><i class="fa fa-users"></i> Accounts</a>
        <a href="#"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <main class="content">
        <div class="d-flex justify-content-between">
            <div class="card custom-color text-center" onclick="location.href='#'">
                <div class="card-body">
                    <h5 class="card-title">Total of Accounts</h5>
                </div>
            </div>
            <div class="card bg-success text-center" onclick="location.href='#'">
                <div class="card-body">
                    <h5 class="card-title">Total of Sales</h5>
                </div>
            </div>
            <div class="card bg-info text-center" onclick="location.href='#'">
                <div class="card-body">
                    <h5 class="card-title">Active Events</h5>
                </div>
            </div>
        </div>
        <div class="container">
            <h2 class="text-center mb-4">Admin Audits</h2>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
    </main>
    <!-- JavaScript -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
