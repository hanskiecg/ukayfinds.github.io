<?php
$productId = $_POST['productId'];

$mysqli = new mysqli("localhost", "root", "", "dbecomm");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT * FROM products WHERE id = '$productId'";
$result = $mysqli->query($query);

if ($result && $result->num_rows === 1) {
    $product = $result->fetch_assoc();
    echo json_encode($product);
} else {
    echo json_encode(['error' => 'Product not found']);
}

$mysqli->close();
?>
