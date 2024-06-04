<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "dbecomm");

// Check for the category parameter in the URL
if (isset($_GET['category'])) {
    $category = $_GET['category'];

    // Fetch products from the database based on the category
    $query = "SELECT * FROM products WHERE category = 'Womens' AND available = 1";
    $result = $mysqli->query($query);
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Redirect to the homepage if the category parameter is not provided
    header("Location: homepage.php");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT * FROM tblregusers WHERE username = '$username'";
$result = $mysqli->query($query);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $img = $row['image'];
} else {
    // Handle the case when the user's image is not found in the database
    $img = ""; // Set a default image path or leave it empty
}

// Fetch the cart data for the current user from the database
$cartQuery = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image, p.category
              FROM tblcart c
              INNER JOIN products p ON c.product_id = p.id
              WHERE c.username = '$username'";
$cartResult = $mysqli->query($cartQuery);

if ($cartResult) {
    $cart = $cartResult->fetch_all(MYSQLI_ASSOC);
} else {
    $cart = array(); // Set an empty array as the default value
}

// Fetch the transaction history for the current user from the database
$transactionsQuery = "SELECT t.id, t.product_id, t.quantity, t.total, t.date, p.name, p.price, p.image, p.category
                      FROM tbltransactions t
                      INNER JOIN products p ON t.product_id = p.id
                      WHERE t.username = '$username'";
$transactionsResult = $mysqli->query($transactionsQuery);

if ($transactionsResult) {
    $transactions = $transactionsResult->fetch_all(MYSQLI_ASSOC);
} else {
    $transactions = array(); // Set an empty array as the default value
}

$mysqli->close();

