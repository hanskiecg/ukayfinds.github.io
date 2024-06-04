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

// Initialize the message variable
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle image upload if a new image is selected
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "assets/profile/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $allowedExtensions)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $img = $targetFile;

                // Update the admin image in the database
                $updateImageQuery = "UPDATE tblregusers SET image = '$img' WHERE username = 'admin'";
                $mysqli->query($updateImageQuery);
            }
        }
    }

    // Get the updated values from the form
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Update the admin information in the database
    $updateQuery = "UPDATE tblregusers SET password = ?, email = ? WHERE username = 'admin'";
    $stmt = $mysqli->prepare($updateQuery);
    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();
    $stmt->close();

    // Retrieve the updated admin information from the database
    $result = $mysqli->query("SELECT * FROM tblregusers WHERE username = 'admin'");
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $img = $row['image'];
        $username = $row['username'];
        $password = $row['password'];
        $email = $row['email'];
    }
    
    // Set the message
    $message = "Changes saved successfully!";
}

$result = $mysqli->query("SELECT * FROM tblregusers WHERE username = 'admin'");
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $img = $row['image'];
    $username = $row['username'];
    $password = $row['password'];
    $email = $row['email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Manage Admin</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
        }

        .admin-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .admin-container h1 {
            margin-top: 0;
            color: #884a39;
            font-size: 24px;
            text-align: center;
        }

        .admin-container img {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            display: block;
            border-radius: 50%;
        }

        .admin-container label {
            display: inline-block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #000;
        }

        .admin-container input[type="file"],
        .admin-container input[type="password"],
        .admin-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .admin-container button {
            background-color: #884a39;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .admin-container button:hover {
            background-color: #ffc26f;
            color: #884a39;
        }

        .admin-container a {
            background-color: #c38154;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .admin-container a:hover {
            background-color: #ffc26f;
            color: #884a39;
        }

        .admin-container p {
            color: #c38154;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Manage Admin</h1>
        <img src="<?=$img?>" alt="Admin Image">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image"><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?=$username?>" readonly><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?=$password?>"><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?=$email?>"><br><br>
            <a href="inventory.php" class="back-button">Back</a>
            <button type="submit">Save</button>
            <?php if (!empty($message)): ?>
                <p><?=$message?></p>
            <?php endif; ?>
        </form>
        
    </div>
</body>
</html>
