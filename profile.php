<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user info
    $query = "SELECT first_name, last_name, email, phone, address, profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($user_first_name, $user_last_name, $user_email, $user_phone, $user_address, $user_profile_picture);
    $stmt->fetch();
    $stmt->close();
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
    <title>Your Profile - City Care Hospital</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<?php include 'Header.php'; ?>

<section class="profile-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Your Profile</h2>
                    </div>
                    <div class="card-body text-center">
                        <div class="profile-picture mb-4">
                            <img src="<?= htmlspecialchars($user_profile_picture ?? 'default.png') ?>" alt="Profile Picture" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px;">
                        </div>
                        <h4 class="card-title"><?= htmlspecialchars($user_first_name ?? '') ?> <?= htmlspecialchars($user_last_name ?? '') ?></h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-envelope mr-2"></i>Email: <strong><?= htmlspecialchars($user_email ?? '') ?></strong>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-phone-alt mr-2"></i>Phone: <strong><?= htmlspecialchars($user_phone ?? '') ?></strong>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-map-marker-alt mr-2"></i>Address: <strong><?= htmlspecialchars($user_address ?? '') ?></strong>
                            </li>
                        </ul>
                        <!-- Edit Profile Button -->
                        <a href="editprofile.php" class="btn btn-primary mt-4">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
