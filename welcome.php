<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/0c7a3095b5.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>UKAY FINDS</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('assets/bg/welcome-bg.png'); 
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 20px;
            height: 100px;
            position: absolute;
            margin-top: 2%;
            
        }

        .logo-container img {
            margin-right: 5px;
            width: 200px;
            height: 100px;
            margin-left: 10px;
        }

        .welcome-text h1{
            text-align: center;
            margin-top: 15%;
            display: flex;
            justify-content: flex-start;
            margin-left: 10%;
            font-family: 'Caprasimo', cursive;
            font-size: 2.5em;
            color: #884a39;
            
        }

        .desc {
            text-align: center;
            display: flex;
            justify-content: flex-start;
            margin-left: 11%;
            font-size: 1em;
        }
        .signup-login-buttons {
            display: flex;
            justify-content: flex-start;
            margin-top: 30px;
        }

        .signup-button {
            margin-left: 20%;
            background-color: #884a39;

        }

        .signup-button:hover {
            margin-left: 20%;
            background-color: #ffc26f;
            color: #884a39;
        }

        .login-button {
            margin-left: 2%;
            background-color: #c38154;
        }

        .login-button:hover {
            margin-left: 2%;
            background-color: #ffc26f;
            color: #884a39;
        }

        /* Styles for desktop screens */
        @media (min-width: 1024px) {
            /* Adjust styles for larger screens */
        }

        /* Styles for tablet screens */
        @media (min-width: 768px) and (max-width: 1023px) {
            /* Adjust styles for tablets */
        }

        /* Styles for mobile screens */
        @media (max-width: 767px) {
            /* Adjust styles for smaller screens */
        }

    </style>

</head>
<body>
    <div class="container">
        <div class="logo-container">
            <a class="navbar-brand" href="welcome.php">
                <img src="assets/logo/logo.png" alt="Logo">
            </a>
        </div>
    </div><br>
    <div class="welcome-text">
        <h1>Welcome to UKAY FINDS</h1>
    </div>
    <div class="desc">
        <p>Your ultimate destination for affordable and sustainable<br>
            thrift shopping, where you can uncover unique fashion<br>
            treasures while reducing your environmental footprint.</p>
    </div>
    <div class="signup-login-buttons">
        <a href="signup.php" class="btn btn-primary signup-button">Sign Up</a>
        <a href="login.php" class="btn btn-secondary login-button">Log In</a>
    </div>
</body>
</html>
