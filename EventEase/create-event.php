<?php
// Create a connection to the database
$conn = new mysqli('localhost', 'root', '', 'eventease');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventAmount = $_POST['eventAmount'];

    // Insert event data into the database
    $sql = "INSERT INTO events (eventname, eventdateandtime, eventprice, eventstatus, eventchangedby) 
            VALUES ('$eventName', '$eventDate', '$eventAmount', 'Active', 'Admin')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Event created successfully!');</script>";
        echo "<script>window.location.href = 'Admin Events List.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Close the connection
$conn->close();
?>
