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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $available = $_POST['available'];
    $category = $_POST['category']; // Add the category variable

    // Update the product details in the database
    $mysqli->query("UPDATE products SET name='$name', price='$price', description='$description', available='$available', category='$category' WHERE id='$id'");
    
    // Redirect back to products.php after updating the product
    header("Location: products.php");
    exit();
}

// Retrieve the product details based on the ID
$id = $_GET['id'];
$result = $mysqli->query("SELECT * FROM products WHERE id='$id'");
if ($result->num_rows === 1) {
    $product = $result->fetch_assoc();
} else {
    // Product not found, redirect back to products.php
    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Edit Product</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            color: #884a39;
            font-size: 24px;
            text-align: center;
        }

        label {
            display: inline-block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #000;
        }

        .form-control {
            width: 100%;
            padding: 7px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-group-text {
            background-color: #fff;
            border: 1px solid #ced4da;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: vertical;
        }

        .btn-secondary {
            background-color: #c38154;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 2%;
        }

        .btn-primary {
            background-color: #884a39;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 2%;
        }

        .btn-secondary:hover,
        .btn-primary:hover {
            background-color: #ffc26f;
            color: #884a39;
        }

        p {
            color: #c38154;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?=$product['id']?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?=$product['name']?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">&#8369;</span>
                    </div>
                    <input type="number" class="form-control" id="price" name="price" value="<?=$product['price']?>" placeholder="0.0" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?=$product['description']?></textarea>
            </div>
            <div class="form-group">
                <label for="available">Availability:</label>
                <select class="form-control" id="available" name="available" required>
                    <option value="1" <?= ($product['available'] == 1) ? 'selected' : '' ?>>Available</option>
                    <option value="0" <?= ($product['available'] == 0) ? 'selected' : '' ?>>Not Available</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="Womens" <?= ($product['category'] === 'Womens') ? 'selected' : '' ?>>Womens</option>
                    <option value="Mens" <?= ($product['category'] === 'Mens') ? 'selected' : '' ?>>Mens</option>
                    <option value="Kids" <?= ($product['category'] === 'Kids') ? 'selected' : '' ?>>Kids</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="products.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
