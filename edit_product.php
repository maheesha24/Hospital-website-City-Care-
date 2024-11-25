<?php
include 'db_connect.php'; // Connect to the database
$message = ""; // Initialize message variable

// Handle form submission for editing a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    $edit_id = $_POST['edit_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Handle file upload for edit
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
                    // Update product details along with the image path into the database
                    $sql = "UPDATE products SET name='$name', price='$price', image='$target_file' WHERE id=$edit_id";
                    if (mysqli_query($conn, $sql)) {
                        $message = "<div class='alert alert-success fade-out' id='message'>Product updated successfully!</div>";
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
    } else {
        // Update without changing the image
        $sql = "UPDATE products SET name='$name', price='$price' WHERE id=$edit_id";
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='alert alert-success fade-out' id='message'>Product updated successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger fade-out' id='message'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Fetch product details for editing
if (isset($_GET['id'])) {
    $edit_id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $edit_id";
    $product_to_edit = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    if (!$product_to_edit) {
        echo "<div class='alert alert-danger fade-out' id='message'>Product not found.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger fade-out' id='message'>No product ID provided.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        <h1 class="text-center my-5">Edit Product</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required value="<?php echo htmlspecialchars($product_to_edit['name']); ?>">
            </div>
            <div class="form-group">
                <label for="price">Price (Rs.)</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter product price" required value="<?php echo htmlspecialchars($product_to_edit['price']); ?>">
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <small>Leave blank to keep current image.</small>
            </div>
            <!-- Preview of the current product image -->
            <div class="form-group">
                <label>Current Image</label><br>
                <img src="<?php echo htmlspecialchars($product_to_edit['image']); ?>" alt="Current Product Image" style="width: 200px; height: auto;">
            </div>
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($product_to_edit['id']); ?>">
            <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
        </form>
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
