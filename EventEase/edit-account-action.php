<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $contactnumber = $_POST['contactnumber'];

    $query = "UPDATE accounts SET fullname = :fullname, email = :email, contactnumber = :contactnumber WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contactnumber', $contactnumber);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Account updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating account.');</script>";
    }

    echo "<script>window.location.href = 'Admin Accounts.php';</script>";
}
?>
