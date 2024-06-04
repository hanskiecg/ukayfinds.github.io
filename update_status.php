<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    exit('Unauthorized access');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $status = $_POST['status'];

    // Update the status in the database
    $mysqli = new mysqli("localhost", "root", "", "dbecomm");
    $stmt = $mysqli->prepare("UPDATE tblorders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $orderId);
    $stmt->execute();
    $stmt->close();

    // Return a success response
    echo 'success';
} else {
    exit('Invalid request');
}
?>
