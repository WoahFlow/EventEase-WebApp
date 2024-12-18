<?php
header("Content-Type: application/json");

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP
$dbname = "eventease";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

// Get input data
$data = json_decode(file_get_contents("php://input"), true);

$email = $conn->real_escape_string($data['email']);
$password = $conn->real_escape_string($data['password']);

// Validate input
if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

// Check user credentials
$sql = "SELECT password FROM accounts WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        echo json_encode(["success" => true, "message" => "Login successful."]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "User not found."]);
}

// Close the connection
$conn->close();
?>
