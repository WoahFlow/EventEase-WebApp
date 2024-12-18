<?php
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_unset(); // Clear session variables
    session_destroy(); // Destroy the session
    header('Location: Login-Signup.php'); // Redirect to the login page
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: Login-Signup.php'); // Redirect to login if not logged in
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'eventease'); // Replace with your database name
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event data for charts
$barChartData = [];
$pieChartData = [];
$pieLabels = ['Upcoming', 'Ongoing', 'Completed'];

// Bar chart data: Count of events per month
$sqlBar = "SELECT MONTH(eventdateandtime) AS month, COUNT(*) AS total 
           FROM events 
           GROUP BY MONTH(eventdateandtime)";
$resultBar = $conn->query($sqlBar);
if ($resultBar->num_rows > 0) {
    while ($row = $resultBar->fetch_assoc()) {
        $barChartData[] = $row['total'];
    }
}

// Pie chart data: Count of events by status
foreach ($pieLabels as $status) {
    $sqlPie = "SELECT COUNT(*) AS total FROM events WHERE eventstatus = '$status'";
    $resultPie = $conn->query($sqlPie);
    $row = $resultPie->fetch_assoc();
    $pieChartData[] = $row['total'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
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
        .sidebar a:hover {
            background-color: #007bff;
            color: white;
            transform: translateX(1px);
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }
        .sidebar a i {
            margin-right: 20px;
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
        .chart-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 20px;
        }
        .chart {
            flex: 1;
            max-width: 45%;
            position: relative;
            margin-left: 20px;
            margin-top: 10px;
        }
        </style>
</head>
<body>
    <div class="topnav">
        <h4>Welcome, <?php echo $_SESSION['user']['name']; ?>!</h4> <!-- Displaying user's name -->
        <a href="?logout=true">
            <i class="fa fa-sign-out logout-icon"></i>
        </a>
    </div>
    <div class="sidebar">
        <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="Admin Audits.php"><i class="fa fa-file"></i> Audits</a>
        <a href="Admin History.html"><i class="fa fa-history"></i> History</a>
        <a href="Admin Events List.php"><i class="fa fa-calendar"></i> Events</a>
        <a href="Admin Accounts.php"><i class="fa fa-users"></i> Accounts</a>
        <a href="Settings.html"><i class="fa fa-cog"></i> Settings</a>
    </div>
    <main class="content">
        <div class="d-flex justify-content-between">
            <div class="card custom-color text-center" onclick="location.href='accounts.html'">
                <div class="card-body">
                    <h5 class="card-title">Total of Accounts</h5>
                </div>
            </div>
            <div class="card bg-success text-center" onclick="location.href='sales.html'">
                <div class="card-body">
                    <h5 class="card-title">Total of Sales</h5>
                </div>
            </div>
            <div class="card bg-info text-center" onclick="location.href='events.html'">
                <div class="card-body">
                    <h5 class="card-title">Active Events</h5>
                </div>
            </div>
        </div>
        <div class="chart-container mt-4">
            <div class="chart">
                <canvas id="barChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </main>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Number of Events',
                    data: <?php echo json_encode($barChartData); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($pieLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($pieChartData); ?>,
                    backgroundColor: ['#36A2EB', '#4BC0C0', '#FFCE56']
                }]
            }
        });
    </script>
</body>
</html>