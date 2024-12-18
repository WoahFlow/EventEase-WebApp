<?php
session_start();  // Start session to access the logged-in user

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['user'])) {
    header("Location: Login-Signup.php");
    exit;
}

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();  // Destroy the session when logout is triggered
    header("Location: Login-Signup.php");  // Redirect to login page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Events List</title>
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
        }
        .content {
            margin-left: 200px;
            padding: 20px;
            margin-top: 80px;
            overflow-y: auto;
            flex: 1;
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
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="Admin Audits.php"><i class="fa fa-file"></i> Audits</a>
        <a href="Admin History.html"><i class="fa fa-history"></i> History</a>
        <a href="Admin Events List.php" class="active"><i class="fa fa-calendar"></i> Events</a>
        <a href="Admin Accounts.php"><i class="fa fa-users"></i> Accounts</a>
        <a href="Settings.html"><i class="fa fa-cog"></i> Settings</a>
    </div>

    <div class="topnav">
        <h4>Welcome, <?php echo $_SESSION['user']['name']; ?>!</h4> <!-- Displaying user's name -->
        <a href="?logout=true">
            <i class="fa fa-sign-out logout-icon"></i>
        </a>
    </div>

    <main class="content">
        <h2 class="text-center mb-4">Admin Events List</h2>

        <!-- Create Event Form -->
        <div class="mb-4">
            <h4>Create Event</h4>
            <form method="POST" action="create-event.php" onsubmit="return confirm('Are you sure you want to create this event?');">
                <div class="form-group">
                    <label for="eventName">Event Name:</label>
                    <input type="text" class="form-control" id="eventName" name="eventName" required>
                </div>
                <div class="form-group">
                    <label for="eventDate">Date and Time:</label>
                    <input type="datetime-local" class="form-control" id="eventDate" name="eventDate" required>
                </div>
                <div class="form-group">
                    <label for="eventAmount">Amount/Price:</label>
                    <input type="number" class="form-control" id="eventAmount" name="eventAmount" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Event</button>
            </form>
        </div>

        <!-- Events Table -->
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date and Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th>Changed by</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection
                    $conn = new mysqli('localhost', 'root', '', 'eventease');

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM events";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['eventname']}</td>
                                <td>{$row['eventdateandtime']}</td>
                                <td>P{$row['eventprice']}</td>
                                <td>{$row['eventstatus']}</td>
                                <td>
                                    <button class='btn btn-sm btn-warning'>Edit</button>
                                    <button class='btn btn-sm btn-danger'>Delete</button>
                                </td>
                                <td>{$row['eventchangedby']}</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No events found.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
