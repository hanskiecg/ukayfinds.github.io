<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "dbecomm");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$username = $_SESSION['username'];

$query = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image, p.category
          FROM tblcart c
          INNER JOIN products p ON c.product_id = p.id
          WHERE c.username = '$username'";

$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td><img src="' . $row['image'] . '" alt="' . $row['name'] . '" width="50"></td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>₱' . number_format($row['price'], 2) . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>₱' . number_format($row['price'] * $row['quantity'], 2) . '</td>';
        echo '<td><button class="btn btn-sm btn-danger btn-remove-from-cart" data-index="' . $row['id'] . '">Remove</button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No items in the cart.</td></tr>';
}

$mysqli->close();
?>
