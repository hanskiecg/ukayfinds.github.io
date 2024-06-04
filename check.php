<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $mysqli = new mysqli("localhost", "root", "", "dbecomm");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT * FROM tblregusers WHERE username = '$username'";

    $result = $mysqli->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($password === $row["password"]) {
            $_SESSION["username"] = $username;

            if ($username === "admin") {
                header("Location: inventory.php");
            } else {
                header("Location: homepage.php");
            }
            exit();
        }
    }

    $mysqli->close();

    header("Location: login.php?error=1");
    exit();
}
?>
