<?php
include 'db_connect.php'; // Connect to the database
$message = ""; // Initialize message variable

// Handle form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check !== false) {
            // Only allow certain file types
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $allowed_extensions)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    // Insert product details along with the image path into the database
                    $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$target_file')";
                    if (mysqli_query($conn, $sql)) {
                        $message = "<div class='alert alert-success fade-out' id='message'>Product added successfully!</div>";
                    } else {
                        $message = "<div class='alert alert-danger fade-out' id='message'>Error: " . mysqli_error($conn) . "</div>";
                    }
                } else {
                    $message = "<div class='alert alert-danger fade-out' id='message'>Sorry, there was an error uploading your file.</div>";
                }
            } else {
                $message = "<div class='alert alert-danger fade-out' id='message'>Only JPG, JPEG, PNG, and GIF files are allowed.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger fade-out' id='message'>File is not an image.</div>";
        }
    }
}

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert alert-success fade-out' id='message'>Product deleted successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger fade-out' id='message'>Error deleting product: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch all products
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Product Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-out {
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }
        .fade-out.hidden {
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php echo $message; // Output the message ?>
        <h1 class="text-center my-5">Product Management</h1>

        <!-- Add Product Form -->
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="price">Price (Rs.)</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter product price" required>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
        </form>

        <h2 class="text-center my-5">Current Products</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price (Rs)</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><img src="<?php echo $row['image']; ?>" alt="Product Image" style="width: 100px;"></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Fade out messages after 5 seconds
        setTimeout(() => {
            const message = document.getElementById('message');
            if (message) {
                message.classList.add('hidden');
            }
        }, 5000);
    </script>
</body>
</html>
