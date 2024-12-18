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
// Include your database connection file
include('db.php');

// Fetch accounts from the "accounts" table
$query = "SELECT * FROM accounts";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Accounts</title>
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
        <a href="Admin Accounts.php"><i class="fa fa-users"></i> Accounts</a>
        <a href="#"><i class="fa fa-cog"></i> Settings</a>
    </div>
    
    <div class="topnav">
        <h4>Welcome, <?php echo $_SESSION['user']['name']; ?>!</h4> <!-- Displaying user's name -->
        <a href="?logout=true">
            <i class="fa fa-sign-out logout-icon"></i>
        </a>
    </div>

    <main class="content">
        <h2 class="text-center mb-4">Admin Accounts</h2>
        <div class="container">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($result)) {
                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['fullname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['contactnumber']) . "</td>";
                                echo "<td>
                                        <button class='btn btn-warning btn-sm' onclick='showEditModal(" . htmlspecialchars(json_encode($row)) . ")'>Edit</button>
                                        <button class='btn btn-danger btn-sm' onclick='showDeleteModal(" . htmlspecialchars($row['id']) . ")'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No accounts found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" action="edit-account-action.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editAccountId">
                        <div class="form-group">
                            <label for="editFullName">Full Name</label>
                            <input type="text" class="form-control" id="editFullName" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editContactNumber">Contact Number</label>
                            <input type="text" class="form-control" id="editContactNumber" name="contactnumber" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm" method="POST" action="delete-account-action.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="deleteAccountId">
                        <p>Are you sure you want to delete this account?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showEditModal(account) {
            document.getElementById("editAccountId").value = account.id;
            document.getElementById("editFullName").value = account.fullname;
            document.getElementById("editEmail").value = account.email;
            document.getElementById("editContactNumber").value = account.contactnumber;
            $('#editModal').modal('show');
        }

        function showDeleteModal(accountId) {
            document.getElementById("deleteAccountId").value = accountId;
            $('#deleteModal').modal('show');
        }
    </script>
</body>
</html>
