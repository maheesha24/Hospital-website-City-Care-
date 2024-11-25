<?php
include 'db_connect.php'; // Include your database connection file

// Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fetch all contact messages
$sql = "SELECT * FROM contact_messages";
$result = mysqli_query($conn, $sql);

// Handle reply message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_message'])) {
    $id = $_POST['message_id'];
    $reply = $_POST['reply'];

    // Check if the reply is not empty
    if (empty($reply)) {
        echo "<div class='alert alert-danger fade-out'>Reply message cannot be empty!</div>";
    } else {
        // Update message with the admin's reply
        $sql = "UPDATE contact_messages SET reply = '$reply', status = 'Replied' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            // Fetch email for sending reply
            $query = "SELECT name, email FROM contact_messages WHERE id = $id";
            $result_email = mysqli_query($conn, $query);
            $email_row = mysqli_fetch_assoc($result_email);
            $to_email = $email_row['email'];

            // Send email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = '';       // SMTP username
                $mail->Password   = '';                    // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption
                $mail->Port       = 587;                                   // TCP port to connect to

                // Recipients
                $mail->setFrom('no-reply@citycarehospital.com', 'City Care Hospital');
                $mail->addAddress($to_email);                             // Add a recipient

                // Content
                $mail->isHTML(true);                                      // Set email format to HTML
                $mail->Subject = 'Reply to your contact inquiry';
                $mail->Body    = "
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                line-height: 1.6;
                                color: #333;
                            }
                            .container {
                                padding: 20px;
                                background-color: #f8f9fa;
                                border-radius: 5px;
                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                            }
                            h1 {
                                color: #007bff;
                            }
                            p {
                                margin: 10px 0;
                            }
                            .footer {
                                margin-top: 20px;
                                font-size: 0.9em;
                                color: #777;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Hello, {$email_row['name']}!</h1>
                            <p>Thank you for reaching out to us. Here is our response to your inquiry:</p>
                            <p>" . nl2br($reply) . "</p>
                            <p>If you have any further questions, feel free to contact us.</p>
                            <p>Best Regards,<br>City Care Hospital Team</p>
                            <div class='footer'>
                                <p>This is an automated response, please do not reply.</p>
                                <p>Contact us at: <a href=''></a></p>
                            </div>
                        </div>
                    </body>
                    </html>
                ";

                $mail->send();
                echo "<div class='alert alert-success fade-out'>Reply sent successfully!</div>";
            } catch (Exception $e) {
                echo "<div class='alert alert-danger fade-out'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            echo "<div class='alert alert-danger fade-out'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Handle delete message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_message'])) {
    $id = $_POST['message_id'];

    // Delete message from the database
    $sql = "DELETE FROM contact_messages WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success fade-out'>Message deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger fade-out'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - City Care Hospital</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admincss/contactadmin.css"> <!-- Link to your external CSS file -->
    <script>
        // Fade out alert messages after 5 seconds
        window.onload = function() {
            const alerts = document.querySelectorAll('.fade-out');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = "opacity 1s";
                    alert.style.opacity = "0";
                }, 5000); // Fade out after 5 seconds
            });
        };
    </script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Admin Dashboard</h1>

        <!-- Contact Messages Section -->
        <h2>Messages</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                            <p class="card-text"><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                            <p class="card-text"><strong>Subject:</strong> <?php echo $row['subject']; ?></p>
                            <p class="card-text"><strong>Message:</strong> <?php echo $row['message']; ?></p>
                            <p class="card-text"><strong>Reply:</strong> <?php echo $row['reply'] ? $row['reply'] : 'No reply yet'; ?></p>
                            <p class="card-text"><strong>Status:</strong> <?php echo $row['status']; ?></p>
                            <form method="POST" action="">
                                <input type="hidden" name="message_id" value="<?php echo $row['id']; ?>">
                                <textarea name="reply" class="form-control mb-2" rows="2" placeholder="Enter your reply"></textarea>
                                <button type="submit" name="reply_message" class="btn btn-primary btn-sm">Reply</button>
                                <button type="submit" name="delete_message" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
