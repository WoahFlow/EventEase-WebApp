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

$fullname = $conn->real_escape_string($data['fullname']);
$email = $conn->real_escape_string($data['email']);
$contactnumber = $conn->real_escape_string($data['contactnumber']);
$password = $conn->real_escape_string($data['password']);

// Validate input
if (empty($fullname) || empty($email) || empty($contactnumber) || empty($password)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Invalid email format."]);
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert into database
$sql = "INSERT INTO accounts (fullname, email, contactnumber, password) VALUES ('$fullname', '$email', '$contactnumber', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Account created successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

// Close the connection
$conn->close();
?>
