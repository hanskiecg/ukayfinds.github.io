<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['username'] === 'admin') {
    header("Location: inventory.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "dbecomm");

$username = $_SESSION['username'];
$query = "SELECT * FROM tblregusers WHERE username = '$username'";
$result = $mysqli->query($query);

if ($result->num_rows !== 1) {
    header("Location: login.php");
    exit();
}

$row = $result->fetch_assoc();
$img = $row['image'];

// Fetch all products from the database
$result = $mysqli->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);

$mysqli->close();

// Check if the "cart" key is defined and of type array or object
$cart = isset($_SESSION['cart']) && (is_array($_SESSION['cart']) || is_object($_SESSION['cart'])) ? $_SESSION['cart'] : array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/0c7a3095b5.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-y/KcRVRXqGc9Q8GVvtVeQV8gX0fj1ff9qHCpKzDJvZMzX+R29f2dbDHAThD8CwIZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/zoika-font" rel="stylesheet">

    <title>About</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .logo-container img {
            margin-right: 5px;
            width: 200px;
            height: 100px;
        }

        .navbar {
            display: flex;
            justify-content: center;
            width: 100vw;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            font-family: 'Zoika font', sans-serif;
            background-color: #c38154;
                                                
        }

        .navbar-collapse {
            text-align: center;
            background-color: #c38154;
        }

        .navbar-nav .nav-link {
            color: #fff;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #884a39; /* Replace #f00 with your desired hover color */
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            height: 100px; /* Set the desired height for the logo container */
            position: relative;
            margin-top: 2%;
        }

        .navbar-brand {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .navbar-brand img {
            width: 200px; /* Adjust the width as needed */
            height: auto;
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


        h1 {
            margin-bottom: 20px;
            font-family: 'Zoika font', sans-serif;
                                                
        }

        h2 {
            margin-bottom: 20px;
            font-family: 'Caprasimo', cursive;
            font-size: 2.5em;
            color: #884a39;
        }

        p {
            margin-bottom: 20px;
        }

        .member {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .container.about-container {
            max-width: 1000px;
            margin: 0 auto;
            margin-top: 0%;
            margin-bottom: 2%;
            padding: 20px;
            background-color: #fff;
        }

        .about-container h1 {
            margin-bottom: 20px;
            color: #000;
            font-size: 50px;
        }

        .about-container h2 {
            margin-bottom: 20px;
            font-family: 'Caprasimo', cursive;
            font-size: 2.5em;
            color: #884a39;
        }

        .about-container p {
            margin-bottom: 20px;
        }

        .about-container .member {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .about-container .member img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-right: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <a class="navbar-brand" href="homepage.php">
                <img src="assets/logo/logo.png" alt="Logo">
            </a>
        </div>
        <nav class="navbar navbar-expand">
            <div class="navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="homepage.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Shop By
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="womenswear.php?category=Womens">Women's Wear</a>
                            <a class="dropdown-item" href="menswear.php?category=Mens">Men's Wear</a>
                            <a class="dropdown-item" href="childrenswear.php?category=Childrens">Children's Wear</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="edit_profile.php">
                            <img src="<?php echo $img; ?>" alt="" width="30" height="30" class="rounded-circle">
                            <?php echo $_SESSION['username']; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="shopping-cart-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fa fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container about-container">
            <h1>About Us</h1>
            <p>Welcome to UKAY FINDS! We are an exciting e-commerce platform that brings you the best of thrift shopping right at your fingertips. Our mission is to provide a unique and sustainable shopping experience, where you can discover amazing finds at great prices.</p>
            <p>At UKAY FINDS, we curate a wide selection of pre-loved clothing, shoes, accessories, and more, offering you a treasure trove of unique and one-of-a-kind items. Each piece in our collection has been carefully sourced and quality-checked to ensure that you receive the best value for your money.</p>
            <p>Join our growing community of fashion enthusiasts and treasure hunters who appreciate the thrill of finding unique fashion items. Embrace the joy of sustainable fashion and discover the endless possibilities of UKAY FINDS.</p>
            <p>Start exploring today and uncover your own UKAY FINDS!</p>

            <h2>MEET THE PROGRAMMERS</h2>
            <div class="member">
                <img src="assets/images/member1.jpg" alt="Hannah Guevarra">
                <p>Hannah Guevarra - Designer and Frontend Developer</p>
            </div>
            <div class="member">
                <img src="assets/images/member2.jpg" alt="Lex Gustilo">
                <p>Lex Gustilo - Backend Developer and Database Manager</p>
            </div>
            <div class="member">
                <img src="assets/images/member3.jpg" alt="Alessandra Tungol">
                <p>Alessandra Tungol - Content Creator and Marketing Specialist</p>
            </div>
        </div>
    </div>

</body>
</html>
