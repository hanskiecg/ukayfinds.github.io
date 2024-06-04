<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Registration Form</title>

    <style>
        body {
            background-image: url('assets/bg/welcome-bg.png'); 
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 10px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 10%;
        }

        .container h2 {
            text-align: center;
            color: #884a39;
        }

        .container form {
            margin-top: 20px;
        }

        .container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000;
        }

        .container input[type="text"],
        .container input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .container input[type="file"] {
            margin-top: 5px;
        }

        .container input[type="submit"] {
            background-color: #884a39;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .container input[type="submit"]:hover {
            background-color: #ffc26f;
            color: #884a39;
        }

        .container .result {
            margin-top: 20px;
            text-align: center;
            color: #000;
        }

        .container .login-btn {
            text-align: right;
            margin-top: 10px;
        }

        .container .checkbox-label {
            display: block;
            margin-top: 10px;
            color: #000;
        }

        .container .checkbox-label span {
            color: #884a39;
        }
    </style>    
</head>
<body>
    <div class="container">
        <div class="registration-form">
            <h2>Sign Up</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br>
                
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required><br>

                <label for="profile" class="col-4 col-form-label">Upload a Profile Picture (JPEG/JPG or PNG)</label> 
                <div class="col-8">
                    <div class="input-group">
                        <input name="imgprofile" type="file" class="form-control" accept=".jpg,.jpeg,.png" required>
                    </div>
                </div><br>

                <label class="checkbox-label">
                    <input type="checkbox" name="privacy_policy" required>
                    I Agree with <span>privacy</span> and <span style="color: #884a39;">policy</span>.
                </label><br>

                <input type="submit" value="Sign Up">

                
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirm_password = $_POST["confirm_password"];
                $img = $_FILES["imgprofile"]["name"];
                $img_tmp = $_FILES["imgprofile"]["tmp_name"];
                $img_ext = pathinfo($img, PATHINFO_EXTENSION);

                if ($password === $confirm_password) {
                    $mysqli = new mysqli("localhost", "root", "", "dbecomm");

                    if ($mysqli->connect_error) {
                        die("Connection failed: " . $mysqli->connect_error);
                    }

                    $allowed_extensions = array("jpg", "jpeg", "png");
                    if (!in_array($img_ext, $allowed_extensions)) {
                        echo "<div class='result'>Only JPEG/JPG and PNG files are allowed.</div>";
                    } else {
                        $img_destination = "assets/profile/" . $img;
                        move_uploaded_file($img_tmp, $img_destination);

                        $sql = "INSERT INTO tblregusers (username, email, password, image)
                                VALUES ('$username', '$email', '$password', '$img_destination')";
                        if ($mysqli->query($sql) === true) {
                            echo "<div class='result'>Information saved successfully! Please log in.</div>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $mysqli->error;
                        }
                    }

                    $mysqli->close();
                } else {
                    echo "<div class='result'>Password and Confirm Password are not the same.</div>";
                }
            }
            ?>

            <div class="login-btn">
                <p>Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </div>
</body>
</html>