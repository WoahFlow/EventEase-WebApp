<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $query = "DELETE FROM accounts WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Account deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting account.');</script>";
    }

    echo "<script>window.location.href = 'Admin Accounts.php';</script>";
}
?>
