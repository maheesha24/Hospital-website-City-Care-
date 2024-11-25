<?php
// Start output buffering and the session
ob_start();
session_start();

// Include database connection
include 'db_connect.php'; // Ensure this file connects to your database

// Initialize error arrays
$registerErrors = [];
$loginErrors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $errors = []; // To store individual field errors
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate full name
    if (empty($full_name)) {
        $errors['full_name'] = "Full name is required.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email address.";
    } elseif (empty($email)) {
        $errors['email'] = "Email is required.";
    }

    // Validate passwords
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    // Check email uniqueness
    if (empty($errors['email'])) {
        $email_check_query = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $email_check_query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors['email'] = "Email is already registered.";
        }
        mysqli_stmt_close($stmt);
    }

    // If errors exist, return them
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }

    // Proceed with registration if no errors
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $insert_query = "INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, 'patient', 'active')";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "sss", $full_name, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful!.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed. Please try again.']);
    }

    mysqli_stmt_close($stmt);
    exit;
}




// Login handler
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if the user exists
    $sql = "SELECT id, role, password, status FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Bind the result variables, including status
        mysqli_stmt_bind_result($stmt, $user_id, $role, $hashed_password, $status);
        mysqli_stmt_fetch($stmt);

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Check if the account is active
            if ($status === 'active') {
                // Set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $role;

                // Redirect based on user role
                switch ($role) {
                    case 'Admin':
                        header("Location: admin_dashboard.php");
                        break;
                    case 'Doctor':
                        header("Location: doctor_dashboard.php");
                        break;
                    case 'Staff':
                        header("Location: staff_dashboard.php");
                        break;
                    case 'patient':
                    default:
                        header("Location: patient_dashboard.php");
                        break;
                }
                exit();
            } else {
                // Account is inactive
                $loginErrors[] = "Your account has been deactivated. Please contact support.";
            }
        } else {
            $loginErrors[] = "Invalid email or password.";
        }
    } else {
        $loginErrors[] = "No account found with that email.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn); // Close the connection
ob_end_flush(); // End output buffering
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/login.css" />
    <title>Sign Up | Login Form</title>
</head>
<body>
    <section>
        <div class="container">
            <!-- Login Section -->
            <div class="user login">
                <div class="img-box">
                    <img src="images/icons/login.svg" alt="Login Icon" />
                </div>
                <div class="form-box">
                    <div class="top">
                        <p>
                            Not a member?
                            <span data-id="#ff0066">Register now</span>
                        </p>
                    </div>
                    <!-- Form for Login -->
                    <form action="" method="POST">
                        <div class="form-control">
                            <h2>Hello Again!</h2>
                            <p>Welcome back, you've been missed.</p>

                            <!-- Display any login errors here -->
                            <?php if (!empty($loginErrors)): ?>
                                <?php foreach ($loginErrors as $error): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <input type="email" name="email" placeholder="Enter Email" required />
                            <div>
                                <input type="password" name="password" placeholder="Password" required />
                            </div>
                            <span><a href="recovery.php" class="recovery">Forgot Password?</a></span>
                            <input type="submit" name="login" value="Login" />
                        </div>
                        <div class="form-control">
                            <p>Or continue with</p>
                            <div class="icons">
                                <div class="icon">
                                    <img src="images/icons/search.svg" alt="Google" />
                                </div>
                                <div class="icon">
                                    <img src="images/icons/facebook.svg" alt="Facebook" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Register Section -->
            <div class="user signup">
                <div class="form-box">
                    <div class="top">
                        <p>
                            Already a member?
                            <span data-id="#1a1aff">Login now</span>
                        </p>
                    </div>
                    <form id="register-form" method="POST">
                        <div class="form-control">
                            <h2>Welcome!</h2>
                            <p>It's good to have you.</p>
                              <!-- Registration error message -->
                              <div id="register-error" style="display:none;" class="alert alert-danger"></div>

                            <!-- Full Name input -->
                            <input type="text" name="full_name" placeholder="Enter Full Name" required /> <!-- Fixed name -->

                          

                            <input type="email" name="email" placeholder="Enter Email" required />
                            <div>
                                <input type="password" name="password" placeholder="Password" required />
                            </div>
                            <div>
                                <input type="password" name="confirm_password" placeholder="Confirm Password" required />
                            </div>
                            <input type="submit" name="register" value="Register" />
                        </div>
                        <div class="form-control">
                            <p>Or continue with</p>
                            <div class="icons">
                                <div class="icon">
                                    <img src="images/icons/search.svg" alt="Google" />
                                </div>
                                <div class="icon">
                                    <img src="images/icons/facebook.svg" alt="Facebook" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="img-box">
                    <img src="images/icons/trial.svg" alt="Trial Icon" />
                </div>
            </div>
        </div>
    </section>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="javascript/login.js"></script>
</body>
</html>
