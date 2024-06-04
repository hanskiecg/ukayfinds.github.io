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
$result = $mysqli->query("SELECT * FROM tblregusers WHERE username = 'admin'");
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $img = $row['image'];
}

$result = $mysqli->query("SELECT * FROM tblorders WHERE status = 'complete'");
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/0c7a3095b5.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    
    <title>Order List</title>
    
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

        .table {
            margin-top: 20px;
        }
        
        .table thead th {
        background-color: #c38154;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        text-align: center;
        }

        .table tbody td {
            padding: 10px;
            text-align: center;
        }

        .table tbody tr:nth-child(even) {
            background-color: #ffffff;
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
                <img src="<?php echo $img; ?>" width="75px" height="75px" alt="" />
                <span>ADMIN</span>
            </div>

            <!-- Dashboard Sidebar Menus -->
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li>
                        <a href="inventory.php">Home</a>
                    </li>
                    <li>
                        <a href="products.php">Products</a>
                    </li>
                    <li>
                        <a href="customers.php">Customers</a>
                    </li>
                    <li>
                        <a href="orders.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'orders.php' ? 'active' : ''; ?>">Orders</a>
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

            <div class="dashboard_content_main">
                <h1>Ukay Finds Complete Orders</h1>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Province</th>
                            <th>ZIP Code</th>
                            <th>Phone Number</th>
                            <th>Total Price</th>
                            <th>Order Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($orders) > 0) : ?>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <td><?= $order['id'] ?? '' ?></td>
                                    <td><?= $order['first_name'] ?? '' ?> <?= $order['last_name'] ?? '' ?></td>
                                    <td><?= $order['address_line1'] ?? '' ?></td>
                                    <td><?= $order['city'] ?? '' ?></td>
                                    <td><?= $order['province'] ?? '' ?></td>
                                    <td><?= $order['zip_code'] ?? '' ?></td>
                                    <td><?= $order['phone_number'] ?? '' ?></td>
                                    <td><?= $order['total_price'] ?? '' ?></td>
                                    <td><?= $order['order_date'] ?? '' ?></td>
                                    <td><?= $order['status'] ?? '' ?></td>
                                    <td>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10">No orders yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>
</html>