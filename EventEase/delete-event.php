<?php
// Create a connection to the database
$conn = new mysqli('localhost', 'root', '', 'eventease');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventId = $_POST['eventId'];

    // Delete event from the database
    $sql = "DELETE FROM events WHERE id = '$eventId'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Event deleted successfully!');</script>";
        echo "<script>window.location.href = 'Admin Events List.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Close the connection
$conn->close();
?>
