<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust the path if necessary

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to send email based on role
function sendRoleEmail($email, $name, $password, $role) {
    $mail = new PHPMailer(true);
    try {
        // Email settings (similar to what you already have)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = ''; // Your email address
        $mail->Password   = ''; // Use your app password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('your-email@gmail.com', 'City Care Hospital');
        $mail->addAddress($email); // Recipient

        $mail->isHTML(true);
        $mail->Subject = 'Your Account Creation at City Care Hospital';
        $mail->Body    = "
            <html>
                <body>
                    <h2>Hello $name,</h2>
                    <p>Your account at <strong>City Care Hospital</strong> has been created successfully.</p>
                    <p><strong>Role:</strong> $role</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Password:</strong> $password</p>
                    <p>Please log in and change your password for security purposes.</p>
                    <p>Best regards,<br>City Care Hospital Team</p>
                </body>
            </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Handle form submission for adding new users
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($role) && !empty($name) && !empty($email) && !empty($password)) {
        $check_email = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($check_email);

        if ($result->num_rows > 0) {
            $error_message = "Email already exists. Please use a different email.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (role, name, email, password, status) VALUES ('$role', '$name', '$email', '$hashed_password', 'active')";

            if ($conn->query($sql) === TRUE) {
                $email_status = sendRoleEmail($email, $name, $password, $role);
                if ($email_status === true) {
                    $success_message = "New user added successfully!";
                } else {
                    $error_message = $email_status;
                }
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    } else {
        $error_message = "Please fill in all the required fields.";
    }
}

// Handle activation/deactivation
if (isset($_GET['action']) && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'deactivate') {
        $sql = "UPDATE users SET status='inactive' WHERE id=$user_id";
    } elseif ($action == 'activate') {
        $sql = "UPDATE users SET status='active' WHERE id=$user_id";
    }

    if ($conn->query($sql) === TRUE) {
        $success_message = "User status updated successfully.";
    } else {
        $error_message = "Error updating user status: " . $conn->error;
    }
}

// Fetch all users
$users_query = "SELECT * FROM users";
$users_result = $conn->query($users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add & Manage Users | City Care Hospital</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .alert { display: none; opacity: 0; transition: opacity 0.5s ease-in-out; }
        .show { display: block; opacity: 1; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add & Manage Users</h2>

        <!-- Success/Error Messages -->
        <?php if (!empty($success_message)) { ?>
            <div class="alert alert-success show"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger show"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Add User Form -->
        <h4 class="mb-3">Add New User</h4>
        <form action="" method="POST">
            <div class="form-group">
                <label for="role">Select Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="">Choose Role</option>
                    <option value="Doctor">Doctor</option>
                    <option value="Admin">Admin</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
        </form>

        <hr>

        <!-- User Table -->
        <h4 class="mb-3">Current Users</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users_result->num_rows > 0) {
                    while ($row = $users_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo ucfirst($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'active') { ?>
                                    <a href="?action=deactivate&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Deactivate</a>
                                <?php } else { ?>
                                    <a href="?action=activate&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Activate</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr><td colspan="6">No users found.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- JS for auto-hide messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert) {
                    alert.classList.add('show');
                    setTimeout(() => { alert.classList.remove('show'); }, 5000);
                }
            });
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
