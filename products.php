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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = nl2br($_POST['description']);
    $quantity = $_POST['quantity'];

    // Generate a random product ID
    $productId = mt_rand(100000, 999999);

    // Upload image file if provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "assets/products/"; // Directory to save the uploaded images
        $fileName = basename($_FILES['image']['name']);
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            // Image uploaded successfully, save the item details to the database
            $mysqli->query("INSERT INTO products (id, image, name, price, description, quantity, category) VALUES ('$productId', '$targetPath', '$name', '$price', '$description', '$quantity', '$category')");
            // Redirect back to products.php after saving the item
            header("Location: products.php");
            exit();
        }
    }
}

// Check if an order is successfully placed
if (isset($_GET['order_placed']) && $_GET['order_placed'] === 'true') {
    $orderId = $_GET['order_id'];

    // Retrieve the ordered quantity and product ID from the order details
    $orderDetails = $mysqli->query("SELECT * FROM tblorderdetails WHERE order_id = '$orderId'");
    while ($row = $orderDetails->fetch_assoc()) {
        $orderedQuantity = $row['quantity'];
        $productId = $row['product_id'];

        // Update the quantity of the corresponding product in the database
        $mysqli->query("UPDATE products SET quantity = quantity - $orderedQuantity WHERE id = '$productId'");
    }
}

$mysqli = new mysqli("localhost", "root", "", "dbecomm");

// Fetch all products from the database
$result = $mysqli->query("SELECT * FROM products");
$products = $result->fetch_all(MYSQLI_ASSOC);

?>

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Products</title>

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
        
        tr.even-row {
            background-color: #f2f2f2;
        }

        tr.odd-row {
            background-color: #ffffff;
        }

        tr.header-row {
            background-color: #c38154;
            color: #fff;
            font-weight: bold;
            padding: 10px;
        }

        .import-button {
            background-color: #884a39;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 2px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 5px;
        }

        .import-button:hover {
            background-color: #c38154;
        }

        .edit-button,
        .delete-button {
            width: 30px;
            height: 30px;
            justify-content: center;
            align-items: center;
            font-size: 14px;
        }

        .edit-button {
            background-color: #c38154;
            color: #fff;
        }

        .edit-button:hover {
            background-color: #ffc26f;
        }

        .delete-button {
            background-color: #884a39;
            color: #fff;
        }
        .delete-button:hover {
            background-color: #ffc26f;
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
    <div>
        <div class="dashboard_sidebar">
            <img src="assets/logo/logo.png" alt="UKAY FINDS INVENTORY Logo" class="dashboard_logo">
            <div class="dashboard_sidebar_user">
                <img src="<?=$img?>" width="20px" alt="" />
                <span>ADMIN</span>
            </div>
            <!-- Dashboard Sidebar Menus -->
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li>
                        <a href="inventory.php">Home</a>
                    </li>
                    <li>
                        <a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'products.php' ? 'active' : ''; ?>">Products</a>
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
            <div class="dashboard_content_main">
                <h1>Ukay Finds Products</h1>

                <!-- Import Items button -->
                <button type="button" class="btn btn-primary float-right import-button" data-toggle="modal" data-target="#importModal">Import Items</button>


                <!-- Import Items modal -->
                <div class="modal" id="importModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Add an Item</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="image">Upload image</label>
                                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">&#8369;</span>
                                        </div>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="0.0" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="Womens">Womens</option>
                                        <option value="Mens">Mens</option>
                                        <option value="Kids">Kids</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product List -->
                <?php if (count($products) === 0): ?>
                    <p>No products available.</p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr class="header-row">
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Available</th>
                                
                                <th>Action</th> <!-- New column for Edit and Delete buttons -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $index => $product): ?>
                                <tr class="<?php echo ($index % 2 === 0) ? 'even-row' : 'odd-row'; ?>">
                                    <td><?=$product['id']?></td>
                                        <td><img src="<?=$product['image']?>" alt="Product Image" width="100px"></td>
                                        <td><?=$product['name']?></td>
                                        <td>&#8369;<?= number_format($product['price'], 2) ?></td>
                                        <td><?=$product['category']?></td>
                                        <td><?=$product['description']?></td>
                                        <td><?=$product['available']?></td>
                                    <td>
                                        <!-- Edit button -->
                                        <a href="edit_product.php?id=<?=$product['id']?>" class="btn btn-primary btn-sm edit-button"><i class="fa fa-pencil"></i></a>
                                                        
                                        <!-- Delete button -->
                                        <a href="delete_product.php?id=<?=$product['id']?>" class="btn btn-danger btn-sm delete-button" onclick="return confirm('Are you sure you want to delete this product?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            var form = document.getElementById("importForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }

        function toggleForm() {
            $('#importModal').modal('toggle');
        }
    </script>

</body>
</html>
