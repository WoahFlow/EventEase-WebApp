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
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventAmount = $_POST['eventAmount'];
    $eventStatus = $_POST['eventStatus'];

    // Update event data in the database
    $sql = "UPDATE events 
            SET eventname = '$eventName', 
                eventdateandtime = '$eventDate', 
                eventprice = '$eventAmount', 
                eventstatus = '$eventStatus',
                eventchangedby = 'Admin' 
            WHERE id = '$eventId'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Event updated successfully!');</script>";
        echo "<script>window.location.href = 'Admin Events List.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Close the connection
$conn->close();
?>
