<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Connect to the database (update with your actual database credentials)
$servername = "localhost"; // or your server name
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "hospital_db"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the user information is stored in the session after login
$user_name = 'User'; // Default name if not logged in
if (isset($_SESSION['user_id'])) {
    // Fetch user info
    $user_id = $_SESSION['user_id'];
    $query = "SELECT name FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($user_name);
    $stmt->fetch();
    $stmt->close();
    $user_name = htmlspecialchars($user_name); // Sanitize the user name
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <!-- Header -->
    <header class="header header-layout1">
        <div class="header-topbar bg-light py-2">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Contact Info -->
                            <ul class="contact__list d-flex flex-wrap align-items-center list-unstyled mb-0">
                                <li class="mr-4">
                                    <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#miniPopup-emergency">24/7 Emergency</button>
                                </li>
                                <li class="mr-4">
                                    <i class="fas fa-phone-alt"></i>
                                    <a href="tel:+201061245741" class="ml-2">Emergency Line: +94 762863425</a>
                                </li>
                                <li class="mr-4">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <a href="#" class="ml-2">Location: City Care Hospital,Matara</a>
                                </li>
                                <li class="mr-4">
                                    <i class="fas fa-clock"></i>
                                    <a href="contact-us." class="ml-2">Mon-Sun Fri: 8:00 am - 12:00 pm</a>
                                </li>
                            </ul>
                            <!-- Social Icons and Search -->
                            <div class="d-flex">
                                <ul class="social-icons list-unstyled mb-0 mr-3">
                                    <li class="mr-2"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="mr-2"><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li class="mr-2"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="images/logo/Logo.png" class="logo-light" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavigation">
                    <ul class="navbar-nav ml-auto">
                        <!-- Navigation Items -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="homeDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Home</a>
                            <div class="dropdown-menu" aria-labelledby="homeDropdown">
                                <a class="dropdown-item" href="home.php">Home Main</a>
                              
                                
                             
                                <a class="dropdown-item" href="shop.php">Home Pharmacy</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About Us</a>
                            <div class="dropdown-menu" aria-labelledby="aboutDropdown">
                               
                                <a class="dropdown-item" href="servicegrid.php">Our Services</a>
                                
                                <a class="dropdown-item" href="reviews.php">Customer Reviews</a>
                                
                                
                                <a class="dropdown-item" href="appoiment.php">Appointments</a>
                                <a class="dropdown-item" href="appilcation.php">Join with Us.</a>
                                <a class="dropdown-item" href="faq.php">Help & FAQs</a>
                               
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="doctorsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Doctors</a>
                            <div class="dropdown-menu" aria-labelledby="doctorsDropdown">
                                <a class="dropdown-item" href="doctorstimetb.php">Doctors Timetable</a>

                                <a class="dropdown-item" href="doctorsgrid.php">Our Doctors</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blog.php">Blogs</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="shopDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop</a>
                            <div class="dropdown-menu" aria-labelledby="shopDropdown">
                                <a class="dropdown-item" href="shop.php">Our Products</a>
                               
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact-us.php">Contacts</a>
                        </li>
                    </ul>
                    <!-- Departments & Appointment Button -->
                    <div class="d-flex align-items-center ml-lg-4">
                        <div class="dropdown mr-3">
                            <a class="btn btn-outline-secondary dropdown-toggle" href="departments.html" role="button" id="departmentsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Departments</a>
                            <div class="dropdown-menu" aria-labelledby="departmentsDropdown">
                                <a class="dropdown-item" href="servicegrid.php">General Medicine Clinic</a>
                                <a class="dropdown-item" href="servicegrid.php">Cardiology Clinic</a>
                                <a class="dropdown-item" href="servicegrid.php">Orthopedics Clinic</a>
                                <a class="dropdown-item" href="servicegrid.php">ENT(Ear,Nose and Throat) Clinic</a>
                                <a class="dropdown-item" href="servicegrid.php">Psychiatry and Mental Health Clinic</a>
                                <a class="dropdown-item" href="servicegrid.php">Dental Clinic</a>
                                <a class="dropdown-item" href="servicegrid.php">Obstetrics and Gynecology (OB/GYN) Clinic</a>
                            </div>
                        </div>
                        <a href="appoiment.php" class="btn btn-primary btn-rounded mr-2">
                            <i class="fas fa-calendar-alt"></i> Appointment
                        </a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="profile.php" class="btn btn-outline-primary btn-rounded">
                                <i class="fas fa-user"></i> <?= $user_name ?>
                            </a>
                            <a href="logout.php" class="btn btn-outline-danger btn-rounded logout-button">
    <i class="fas fa-sign-out-alt"></i> Logout
</a>

                            
                        <?php else: ?>
                            <a href="login.php" class="btn btn-outline-primary btn-rounded">
                                <i class="fas fa-user"></i> Login
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- End of Header -->

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-P6Z9hD/XTfd5X62+4OdGyCMO4Nf6nXi0rG4/tiSRQ/1lI4UVWl6KXqOqgQ4nZyB" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-MuWWjSRpFzU7zX32xnOCbInz24oDsoetf2iqnDQ0fn6cvW/j74TTFRk5qD8c/Cg" crossorigin="anonymous"></script>
<script src="javascript/script.js"></script>
</body>
</html>
