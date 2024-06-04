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

// Fetch the counts from the database
$userCount = $mysqli->query("SELECT COUNT(*) as count FROM tblregusers WHERE username != 'admin'")->fetch_assoc()['count'];
$productCount = $mysqli->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$orderCount = $mysqli->query("SELECT COUNT(*) as count FROM tblorders")->fetch_assoc()['count'];
$pendingOrderCount = $mysqli->query("SELECT COUNT(*) as count FROM tblorders WHERE status = 'Pending'")->fetch_assoc()['count'];
$completedOrderCount = $mysqli->query("SELECT COUNT(*) as count FROM tblorders WHERE status = 'complete'")->fetch_assoc()['count'];
$pendingOrderCount = $mysqli->query("SELECT COUNT(*) as count FROM tblorders WHERE status = 'pending'")->fetch_assoc()['count'];

$result = $mysqli->query("SELECT * FROM tblregusers WHERE username = 'admin'");
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $img = $row['image'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/0c7a3095b5.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Inventory</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
        }

        .dashboard_sidebar {
            width: 200px;
            height: 100vh;
            background-color: #c38154;
            color: #fff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
        }

        .dashboard_logo {
            width: 100px; /* Update the width as desired */
            height: auto; /* Adjust height automatically */
            margin-bottom: 20px;
            text-align: center;
        }

        .dashboard_sidebar_user {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard_sidebar_user img {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .dashboard_sidebar_user span {
            font-size: 18px;
        }

        .dashboard_sidebar_menus {
            flex-grow: 1;
            width: 100%;
        }

        .dashboard_menu_lists {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dashboard_menu_lists li {
            margin-bottom: 10px;
        }

        .dashboard_menu_lists a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dashboard_menu_lists a:hover {
            background-color: #884a39;
        }

        .dashboard_topNav {
            top: 0;
            left: 200px;
            right: 0;
            background-color: #c38154;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            position: fixed;
            z-index: 2;
        }

        .dashboard_topNav a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
        }

        .dashboard_topNav .fa {
            font-size: 24px;
            margin-right: 10px;
            cursor: pointer;
        }

        .dashboard_topNav .logout {
            margin-left: auto;
        }

        .dashboard_content {
            margin-left: 200px;
            padding: 80px 20px 20px;
        }

        .dashboard_content_main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .dashboard_card {
            width: calc(33.33% - 20px);
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
        }

        .dashboard_card h2 {
            font-size: 30px;
            margin-bottom: 10px;
            color: #fff;
        }

        .dashboard_card p {
            font-size: 20px;
            color: #888;
        }

        .dashboard_card .big-number {
            font-size: 70px;
            font-weight: bold;
            color: #c38151;
            margin-bottom: 10px;
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-1 {
            background-color: #884a39; /* Example color */
        }

        .card-2 {
            background-color: #ffc26f; /* Example color */
        }

        .card-3 {
            background-color: #884a39; /* Example color */
        }

        .card-4 {
            background-color: #ffc26f; /* Example color */
        }

        .card-5 {
            background-color: #884a39; /* Example color */
        }

        .card-6 {
            background-color: #ffc26f; /* Example color */
        }

        .active {
            background-color: #884a39;
        }

        @media (max-width: 768px) {
            .dashboard_content {
                margin-left: 0;
                padding-top: 160px;
            }

            .dashboard_topNav {
                left: 0;
            }
        }

        .dashboard_sidebar_hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .dashboard_content {
                margin-left: 0;
                padding-top: 160px;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var $sidebar = $(".dashboard_sidebar");
            var $content = $(".dashboard_content");
            var $topNav = $(".dashboard_topNav");

            $(".dashboard_topNav .fa-navicon").click(function() {
                $sidebar.toggleClass("dashboard_sidebar_hidden");

                if ($sidebar.hasClass("dashboard_sidebar_hidden")) {
                    $content.animate({
                        "margin-left": "0"
                    });
                    $topNav.animate({
                        "left": "0"
                    });
                } else {
                    $content.animate({
                        "margin-left": "200px"
                    });
                    $topNav.animate({
                        "left": "200px"
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="dashboard_sidebar">
        <img src="assets/logo/logo.png" alt="UKAY FINDS INVENTORY Logo" class="dashboard_logo">
        <div class="dashboard_sidebar_user">
            <img src="<?=$img?>" width="75" height="75" alt="Profile Image" />
            <span>ADMIN</span>
        </div>
        <div class="dashboard_sidebar_menus">
            <ul class="dashboard_menu_lists">
                <li>
                    <a href="inventory.php" <?php if(basename($_SERVER['PHP_SELF']) == 'inventory.php') echo 'class="active"'; ?>>Home</a>
                </li>
                <li>
                    <a href="products.php">Products</a>
                </li>
                <li>
                    <a href="customers.php">Customers</a>
                </li>
                <li>
                    <a href="orders.php">Orders</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="dashboard_content">
        <div class="dashboard_topNav">
            <i class="fa fa-navicon"></i>
            <div class="logout">
                <a href="logout.php"><i class="fa fa-power-off"></i> Log-out</a>
            </div>
        </div>

        <h1>Inventory Dashboard</h1>
        <div class="dashboard_content_main">
            <a href="manage_admin.php" class="dashboard_card card-1">
                <h2>Admin</h2>
                <p>Manage administrators</p>
            </a>
            <a href="customers.php" class="dashboard_card card-2">
                <h2>Registered Users</h2>
                <p><span class="big-number"><?=$userCount?></span> registered users</p>
            </a>
            <a href="products.php" class="dashboard_card card-3">
                <h2>Products</h2>
                <p><span class="big-number"><?=$productCount?></span> products</p>
            </a>
            <a href="orders.php" class="dashboard_card card-4">
                <h2>Orders</h2>
                <p><span class="big-number"><?=$orderCount?></span> Orders</p>
            </a>
            <a href="completed_orders.php" class="dashboard_card card-5">
                <h2>Completed Orders</h2>
                <p><span class="big-number"><?=$completedOrderCount?></span> completed order(s)</p>
            </a>
            <a href="pending_orders.php" class="dashboard_card card-6">
                <h2>Pending Orders</h2>
                <p><span class="big-number"><?=$pendingOrderCount?></span> pending order(s)</p>
            </a>

        </div>
    </div>
</body>
</html>
