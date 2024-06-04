<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Login Form</title>

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
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 10%;
            margin-top: 5%;
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

        .container .forgot-password {
            text-align: right;
            margin-top: 10px;
        }

        .container .login-btn {
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login_form">
            <h2>Login</h2>
            <form method="POST" action="check.php">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>

                <label class="checkbox-label">
                    <input type="checkbox" name="remember_me">
                    Remember Me
                </label>

                <input type="submit" value="Login">
                <div class="login-btn">
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                </div>
            </form>

            
        </div>
    </div>
</body>
</html>
