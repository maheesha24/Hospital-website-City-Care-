<?php
session_start();
include 'db_connect.php'; 

// Handle adding a new blog
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_blog'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $image = $_FILES['image']['name'];

    // Move uploaded image to the 'uploads' folder
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $query = "INSERT INTO blogs (title, content, author, image_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $title, $content, $author, $target_file);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Blog added successfully!";
            $_SESSION['message_type'] = "success"; // Message type for success
            header("Location: add_blog.php");
            exit();
        } else {
            $_SESSION['message'] = "Error: " . $conn->error;
            $_SESSION['message_type'] = "error"; // Message type for error
        }
    } else {
        $_SESSION['message'] = "Failed to upload image.";
        $_SESSION['message_type'] = "error"; // Message type for error
    }
}

// Handle editing a blog
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_blog'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $target_file = $_POST['current_image']; // Keep the current image if not uploaded
    }

    $query = "UPDATE blogs SET title = ?, content = ?, author = ?, image_path = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $title, $content, $author, $target_file, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Blog updated successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: add_blog.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
}

// Handle deleting a blog
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Blog deleted successfully!";
        $_SESSION['message_type'] = "success";
        header("Location: add_blog.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
}

// Fetch all blogs
$query = "SELECT * FROM blogs";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Edit/Delete Blog</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .alert {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 9999;
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h2>Add/Edit/Delete Blog</h2>

        <!-- Display Success/Error Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        <?php endif; ?>

        <!-- Add Blog Form -->
        <form action="add_blog.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" name="add_blog" class="btn btn-primary">Add Blog</button>
        </form>

        <hr>

        <!-- List Existing Blogs -->
        <h3>Existing Blogs</h3>
        <div class="row">
            <?php while ($blog = $result->fetch_assoc()) : ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= $blog['image_path'] ?>" class="card-img-top" alt="Blog Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= $blog['title'] ?></h5>
                            <p class="card-text"><?= substr($blog['content'], 0, 100) ?>...</p>
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#editModal<?= $blog['id'] ?>">Edit</a>
                            <a href="?delete_id=<?= $blog['id'] ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>

                <!-- Edit Blog Modal -->
                <div class="modal fade" id="editModal<?= $blog['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Blog</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="add_blog.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                    <input type="hidden" name="current_image" value="<?= $blog['image_path'] ?>">

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control" value="<?= $blog['title'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea name="content" class="form-control" rows="5" required><?= $blog['content'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <input type="text" name="author" class="form-control" value="<?= $blog['author'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <button type="submit" name="edit_blog" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".alert").delay(5000).fadeOut("slow");
        });
    </script>
</body>
</html>