// Handle removing a product from the cart
if (isset($_POST['index']) && isset($_POST['productId'])) {
    $index = $_POST['index'];
    $productId = $_POST['productId'];

    // Remove the product from the cart
    $removeQuery = "DELETE FROM tblcart WHERE product_id = '$productId' AND username = '$username'";
    $removeResult = $mysqli->query($removeQuery);

    if ($removeResult) {
        // Remove the product from the $cart array
        unset($cart[$index]);

        // Reset the array keys after removing the product
        $cart = array_values($cart);

        // Send the updated cart data as a response
        echo json_encode($cart);
        exit();
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-y/KcRVRXqGc9Q8GVvtVeQV8gX0fj1ff9qHCpKzDJvZMzX+R29f2dbDHAThD8CwIZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/zoika-font" rel="stylesheet">

    <title>UKAY FINDS</title>

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

        /* Styling for product cards */
        .product-card {
            border: 1px solid #ddd;
            padding: 5px;
            margin-bottom: 10%;
            text-align: center;
            margin-top: 10%;
            cursor: pointer;
            /* Add cursor pointer to indicate it's clickable */
        }

        .product-card img {
            width: 100%;
            height: 300px; /* Adjust the height as desired */
            object-fit: cover;
            object-position: center;
            margin-bottom: 10px;
        }

        .product-card .product-price {
            font-weight: bold;
        }

        .container.mt-5 h1 {
            margin-top: 0%;
            font-size: 50px;
            font-family: 'Zoika font', sans-serif;
        }

        /* Styles for desktop screens */
        @media (min-width: 1024px) {
            /* Adjust styles for larger screens */
        }

       /* Styles for the modal */
       /*.modal-dialog {
            max-width: 800px; 
            width: 100%; 
            margin: 1.75rem auto;
        }

        .modal-content {
            width: 100%;
        }*/
        
        .modal-product-image {
            max-width: 100%;
            height: auto;
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

        <!-- Product cards -->
        <div class="container mt-5">
            <h1>Women's Wear</h1>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <?php
                foreach ($products as $product) {
                    echo '
                    <div class="col-md-3">
                        <div class="product-card" data-toggle="modal" data-target="#productModal" data-product-id="' . $product['id'] . '">
                            <img src="' . $product['image'] . '" alt="' . $product['name'] . '">
                            <h4 class="product-name">' . $product['name'] . '</h4>
                            <p class="product-price">₱' . number_format($product['price'], 2) . '</p>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>

        <!-- Product Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="" alt="" class="modal-product-image">
                                </div>
                                <div class="col-md-6">
                                    <h4 class="modal-product-name"></h4>
                                    <p class="modal-product-price"></p>
                                    <p class="modal-product-description"></p>
                                    <p class="modal-product-category"></p>
                                    <p class="modal-product-quantity"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-add-to-cart">Add to Cart</button>
                        <p class="text-success" id="successMessage" style="display: none;">Product added to cart!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Modal -->
        <div class="modal fade" id="transactionsModal" tabindex="-1" role="dialog" aria-labelledby="transactionsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionsModalLabel">Transaction History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Table to display transaction history -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="transactions-table-body">
                                <?php foreach ($transactions as $transaction) { ?>
                                    <tr>
                                        <td><?php echo $transaction['id']; ?></td>
                                        <td><?php echo $transaction['name']; ?></td>
                                        <td><?php echo '₱' . number_format($transaction['price'], 2); ?></td>
                                        <td><?php echo $transaction['quantity']; ?></td>
                                        <td><?php echo '₱' . number_format($transaction['total'], 2); ?></td>
                                        <td><?php echo $transaction['date']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shopping Cart Modal -->
        <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Shopping Cart</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-table-body">
                            <?php foreach ($cart as $index => $product) { ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="50">
                                    </td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo '₱' . number_format($product['price'], 2); ?></td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td><?php echo '₱' . number_format($product['price'] * $product['quantity'], 2); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-danger btn-remove-from-cart" data-index="<?php echo $index; ?>"```php
                                        data-product-id="<?php echo $product['product_id']; ?>">Remove</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>


                        </table>
                    </div>
                    <div class="modal-footer">
                        <!-- Total -->
                        <p id="cart-total">Total: ₱0.00</p>

                        <!-- Checkout button -->
                        <form action="checkout.php" method="post">
                            <button type="submit">Checkout</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Variables to store the selected product details
            var selectedProductId = null;
            var selectedProductName = null;
            var selectedProductPrice = null;

            // When a product card is clicked, retrieve its details and display them in the modal
            $('.product-card').click(function () {
                selectedProductId = $(this).data('product-id');
                var product = getProductDetails(selectedProductId);
                displayProductDetails(product);
                $('#successMessage').hide(); // Hide the success message when the modal is opened
            });

            // Add product to cart
            $('.btn-add-to-cart').click(function () {
                if (selectedProductId !== null) {
                    $.ajax({
                        url: 'add_to_cart.php',
                        type: 'POST',
                        data: {
                            productId: selectedProductId
                        },
                        success: function (response) {
                            console.log('Product added to cart');
                            $('#successMessage').show(); // Show the success message
                            updateCartContents(); // Update the cart contents
                        }
                    });
                }
            });

            // Remove item from the shopping cart
            $(document).on('click', '.btn-remove-from-cart', function () {
                var index = $(this).data('index');
                var productId = $(this).data('product-id');

                // Remove the product from the cart in the current page
                $('.modal-body table tbody tr:eq(' + index + ')').remove();

                // Update the cart total
                updateCartTotal();

                // Send an AJAX request to remove the product from the database
                $.ajax({
                    url: 'remove_from_cart.php',
                    type: 'POST',
                    data: {
                        index: index,
                        productId: productId
                    },
                    success: function (response) {
                        if (response === 'success') {
                            console.log('Product removed from cart');

                            // Update the cart contents after successful removal
                            updateCartContents();
                        } else {
                            console.log('Failed to remove product from cart');
                        }
                    }
                });
            });

            // Function to update the cart contents
            function updateCartContents() {
                $.ajax({
                    url: 'cart_content.php',
                    type: 'GET',
                    success: function (response) {
                        $('#cart-table-body').html(response);

                        // Check if the response contains 'No items in the cart.'
                        if (response.indexOf('No items in the cart.') !== -1) {
                            // Hide the cart total and checkout button
                            $('#cart-total').hide();
                            $('.btn-checkout').hide();
                        } else {
                            // Update the cart total
                            updateCartTotal();
                        }
                    }
                });
            }

            // Update the cart total
            function updateCartTotal() {
                var total = 0;
                $('.modal-body table tbody tr').each(function () {
                    var price = parseFloat($(this).find('td:nth-child(3)').text().replace('₱', '').replace(',', ''));
                    var quantity = parseInt($(this).find('td:nth-child(4)').text());
                    total += price * quantity;
                });

                // Format the total with comma as thousands separator and 2 decimal places
                var formattedTotal = '₱' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $('#cart-total').text('Total: ' + formattedTotal);
            }

            // Function to retrieve product details from the server
            function getProductDetails(productId) {
                var product = null;
                $.ajax({
                    url: 'get_product_details.php',
                    type: 'POST',
                    async: false,
                    data: {
                        productId: productId
                    },
                    success: function (response) {
                        product = JSON.parse(response);
                    }
                });
                return product;
            }

            // Function to display product details in the modal
            function displayProductDetails(product) {
                if (product !== null) {
                    $('.modal-product-image').attr('src', product.image);
                    $('.modal-product-name').text(product.name);
                    $('.modal-product-price').text('₱' + parseFloat(product.price).toFixed(2));
                    $('.modal-product-description').html(nl2br(product.description));
                    $('.modal-product-category').text('Category: ' + product.category);
                    $('.modal-product-quantity').text('Quantity: ' + product.quantity);
                    $('.btn-add-to-cart').attr('data-product-id', product.id);

                    // Update the selected product variables
                    selectedProductId = product.id;
                    selectedProductName = product.name;
                    selectedProductPrice = product.price;
                }
            }

            // Function to convert newlines to HTML line breaks
            function nl2br(str) {
                return str.replace(/(\r\n|\r|\n)/g, "<br>");
            }

            // When the shopping cart icon is clicked, open the cart modal
            $('#shopping-cart-icon').click(function () {
                updateCartContents(); // Update the cart contents
                $('#cartModal').modal('show');
            });

            // When the transactions icon is clicked, open the transactions modal
            $('#transactions-icon').click(function () {
                $('#transactionsModal').modal('show');
            });
        });
    </script>
</body>
</html>
