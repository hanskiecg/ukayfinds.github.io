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

    <title>Contact</title>
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

        /* Styles for the contact form container */
        .contact-form-container {
            margin-top: 40px;
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }

        .contact-form-container h2 {
            margin-bottom: 20px;
            font-size: 50px;
            font-family: 'Zoika font', sans-serif;
        }

        .contact-form-container input[type="text"],
        .contact-form-container input[type="email"],
        .contact-form-container textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .contact-form-container textarea {
            height: 150px;
        }

        .contact-form-container button[type="submit"] {
            padding: 10px 30px;
            background-color: #884a39;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .contact-form-container button:hover {
            background-color: #ffc26f;
            color: #884a39;
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
                        <a class="nav-link" href="#" id="transactions-icon">
                            <i class="fa fa-history"></i>
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

        <div class="container">
            <div class="contact-form-container">
                <h2>Contact Us</h2>
                <form action="" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>