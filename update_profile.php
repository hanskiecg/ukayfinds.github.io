<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "dbecomm");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newUsername = $_POST["username"];
    $newEmail = $_POST["email"];
    $newPassword = $_POST["password"];

    // Handle profile image upload if necessary
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["size"] > 0) {
        $file = $_FILES["profile_image"];
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileError = $file["error"];

        if ($fileError === UPLOAD_ERR_OK) {
            $destination = "assets/profile/" . $fileName;
            if (move_uploaded_file($fileTmpName, $destination)) {
                $username = $_SESSION['username'];
                $updateQuery = "UPDATE tblregusers SET username = '$newUsername', email = '$newEmail', image = '$destination', password = '$newPassword' WHERE username = '$username'";
                $updateResult = $mysqli->query($updateQuery);

                if ($updateResult) {
                    // Update successful
                    $_SESSION['username'] = $newUsername; // Update session variable if username is changed
                    header("Location: homepage.php");
                    exit();
                } else {
                    // Update failed
                    echo "Failed to update profile. Please try again.";
                }
            } else {
                // Failed to move uploaded file
                echo "Failed to upload profile image. Please try again.";
            }
        } else {
            // File upload error
            echo "Error uploading profile image. Please try again.";
        }
    } else {
        // No profile image uploaded
        $username = $_SESSION['username'];
        $updateQuery = "UPDATE tblregusers SET username = '$newUsername', email = '$newEmail', password = '$newPassword' WHERE username = '$username'";
        $updateResult = $mysqli->query($updateQuery);

        if ($updateResult) {
            // Update successful
            $_SESSION['username'] = $newUsername; // Update session variable if username is changed
            header("Location: homepage.php");
            exit();
        } else {
            // Update failed
            echo "Failed to update profile. Please try again.";
        }
    }
}
?>
