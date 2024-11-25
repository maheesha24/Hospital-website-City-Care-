<?php
include 'db_connect.php'; // Database connection

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/shop.css" rel="stylesheet">
</head>
<body>
    <?php include 'Header.php'; ?>

    <div class="container">
        <h1 class="text-center my-5">Hospital Products</h1>

        <div class="products row">
            <?php
            if ($result->num_rows > 0) {
                // Output data for each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <div class='col-md-4'>
                        <div class='product card mb-4'>
                            <img src='{$row['image']}' alt='{$row['name']}' class='card-img-top'>
                            <div class='card-body text-center'>
                                <h5 class='card-title'>{$row['name']}</h5>
                                <p class='card-text price'>Rs. {$row['price']}</p>
                                <button class='btn btn-success add-to-cart' onclick='addToCart(\"{$row['name']}\", {$row['price']})'>Add to Cart</button>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Floating Cart Button -->
    <button class="floating-cart-btn" onclick="toggleCartPopup()">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-count" class="badge badge-danger">0</span>
    </button>

    <!-- Cart Popup (Instead of Modal) -->
    <div id="cartPopup" class="cart-popup shadow">
        <h5>Your Cart</h5>
        <ul id="cartItemsList" class="list-group mb-2">
            <!-- Cart items will be dynamically added here -->
        </ul>
        <p class="text-right">Total: Rs. <span id="cartTotal">0.00</span></p>
        <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-danger" onclick="clearCart()">Clear Cart</button>
            <a href="checkout.php" class="btn btn-sm btn-primary">Checkout</a>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="javascript/shop - Copy.js"></script>
</body>
</html>
