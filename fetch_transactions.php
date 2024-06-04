<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "dbecomm");

$username = $_SESSION['username'];

// Fetch the transaction history for the current user from the tblorders table
$query = "SELECT * FROM tblorders WHERE id = (SELECT id FROM tblregusers WHERE username = '$username')";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['transaction_id'] . '</td>
                <td>' . $row['product_name'] . '</td>
                <td>' . $row['price'] . '</td>
                <td>' . $row['quantity'] . '</td>
                <td>' . $row['total'] . '</td>
                <td>' . $row['date'] . '</td>
              </tr>';
    }
} else {
    echo '<tr>
            <td colspan="6">No transaction history found.</td>
          </tr>';
}

$mysqli->close();
?>
