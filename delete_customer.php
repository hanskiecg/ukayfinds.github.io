<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['username'] !== 'admin') {
    header("Location: homepage.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "dbecomm");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Delete the user from the database
    $stmt = $mysqli->prepare("DELETE FROM tblregusers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Redirect to the customers page after deletion
header("Location: customers.php");
exit();
?>
