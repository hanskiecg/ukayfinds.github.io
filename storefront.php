<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "dbecomm");

// Check if user is logged in
$isUserLoggedIn = isset($_SESSION['username']);

$username = $isUserLoggedIn ? $_SESSION['username'] : null;

// Fetch products from the database
$categoryCondition = isset($_GET['category']) ? "WHERE category = '{$_GET['category']}' AND available = 1" : "WHERE available = 1";
$query = "SELECT * FROM products $categoryCondition";
$result = $mysqli->query($query);
$products = $result->fetch_all(MYSQLI_ASSOC);

if ($isUserLoggedIn) {
    $userQuery = "SELECT * FROM tblregusers WHERE username = '$username'";
    $userResult = $mysqli->query($userQuery);

    if ($userResult->num_rows === 1) {
        $user = $userResult->fetch_assoc();
        $img = $user['image'];
    } else {
        $img = ""; // Set a default image path or leave it empty
    }

    // Fetch the cart data for the current user
    $cartQuery = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image, p.category
                  FROM tblcart c
                  INNER JOIN products p ON c.product_id = p.id
                  WHERE c.username = '$username'";
    $cartResult = $mysqli->query($cartQuery);
    $cart = $cartResult ? $cartResult->fetch_all(MYSQLI_ASSOC) : [];
} else {
    $img = "";
    $cart = [];
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and links for stylesheets and scripts -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/0c7a3095b5.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/zoika-font" rel="stylesheet">
    <title>UKAY FINDS</title>
    <style>
        /* Custom styles */
        body { font-family: 'Poppins', sans-serif; }
        .logo-container img { width: 200px; height: 100px; }
        .navbar { background-color: #c38154; }
        .navbar-nav .nav-link { color: #fff; }
        .navbar-nav .nav-link:hover { color: #884a39; }
        .product-card { border: 1px solid #ddd; padding: 5px; margin-bottom: 10%; text-align: center; cursor: pointer; }
        .product-card img { width: 100%; height: 300px; object-fit: cover; margin-bottom: 10px; }
        .product-card .product-price { font-weight: bold; }
        .container.mt-5 h1 { font-size: 50px; }
        /* Additional media queries and styles */

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

        /* Styles for the modal */
        .modal-product-image {
            max-width: 100%;
            height: fixed;
            margin-bottom: 10px;
        }

        .modal-product-name {
            font-weight: bold;
        }

        .modal-product-price {
            margin-top: 5px;
            font-weight: bold;
        }

        .modal-product-description {
            margin-top: 10px;
        }

        .modal-product-category {
            margin-top: 10px;
        }

        .modal-product-quantity {
            margin-top: 10px;
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
                        <a class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
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
                    <?php if ($isUserLoggedIn): ?>
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
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Sign Up</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <!-- Product cards -->
        <div class="container mt-5">
            <h1>All Products</h1>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3">
                        <div class="product-card" data-toggle="modal" data-target="#productModal" data-product-id="<?php echo $product['id']; ?>">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <h4 class="product-name"><?php echo $product['name']; ?></h4>
                            <p class="product-price">₱<?php echo number_format($product['price'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Product Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="product-details">
                            <img src="" alt="Product Image" class="modal-product-image">
                            <h4 class="modal-product-name"></h4>
                            <p class="modal-product-price"></p>
                            <p class="modal-product-description"></p>
                            <p class="modal-product-category"></p>
                            <label for="productQuantity">Quantity:</label>
                            <input type="number" id="productQuantity" class="modal-product-quantity" min="1" value="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addToCartBtn">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var isUserLoggedIn = <?php echo json_encode($isUserLoggedIn); ?>;

                // Function to show product details in the modal
                function showProductDetails(product) {
                    $('.modal-product-image').attr('src', product.image);
                    $('.modal-product-name').text(product.name);
                    $('.modal-product-price').text('₱' + parseFloat(product.price).toFixed(2));
                    $('.modal-product-description').text(product.description);
                    $('.modal-product-category').text('Category: ' + product.category);
                }

                // Event listener for product cards to load product details in the modal
                $('.product-card').on('click', function() {
                    var productId = $(this).data('product-id');
                    $.ajax({
                        url: 'get_product_details.php',
                        method: 'POST',
                        data: { productId: productId },
                        dataType: 'json',
                        success: function(product) {
                            showProductDetails(product);
                            $('#productModal').modal('show');
                        },
                        error: function() {
                            alert('Failed to load product details.');
                        }
                    });
                });

                // Event listener for the Add to Cart button
                $('#addToCartBtn').on('click', function() {
                    if (!isUserLoggedIn) {
                        alert('Please log in or sign up to add items to your cart.');
                        window.location.href = 'login.php';
                        return;
                    }

                    var productId = $('#productModal').data('product-id');
                    var quantity = $('#productQuantity').val();

                    $.ajax({
                        url: 'add_to_cart.php',
                        method: 'POST',
                        data: {
                            product_id: productId,
                            quantity: quantity
                        },
                        success: function(response) {
                            alert('Product added to cart successfully.');
                            $('#productModal').modal('hide');
                        },
                        error: function() {
                            alert('Failed to add product to cart.');
                        }
                    });
                });

                // Event listener for the Shopping Cart icon
                $('#shopping-cart-icon').on('click', function(e) {
                    e.preventDefault();
                    if (isUserLoggedIn) {
                        window.location.href = 'view_cart.php';
                    } else {
                        alert('Please log in or sign up to view your cart.');
                        window.location.href = 'login.php';
                    }
                });

                // Event listener for the Transactions icon
                $('#transactions-icon').on('click', function(e) {
                    e.preventDefault();
                    if (isUserLoggedIn) {
                        window.location.href = 'transaction_history.php';
                    } else {
                        alert('Please log in or sign up to view your transactions.');
                        window.location.href = 'login.php';
                    }
                });
            });

        </script>
    </div>
</body>
</html>
