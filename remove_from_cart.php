<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "dbecomm");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $username = $_SESSION['username'];

    // Remove the product from the cart in the database
    $removeQuery = "DELETE FROM tblcart WHERE id = '$index' AND username = '$username'";
    $removeResult = $mysqli->query($removeQuery);

    if ($removeResult) {
        // Fetch the updated cart data for the current user from the database
        $cartQuery = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image, p.category
                      FROM tblcart c
                      INNER JOIN products p ON c.product_id = p.id
                      WHERE c.username = '$username'";
        $cartResult = $mysqli->query($cartQuery);

        if ($cartResult) {
            $cart = $cartResult->fetch_all(MYSQLI_ASSOC);

            // Send the updated cart data as a response
            echo json_encode($cart);
            exit();
        } else {
            // If there is an error fetching the updated cart data, send an error response
            echo "error";
            exit();
        }
    } else {
        // If there is an error removing the product from the cart, send an error response
        echo "error";
        exit();
    }
}
?>
