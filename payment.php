<?php
session_start();

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure the path to autoload.php is correct

// Function to send email
function send_email($to, $subject, $body) {
    $mail = new PHPMailer(true);
    
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = ''; // Your email
        $mail->Password = ''; // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('maheeshasandesh126@gmail.com', 'City Care Hospital'); // Your email
        $mail->addAddress($to); // Recipient email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Enable verbose debug output
        $mail->SMTPDebug = 2; // Enable verbose debug output

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        error_log("Error sending email: " . $mail->ErrorInfo);
        return false; // Email failed to send
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $cardNumber = $_POST['cardNumber'];
    $cardExpiry = $_POST['cardExpiry'];
    $cardCVC = $_POST['cardCVC'];
    $cardName = $_POST['cardName'];
    $userEmail = $_SESSION['email']; // Assuming the user's email is stored in the session

    // Debug: Log the user's email
    error_log("User Email: " . $userEmail); // Check if this is the correct email

    // Here you would process the payment with your payment gateway
    // If the payment is successful:
    $paymentSuccess = true; // This should be determined by your payment processing logic

    if ($paymentSuccess) {
        // Send email confirmation
        $message = "<h1>Payment Successful</h1>
                    <p>Thank you for your payment of LKR [amount]! Your order is being processed.</p>";
        
        // Debug: Log the message being sent
        error_log("Sending email to: $userEmail");

        if (send_email($userEmail, "Payment Confirmation", $message)) {
            echo "<div class='alert alert-success'>Payment successful and confirmation email sent!</div>";
        } else {
            echo "<div class='alert alert-warning'>Payment successful, but failed to send confirmation email.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Payment failed. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | City Care Hospital</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/payment.css">
</head>
<body>
    <!-- Header -->
    <?php include 'Header.php'; ?>

    <!-- Payment Information -->
    <div class="container payment-container">
        <h1 class="text-center mb-4">Payment Information</h1>
        
        <div class="card-payment-container">
            <form id="payment-form" method="POST" action="">
                <div class="form-group">
                    <label for="cardNumber">Card Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="1234 1234 1234 1234" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <img id="card-type-icon" src="https://img.icons8.com/ios-filled/24/ffffff/bank-card-back-side.png" class="card-icon" alt="Card Icon">
                            </span>
                        </div>
                    </div>
                    <div id="cardNumberError" class="error-message"></div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cardExpiry">Expiry Date</label>
                        <input type="text" class="form-control" id="cardExpiry" name="cardExpiry" placeholder="MM/YY" required>
                        <div id="cardExpiryError" class="error-message"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="cardCVC">CVC</label>
                        <input type="text" class="form-control" id="cardCVC" name="cardCVC" placeholder="CVC" required>
                        <div id="cardCVCError" class="error-message"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cardName">Cardholder Name</label>
                    <input type="text" class="form-control" id="cardName" name="cardName" placeholder="John Doe" required>
                    <div id="cardNameError" class="error-message"></div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Footer -->
    <?php include 'Footer.php'; ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="javascript/payment.js"></script>
</body>
</html>
