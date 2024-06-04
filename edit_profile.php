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

$username = $_SESSION['username'];
$query = "SELECT * FROM tblregusers WHERE username = '$username'";
$result = $mysqli->query($query);

if ($result->num_rows !== 1) {
    header("Location: login.php");
    exit();
}

$row = $result->fetch_assoc();
$img = $row['image'];
$email = $row['email'];
$password = $row['password'];
// Retrieve other necessary user information here

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
                $updateQuery = "UPDATE tblregusers SET username = '$newUsername', email = '$newEmail', image = '$destination' WHERE username = '$username'";
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
        $updateQuery = "UPDATE tblregusers SET username = '$newUsername', email = '$newEmail' WHERE username = '$username'";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/0c7a3095b5.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Edit Profile</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
        }

        .user-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .user-container h1 {
            margin-top: 0;
            color: #884a39;
            font-size: 24px;
            text-align: center;
        }

        .user-container img {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            display: block;
            border-radius: 50%;
        }

        .user-container label {
            display: inline-block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #000;
        }

        .user-container input[type="file"],
        .user-container input[type="password"],
        .user-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .user-container button,
        .user-container a {
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .user-container button {
            background-color: #884a39;
        }

        .user-container a {
            background-color: #c38154;
        }

        .user-container button:hover,
        .user-container a:hover {
            background-color: #ffc26f;
            color: #884a39;
        }

        .user-container p {
            color: #c38154;
            margin-top: 10px;
            text-align: center;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="user-container">
            <h1>Edit Profile</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    <img src="<?php echo $img; ?>" alt="Profile Image" width="50" height="50">
                    <input type="file" class="form-control-file" name="profile_image">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" >
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" >
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" >
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="homepage.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</body>
</html>
