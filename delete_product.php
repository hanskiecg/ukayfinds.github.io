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

// Retrieve the product ID from the URL
$id = $_GET['id'];

// Delete the product from the database
$mysqli->query("DELETE FROM products WHERE id='$id'");

// Redirect back to products.php after deleting the product
header("Location: products.php");
exit();
?>
