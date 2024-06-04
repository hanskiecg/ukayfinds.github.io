<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "dbecomm");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $username = $_SESSION['username'];

    // Check if the product is already in the cart
    $cartQuery = "SELECT * FROM tblcart WHERE username = '$username' AND product_id = '$productId'";
    $cartResult = $mysqli->query($cartQuery);

    if ($cartResult && $cartResult->num_rows > 0) {
        // The product is already in the cart, update the quantity
        $cartItem = $cartResult->fetch_assoc();
        $newQuantity = $cartItem['quantity'] + 1;

        $updateQuery = "UPDATE tblcart SET quantity = $newQuantity WHERE username = '$username' AND product_id = '$productId'";
        $updateResult = $mysqli->query($updateQuery);

        if ($updateResult) {
            $response = array('success' => true, 'message' => 'Product quantity updated');
        } else {
            $response = array('success' => false, 'message' => 'Failed to update product quantity');
        }
    } else {
        // The product is not in the cart, add it
        $insertQuery = "INSERT INTO tblcart (username, product_id, quantity) VALUES ('$username', '$productId', 1)";
        $insertResult = $mysqli->query($insertQuery);

        if ($insertResult) {
            $response = array('success' => true, 'message' => 'Product added to cart');
        } else {
            $response = array('success' => false, 'message' => 'Failed to add product to cart');
        }
    }

    echo json_encode($response);
} else {
    header('Location: homepage.php');
    exit();
}

$mysqli->close();
?>
