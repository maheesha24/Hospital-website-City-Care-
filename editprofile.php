<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message variable
$error_message = '';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user info for editing
    $query = "SELECT first_name, last_name, email, phone, address, profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($user_first_name, $user_last_name, $user_email, $user_phone, $user_address, $user_profile_picture);
    $stmt->fetch();
    $stmt->close();

    // Handle form submission to update user info
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_first_name = $_POST['first_name'];
        $new_last_name = $_POST['last_name'];
        $new_email = $_POST['email'];
        $new_phone = $_POST['phone'];
        $new_address = $_POST['address'];

        // Prepare update query
        $update_query = "UPDATE users SET first_name=?, last_name=?, email=?, phone=?, address=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssi", $new_first_name, $new_last_name, $new_email, $new_phone, $new_address, $user_id);
        $stmt->execute();
        $stmt->close();

        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
            switch ($_FILES['profile_picture']['error']) {
                case UPLOAD_ERR_OK:
                    // No error, proceed
                    break;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $error_message = "File is too large. Maximum size is 2MB.";
                    break;

                case UPLOAD_ERR_NO_FILE:
                    $error_message = "No file was uploaded.";
                    break;


                default:
                    $error_message = "Unknown upload error. Please try again.";
                    break;
            }

            // If there's no error, proceed with further checks
            if (empty($error_message)) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);

                // Check if the file is an image
                if ($check === false) {
                    $error_message = "File is not an image.";
                } else {
                    // Check file size
                    if ($_FILES["profile_picture"]["size"] > 10000000) { // Limit to 2MB
                        $error_message = "File is too large. Maximum size is 10MB.";
                    } else {
                        // Check file type
                        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                        if (!in_array($imageFileType, $allowed_types)) {
                            $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
                        } else {
                            // Move the uploaded file
                            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                                $update_picture_query = "UPDATE users SET profile_picture=? WHERE id=?";
                                $stmt = $conn->prepare($update_picture_query);
                                $stmt->bind_param("si", $target_file, $user_id);
                                $stmt->execute();
                                $stmt->close();
                            } else {
                                $error_message = "Error moving your uploaded file.";
                            }
                        }
                    }
                }
            }
        }

        // Redirect to profile page after update
        if (empty($error_message)) {
            header("Location: profile.php");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - City Care Hospital</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
    <style>
        /* Styles for the error message */
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
<body>
<?php include 'Header.php'; ?>

<?php if (!empty($error_message)): ?>
    <div class="alert alert-danger" id="error-message">
        <?= htmlspecialchars($error_message) ?>
    </div>
<?php endif; ?>

<section class="edit-profile py-5">
    <div class="container">
        <h2 class="text-center mb-4">Edit Your Profile</h2>
        <form method="POST" enctype="multipart/form-data" class="edit-profile">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user_first_name ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user_last_name ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user_email ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user_phone ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" required><?= htmlspecialchars($user_address ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Fade out the error message after 5 seconds
        if ($('#error-message').length) {
            setTimeout(function() {
                $('#error-message').fadeOut(1000);
            }, 5000);
        }
    });
</script>
</body>
</html>
